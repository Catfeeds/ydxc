<?php

/*
  [CTB] (C) 2007-2009 copytaobao.com
  $Id: json.php 2010-6-21 23:15:43 jerry $
 */

//通用文件
include_once('./common.php');

!$_POST['SessionType'] && die('Parameter error');

//file_put_contents('post.txt', @json_encode($_POST, 'FILE_APPEND'));
//允许的方法
$dos = array(
    '8193', //客户端出入场
    '4096', //客户端停车场信息
    'KEEP_LIVE', //服务端心跳结构
    '12297', //预收费 出门前 判断有无进场记录 点击后，判断用户余额、优惠券、微支付，支付完成后 调用 15 服务端预交费通知返给道闸
    '12289', //心跳包
    '12304', //预缴费返回
);

$do = $_POST['SessionType'];
!in_array($do, $dos) && die('Access Denied');

$func_name = 'get_' . $do;
$func_name();


/* * **************************
  客户端出入场
 * ************************** */

function get_8193() {
    if ($_POST['EnterExitType'] == 1 || $_POST['EnterExitType'] == 3) {
        get_MSG_ENTER();
    }

    if ($_POST['EnterExitType'] == 2 || $_POST['EnterExitType'] == 4) {
        get_MSG_OUT();
    }
}

/* * **************************
  客户端入场
 * ************************** */

function get_MSG_ENTER() {
    global $_TGLOBAL;

    //根据车牌号取出客户ID，如果客户ID不存在，则产生新客户ID， 同时绑定此车辆
    $CustomerID = GetCustomerID($_POST['PlateNumber']);

    //如果有余额参数，则进行扣款操作
    //3的时候才写出数据库　1只返回结果
    if ($_POST['EnterExitType'] == 3) {
        $arr = array(
            'CustomerID' => $CustomerID,
            'ParkNumber' => $_POST['ParkNumber'], //停车场编号
            'PlateNumber' => $_POST['PlateNumber'], //车牌号
            'EnterExitType' => $_POST['EnterExitType'], //进出类型见附录定义
            'EnterExitTime' => $_POST['EnterTime'], //入场时间为Unix时间戳
            'FeeMoney' => $_POST['ReceiveMoney'], //入场收费
            'PaidStatus' => $_POST['PaidStatus'],
            'LogTime' => $_TGLOBAL['timestamp']
        );
        $msgid = inserttable('park_enter_msg', $arr, 1);
        template_enter($_POST['PlateNumber'], 'enter', 0, $msgid, $_POST['ParkNumber']); //发送进场记录
    }

    //返回
    $AccountBalance = floatval(getcount('members', "CustomerID='$CustomerID'", 'Balance')); //得到用户余额
    
    $SettlementType = getcount('member_car', "CarNumber='$_POST[PlateNumber]'",'BindPay');; //取出车辆是否绑定自动支付
    
    $return = array(
        'SessionNumber' => intval($_POST['SessionNumber']),
        'SessionType' => PARK_MSG_ENTER_EXIT, //将十进制转换成16进制
        'AssociateKey' => intval($_POST['AssociateKey']),
        'ParkNumber' => intval($_POST['ParkNumber']),
        'PlateNumber' => $_POST['PlateNumber'],
        'EnterExitType' => intval($_POST['EnterExitType']),
        'CustomerType' => intval($_POST['CustomerType']),
        'EnterDeviceNumber' => intval($_POST['EnterDeviceNumber']),
        'ExitDeviceNumber' => intval($_POST['ExitDeviceNumber']),
        'PrepayMoney' => floatval($_POST['PrepayMoney']),
        'AccountBalance' => $AccountBalance,
        'OperateResult' => 1,
        'ResultDiscription' => $_POST['ResultDiscription'],
        'TotalSpaceNumber' => intval($_POST['TotalSpaceNumber']),
        'BlankSpaceNumber' => intval($_POST['BlankSpaceNumber']),
        'TotalPlateNumber' => intval($_POST['TotalPlateNumber']),
        'FixPlateNumber' => intval($_POST['FixPlateNumber']),
        'TempPlateNumber' => intval($_POST['TempPlateNumber']),
        'ReserveName' => $_POST['ReserveName'],
        'ResreveInt' => intval($_POST['ResreveInt']),
        'SettlementType'  => intval($SettlementType) //绑定自动支付
    ); //var_dump($return);exit;

    $return = makearray($return);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    return true;
}

/* * **************************
  客户端出场
 * ************************** */

function get_MSG_OUT() {
    global $_TGLOBAL;

    //根据车牌号获取客户ID
    $CustomerID = GetCustomerID($_POST['PlateNumber']);

    //判断用户是否己出场
    if ($info = $_TGLOBAL['db']->getrow("SELECT *
										  FROM " . tname('park_enter_msg') . "
                                          WHERE PlateNumber='$_POST[PlateNumber]'
										  ORDER BY ID DESC LIMIT 0,1
										  ")) {

        if ($info['PaidStatus'] == 1) {
            $is_out = 1;
            if ($_POST['EnterExitType'] == 4) {
                $is_out = 2;
                //return ;
            }
        }
    }

    if ($is_out == 1 || $is_out == 2) {
        template_enter($info['PlateNumber'], 'out', $info['FeeMoney'], $info['id'], $info['ParkNumber']); //离场信息
    }

    if ($is_out != 2 && $is_out != 1) {
        $arr = array(
            'CustomerID' => $CustomerID,
            'ParkNumber' => $_POST['ParkNumber'], //停车场编号
            'PlateNumber' => $_POST['PlateNumber'], //车牌号
            'EnterExitType' => $_POST['EnterExitType'], //进出类型见附录定义
            'EnterExitTime' => $_POST['ExitTime'], //出场时间为Unix时间戳
            'FeeMoney' => $_POST['ReceiveMoney'], //入场收费
            'PaidStatus' => $_POST['PaidStatus'],
            'LogTime' => $_TGLOBAL['timestamp']
        );
        $msgid = inserttable('park_enter_msg', $arr, 1);

        $ary = array('PlateNumber' => $_POST['PlateNumber'],
            'CustomerID' => $CustomerID,
            'FeeMoney' => $_POST['ReceiveMoney'],
            'ParkNumber' => $_POST['ParkNumber'],
            'msgid' => $msgid,
        );
        makeoutcar_json($ary);
    }
    
    /*
    在此，表示己缴费，离场时，还是需要向数据库添加一条出场记录，以配合用户点微信里“我要缴费”时，出现你还未入场
    */if ($is_out == 2) {
        $arr = array(
            'CustomerID' => $CustomerID,
            'ParkNumber' => $_POST['ParkNumber'], //停车场编号
            'PlateNumber' => $_POST['PlateNumber'], //车牌号
            'EnterExitType' => $_POST['EnterExitType'], //进出类型见附录定义
            'EnterExitTime' => $_POST['ExitTime'], //出场时间为Unix时间戳
            'FeeMoney' => $_POST['ReceiveMoney'], //入场收费
            'PaidStatus' => $_POST['PaidStatus'],
            'LogTime' => $_TGLOBAL['timestamp']
        );
        inserttable('park_enter_msg', $arr, 1);
    }
        
        
    $PaidStatus = @(int) getcount('park_enter_msg', "id='$msgid'", 'PaidStatus'); //取出支付状态，返回给服务器
    //返回
    $AccountBalance = floatval(getcount('members', "CustomerID='$CustomerID'", 'Balance')); //得到用户余额
    $factmoney = $AccountBalance == NULL ? 0 : $_POST['FactMoney'];
    #判断对账
    $checkBill = chekBillMon($_POST['CheckOutTime'], $_POST['ParkNumber'], $_POST['CumulativeMoney'], $_POST['ExitTime']);
    
    $SettlementType = getcount('member_car', "CarNumber='$_POST[PlateNumber]'",'BindPay');; //取出车辆是否绑定自动支付
    
    $return = array(
        'SessionNumber' => intval($_POST['SessionNumber']),
        'SessionType' => PARK_MSG_ENTER_EXIT,
        'AssociateKey' => intval($_POST['AssociateKey']),
        'ParkNumber' => intval($_POST['ParkNumber']),
        'PlateNumber' => $_POST['PlateNumber'],
        'EnterExitType' => intval($_POST['EnterExitType']),
        'CustomerType' => intval($_POST['CustomerType']),
        'EnterDeviceNumber' => intval($_POST['EnterDeviceNumber']),
        'ExitDeviceNumber' => intval($_POST['ExitDeviceNumber']),
        'PrepayMoney' => floatval($factmoney),
        'CheckOutTime' => @(int) $checkBill["times"],
        'CumulativeMoney' => floatval($checkBill["money"]),
        'AccountBalance' => floatval($AccountBalance),
        'OperateResult' => 1,
        'ResultDiscription' => $_POST['ResultDiscription'],
        'TotalSpaceNumber' => intval($_POST['TotalSpaceNumber']),
        'BlankSpaceNumber' => intval($_POST['BlankSpaceNumber']),
        'TotalPlateNumber' => intval($_POST['TotalPlateNumber']),
        'FixPlateNumber' => intval($_POST['FixPlateNumber']),
        'TempPlateNumber' => intval($_POST['TempPlateNumber']),
        'ReserveName' => $_POST['ReserveName'],
        'ResreveInt' => intval($_POST['ResreveInt']),
        'SettlementType'  => intval($SettlementType) //绑定自动支付
    );
    $return = makearray($return);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);

    return true;
}

/* * *******
 * 检测停车场对账金额-人人优泊修改
 * ******* */

function chekBillMon($begin, $park, $money, $billtime) {
    global $_TGLOBAL;
    $SQL = "select sum(FeeMoney) as mons from " . tname('park_enter_msg');
    $SQL.= " where ParkNumber=" . $park . " and EnterExitTime>=" . $begin . " and EnterExitTime<" . $billtime;
    $info = $_TGLOBAL['db']->getrow($SQL);
    $ret["money"] = $info["mons"] != $money ? $info["mons"] : $money;
    $ret["money"] = $ret["money"] == NULL ? 0 : $ret["money"];
    $ret["times"] = $info["mons"] != $money ? $begin : $billtime;
    return $ret;
}

/* * ***************************
  根据车牌号取出客户ID，如果客户ID不存在，
  则产生新客户ID， 同时绑定此车辆
 * *************************** */

function GetCustomerID($number) {
    global $_TGLOBAL;
    if (!$number)
        return;

    if ($info = $_TGLOBAL['db']->getrow("SELECT * FROM " . tname('member_car') . " WHERE CarNumber='$number'")) {
        $userid = $info['CustomerID'];
    } else {
        /*
          //如果客户ID不存在，则产生新客户ID， 同时绑定此车辆
          $userid = makecustomrno();

          if ($$_SESSION['userinfo']['sex'] == 1) {
          $sex = '男性';
          }elseif($$_SESSION['userinfo']['sex'] == 2) {
          $sex = '女性';
          } else {
          $sex = '未知';
          }

          $arr = array(
          'CustomerID'       => 	$userid,
          'Openid'           => 	$_SESSION['userinfo']['openid'],
          'CusName'          => 	$_SESSION['userinfo']['nickname'],
          'CusPhone'         => 	'',
          'PlateNumber'      => 	$number,
          'Balance'          => 	0,
          'Sex'              => 	$sex,
          'Age'              => 	'',
          'HomeAddress'      => 	$_SESSION['userinfo']['province'].$_SESSION['userinfo']['city'],
          'Status'           => 	1,
          'LogTime'          => 	$_TGLOBAL['timestamp'],
          );
          inserttable('members', $arr);

          //绑定车辆
          $arr = array(
          'CustomerID'       => 	$userid,
          'CarID'            => 	makecarno(),
          'CarNumber'        => 	$number,
          'BindPay'          => 	0
          );
          inserttable('member_car', $arr);
         */
    }
    return $userid;
}

/* * **************************
  客户端停车场信息
 * ************************** */

function get_4096() {
    global $_TGLOBAL;


    $PropertyNumber = GetPropertyNumber($_POST['PropertyName']); //根据物业公司名称，得到物业公司的编号    
    /**
     * 20160115修改
     */
    //$info = $_TGLOBAL['db']->getrow("SELECT * FROM " . tname('park') . " WHERE ParkNumber='$_POST[ParkNumber]'");
    //停车场编号 新增为0/修改时为真实停车场编号
    if ($_POST['ParkNumber']) {
        $arr = array(
            'ParkName' => $_POST['ParkName'],
            'PropertyName' => $PropertyNumber,
            'TotalSpaceNumber' => $_POST['TotalSpaceNumber'],
            'BlankSpaceNumber' => $_POST['BlankSpaceNumber'],

            'OperateType'      => 	$_POST['OperateType'],
            'PropertyNumber'   => 	$PropertyNumber,
            'PropertyName'     => 	$PropertyNumber,
            'ParkAddress'      => 	$_POST['ParkAddress'],
            'Telephone'        => 	$_POST['Telephone'],
            'ContactMan'       => 	$_POST['ContactMan'],
            'FixSpaceNumber'   => 	$_POST['FixSpaceNumber'],
            'TempSpaceNumber'  => 	$_POST['TempSpaceNumber'],
            'BillingRule'      => 	$_POST['BillingRule'],
            'CheckoutTime'     => 	$_POST['CheckoutTime'],
            'Remark'           => 	$_POST['Remark'],
            'OperateName'      => 	$_POST['OperateName'],
            'OperateTime'      => 	$_POST['OperateTime'],
            'OperateResult'    => 	$_POST['OperateResult'],
            'ResultDiscription'  => 	$_POST['ResultDiscription'],
            'ReserveName'      => 	$_POST['ReserveName'],
            'ReverveInt'       => 	$_POST['ReverveInt']            
        );
        $number = $info["ParkNumber"];
        updatetable('park', $arr, array('ParkNumber' => $_POST['ParkNumber']));
        /**
         * 20160115修改 界止
         */
    } else {
        $tmp = $_TGLOBAL['db']->getrow("SELECT count(*) as count FROM " . tname('park'));
        $number = $tmp["count"] + 10000;
        $arr = array(
            'ParkNumber' => $number,
            'ParkName' => $_POST['ParkName'],
            'TotalSpaceNumber' => $_POST['TotalSpaceNumber'],
            'BlankSpaceNumber' => $_POST['BlankSpaceNumber'],
            'FeeType' => $_POST['FeeType'],
            'LogTime' => $_TGLOBAL['timestamp'],

            'OperateType'      => 	$_POST['OperateType'],
            'PropertyNumber'   => 	$PropertyNumber,
            'PropertyName'     => 	$PropertyNumber,
            'ParkAddress'      => 	$_POST['ParkAddress'],
            'Telephone'        => 	$_POST['Telephone'],
            'ContactMan'       => 	$_POST['ContactMan'],
            'FixSpaceNumber'   => 	$_POST['FixSpaceNumber'],
            'TempSpaceNumber'  => 	$_POST['TempSpaceNumber'],
            'BillingRule'      => 	$_POST['BillingRule'],
            'CheckoutTime'     => 	$_POST['CheckoutTime'],
            'Remark'           => 	$_POST['Remark'],
            'OperateName'      => 	$_POST['OperateName'],
            'OperateTime'      => 	$_POST['OperateTime'],
            'OperateResult'    => 	$_POST['OperateResult'],
            'ResultDiscription'  => 	$_POST['ResultDiscription'],
            'ReserveName'      => 	$_POST['ReserveName'],
            'ReverveInt'       => 	$_POST['ReverveInt']
            
        );
        inserttable('park', $arr);
    }

    //返回
    /**
     * 20160115修改
     * */
    $return = array(
        'SessionNumber' => intvaL($_POST['SessionNumber']),
        'SessionType' => PARK_MSG_BASEINFO_REG,
        'AssociateKey' => intvaL($_POST['AssociateKey']),
        'ParkNumber' => intval($number),
        "OperateType" => intval($_POST['OperateType']),
        "PropertyNumber" => intval($PropertyNumber),
        "PropertyName" => $_POST['PropertyName'],
        "ParkName" => $_POST['ParkName'],
        "ParkAddress" => $_POST['ParkAddress'],
        "Telephone" => $_POST['Telephone'],
        "ContactMan" => $_POST['ContactMan'],
        "TotalSpaceNumber" => intval($_POST['TotalSpaceNumber']),
        "FixSpaceNumber" => intval($_POST['FixSpaceNumber']),
        "TempSpaceNumber" => intval($_POST['TempSpaceNumber']),
        "BillingRule" => $_POST['BillingRule'],
        "CheckoutTime" => $_POST['CheckoutTime'],
        "Remark" => $_POST['Remark'],
        "OperateName" => $_POST['OperateName'],
        "OperateTime" => @(int) $_POST['OperateTime'],
        'OperateResult' => 1,
        'ResultDiscription' => '',
        "ReserveName" => "",
        "ReverveInt" => 0,
    );
    /**
     * 20160115修改 界止
     * */
    $return = makearray($return);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    return true;
}

/* * ***************************
  根据物业公司名称，得到物业公司的编号
 * *************************** */

function GetPropertyNumber($name) {
    global $_TGLOBAL;
    if (!$name)
        return;

    if ($info = $_TGLOBAL['db']->getrow("SELECT * FROM " . tname('Property') . " WHERE name='$name'")) {
        $number = $info['number'];
    } else {

        //物业公司id是自增长，1000起，停车场是归属于某个物业公司的，所以物业公司的id和停车场id要捆绑在一起
        $count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT MAX(number) FROM " . tname('Property')), 0);
        $class_id2 = substr($count, -3, 3);
        $number = $class_id2 + 1 + 1000;

        $arr = array(
            'number' => $number,
            'name' => $name,
        );
        inserttable('Property', $arr);
    }
    return $number;
}

/* * **************************
  接收预收费信息
  更新本地车辆收费
 * ************************** */

function get_12297() {
    global $_TGLOBAL;

    $sql = "SELECT s.ID msgid, s.FeeMoney, s.ParkNumber, s.PlateNumber, s.EnterExitType, s.PaidStatus, m.CustomerID, m.Openid
			  FROM " . tname('park_enter_msg') . " s
			  LEFT JOIN " . tname('members') . " m ON s.CustomerID=m.CustomerID
			  WHERE s.ParkNumber='$_POST[ParkNumber]' AND s.PlateNumber='$_POST[PlateNumber]'
			  ORDER BY s.ID DESC LIMIT 0,1
			  ";

    $ary = $_TGLOBAL['db']->getrow($sql);
    
    if ($ary['PaidStatus'] == 1) {
		if ($_POST['FactMoney'] <= 0) {
		  $content = "您已缴费,请尽快离场.";
          weixin_sendmessage($ary['Openid'], $content);
        }
    }
    
    //判断最后一条记录是否为进场
    if ($ary['EnterExitType'] == 3 && $_POST['FactMoney'] > 0) {

        //更新此记录收费金额
        //将收到的预收费信息json后存放，到时付款后需要返回给客户端
        $arr = array(
            'FeeMoney' => $_POST['FactMoney'],
            'json' => json_encode($_POST)
        );
        updatetable('park_enter_msg', $arr, array('id' => $ary['msgid']));


        $ary['FeeMoney'] = $_POST['FactMoney'];

        //扣款功能,1如有优惠券需先消费优惠券,优惠券不足扣余额,余额不足则需微信支付
        $coupons = getcoupons($ary['CustomerID'], $ary['FeeMoney']);
        if ($coupons) { //当有优惠券时
            if ($coupons['Fee'] >= $ary['FeeMoney']) { //当优惠券金额大于收费金额 直接扣款，然后给出提示 start
                $_TGLOBAL['db']->query("UPDATE " . tname('park_enter_msg') . " SET PaidStatus=1 WHERE id = $ary[msgid]");
                $_TGLOBAL['db']->query("UPDATE " . tname('couponslog') . " SET UseTime='$_TGLOBAL[timestamp]', Status=1 WHERE ID = '$coupons[ID]'");

                //添加支付记录明细
                $arr = array(
                    'msgid' => $ary['msgid'],
                    'CustomerID' => $ary['CustomerID'],
                    'ParkNumber' => $ary['ParkNumber'],
                    'PlateNumber' => $ary['PlateNumber'],
                    'FeeMoney' => $ary['FeeMoney'],
                    'Code' => $coupons['Fee'], //支付金额为车费
                    'couponid' => $coupons['ID'],
                    'Balance' => 0,
                    'Cash' => 0,
                    'PaidStatus' => 1,
                    'LogTime' => $_TGLOBAL['timestamp']
                );
                $payid = inserttable('paylog', $arr, 1);
                //template_enter($ary['PlateNumber'], 'out', '优惠券支付'.$ary['FeeMoney'], $ary['msgid']);
                //$return = '您的爱车 '.$ary['PlateNumber'].' 驶出天府新谷人人优泊智慧停车场，优惠券支付:'.$ary['FeeMoney'].'元';
                //通知服务器己交费
                $array = array(
                    'SessionNumber' => time(),
                    'SessionType' => 0x13010,
                    'AssociateKey' => intval($_POST['AssociateKey']),
                    'ParkNumber' => intval($ary['ParkNumber']),
                    'PlateNumber' => $ary['PlateNumber'],
                    'KeepTime' => intval($_POST['KeepTime']),
                    'ReceiveMoney' => floatval($_POST['ReceiveMoney']),
                    'DiscountMoney' => floatval($_POST['DiscountMoney']),
                    'FactMoney' => floatval($_POST['FactMoney']),
                    'Remark' => $_POST['Remark'],
                    'OperateResult' => 1,
                    'ResultDiscription' => $_POST['ResultDiscription'],
                    'ReserveName' => '',
                    'ResreveInt' => 0
                );
                $return = make_outcar_feeok($array);

                template_enter($ary['PlateNumber'], 'paied', '优惠券支付' . $ary['FeeMoney'], $payid, $ary['ParkNumber'], 0);
                return;
            } else { //当优惠券金额小于车费，车费减去优惠券金额，后面再用
                $ary['FeeMoney'] -= $coupons['Fee'];
            }
        }


        //判断余额
        $info = $_TGLOBAL['db']->getrow("SELECT id, Balance FROM " . tname('members') . " WHERE CustomerID='$ary[CustomerID]'");
        if ($info['Balance'] >= $ary['FeeMoney']) { //当用户余额大于收费金额时
            //template_enter($ary['PlateNumber'], 'out', $ary['FeeMoney']);
            //更新己支付
            $_TGLOBAL['db']->query("UPDATE " . tname('park_enter_msg') . " SET PaidStatus=1 WHERE id = $ary[msgid]");
            $_TGLOBAL['db']->query("UPDATE " . tname('couponslog') . " SET UseTime='$_TGLOBAL[timestamp]', Status=1 WHERE ID = '$coupons[ID]'");

            $array = array('uid' => $info['id'], 'op' => 'order', 'money' => -$ary['FeeMoney'], 'cur_money' => $info['Balance']);
            add_member_money($array);

            //添加支付记录明细
            $arr = array(
                'msgid' => $ary['msgid'],
                'CustomerID' => $ary['CustomerID'],
                'ParkNumber' => $ary['ParkNumber'],
                'PlateNumber' => $ary['PlateNumber'],
                'FeeMoney' => $ary['FeeMoney'],
                'Code' => $coupons['Fee'],
                'couponid' => $coupons['ID'],
                'Balance' => $ary['FeeMoney'],
                'Cash' => 0,
                'PaidStatus' => 1,
                'LogTime' => $_TGLOBAL['timestamp']
            );
            $payid = inserttable('paylog', $arr, 1);
            //template_enter($ary['PlateNumber'], 'out', '余额支付'.$ary['FeeMoney'], $ary['msgid']);
            //$return = '您的爱车 '.$ary['PlateNumber'].' 驶出天府新谷人人优泊智慧停车场，余额支付:'.$ary['FeeMoney'].'元';
            //通知服务器己交费
            $array = array(
                'SessionNumber' => time(),
                'SessionType' => 0x13010,
                'AssociateKey' => intval($_POST['AssociateKey']),
                'ParkNumber' => intval($ary['ParkNumber']),
                'PlateNumber' => $ary['PlateNumber'],
                'KeepTime' => intval($_POST['KeepTime']),
                'ReceiveMoney' => floatval($_POST['ReceiveMoney']),
                'DiscountMoney' => floatval($_POST['DiscountMoney']),
                'FactMoney' => floatval($_POST['FactMoney']),
                'Remark' => $_POST['Remark'],
                'OperateResult' => 1,
                'ResultDiscription' => $_POST['ResultDiscription'],
                'ReserveName' => '',
                'ResreveInt' => 0
            );
            $return = make_outcar_feeok($array);

            template_enter($ary['PlateNumber'], 'paied', '余额支付' . $ary['FeeMoney'], $payid, $ary['ParkNumber'], 0);
            return;
        } else { //用户余额小于收费时
            template_enter($ary['PlateNumber'], 'wxpay', $ary['FeeMoney'], $ary['msgid'], $ary['ParkNumber']);
            return;
            //添加至支付记录表 paylog
            //$return = '您的爱车 '.$ary['PlateNumber'].' 驶出天府新谷人人优泊智慧停车场，需支付:'.$ary['FeeMoney'].'元 ';
            //$url = "$_CTB[siteurl]index.php?do=pay&id=$ary[msgid]";
            //$return .= "<a href=\"$url\">点击支付</a>";
        }
    }
    /*
      //回复服务器
      $return = array(
      'SessionNumber'    => 	$_POST['SessionNumber'],
      'SessionType'      => 	$_POST['SessionType'],
      'AssociateKey'     => 	$_POST['AssociateKey'],
      'ParkNumber'       => 	$_POST['ParkNumber'],
      'PlateNumber'      => 	$_POST['PlateNumber'],
      'KeepTime'         => 	$_POST['KeepTime'],
      'ReceiveMoney'     => 	$_POST['ReceiveMoney'],
      'DiscountMoney'    => 	$_POST['DiscountMoney'],
      'FactMoney'        => 	$_POST['FactMoney'],
      'ReserveName'      => 	$_POST['ReserveName'],
      'ResreveInt'       => 	$_POST['ResreveInt']

      'SessionNumber'    => 	time(),
      'SessionType'      => 	0x13010,
      'AssociateKey'     => 	intval($_POST['AssociateKey']),
      'ParkNumber'       => 	intval($_POST['ParkNumber']),
      'PlateNumber'      => 	$_POST['PlateNumber'],
      'Remark'           => 	$_POST['Remark'],
      'OperateResult'    => 	1,
      'ResultDiscription'  => 	$_POST['ResultDiscription'],
      'ReserveName'      => 	$_POST['ReserveName'],
      'ResreveInt'       => 	intval($_POST['ResreveInt'])
      );
      $return = makearray($return);
      echo json_encode($return, JSON_UNESCAPED_UNICODE); */
}

/* * **************************
  服务端心跳结构
 * ************************** */

function get_12289() {
    global $_TGLOBAL;

    $info = $_TGLOBAL['db']->getrow("SELECT * FROM " . tname('park') . " WHERE ParkNumber='$_POST[ParkNumber]'");
    $month_user = getcount('month_user', "ParkNumber='$_POST[ParkNumber]'"); //月卡用户
    //返回
    $return = array(
        'SessionNumber' => intval($_POST['SessionNumber']),
        'SessionType' => PARK_MSG_KEEP_LIVE,
        'AssociateKey' => intval($_POST['AssociateKey']),
        'ParkNumber' => intval($_POST['ParkNumber']),
        'TotalSpaceNumber' => intval($info['TotalSpaceNumber']),
        'BlankSpaceNumber' => intval($info['BlankSpaceNumber']),
        'MonthCustomerNum' => intval($month_user),
        'TotalPlateNumber' => intval($_POST['TotalPlateNumber']),
        'FixPlateNumber' => intval($_POST['FixPlateNumber']),
        'TempPlateNumber' => intval($_POST['TempPlateNumber']),
        'LastUpdateTime' => intval($_POST['LastUpdateTime']),
        'OperateResult' => intval($_POST['OperateResult']),
        'ResultDiscription' => $_POST['ResultDiscription'],
        'ReserveName' => $_POST['ReserveName'],
        'ResreveInt' => intval($_POST['ResreveInt'])
    );
    $return = makearray($return);
    echo json_encode($return, JSON_UNESCAPED_UNICODE);
    return true;
}

/* * **************************
  预缴费返回
 * ************************** */

function get_12304() {
    global $_TGLOBAL;
    return;

    //返回
    $array = array(
        'SessionNumber' => intval($_POST['SessionNumber']),
        'SessionType' => intval($_POST['SessionType']),
        'AssociateKey' => intval($_POST['AssociateKey']),
        'ParkNumber' => intval($ary['ParkNumber']),
        'PlateNumber' => $ary['PlateNumber'],
        'Remark' => $_POST['Remark'],
        'OperateResult' => 1,
        'ResultDiscription' => $_POST['ResultDiscription'],
        'ReserveName' => '',
        'ResreveInt' => 0
    );
    //echo "<PRE>";var_dump($array);exit;
    $return = make_outcar_feeok($array);
}

//处理数组为空值
function makearray($ary) {
    foreach ($ary AS $k => $v) {
        $ary[$k] = is_null($v) ? '' : $v;
    }
    return $ary;
}

function string2euc($data) {
    $encode = mb_detect_encoding($data, array("ASCII", "EUC-CN", "UTF-8", "GB2312", "GBK", "BIG5"));
    if ($encode != "UTF-8") {
        $data = iconv('GBK', 'UTF-8', $data);
    }
    return $data;
}
