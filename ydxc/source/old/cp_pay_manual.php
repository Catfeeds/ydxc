<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_recharge.php 2010-6-21 23:18:24 jerry $
    未开启自动支付
*/

!defined('IN_CTB') && die('Access Denied');

$id = @(int)$_GET['id'];
!$id && die('error');

//用户采用手工选择优惠券和余额后
if ($_POST['manual']) {    
    //更新选择的优惠券和余额
	$_TGLOBAL['db']->query("UPDATE ".tname('park_enter_msg')." SET PaidStatus=1 WHERE id = '$id'");
    
    $payid = $_POST['payid'];
	if ($payid) {		
		$info = $_TGLOBAL['db']->getrow("SELECT p.*, m.id uid, m.Balance Balance_user
										 FROM ".tname('paylog')." p
										 LEFT JOIN ".tname('members')." m ON p.CustomerID=m.CustomerID
										 WHERE p.ID='$payid'");
		//扣除余额
		if ($info['Balance']) {
			$array = array('uid' => $info['uid'] , 'op' => 'order', 'money' => -$info['Balance'],  'cur_money' => $info['Balance_user']);
			add_member_money($array);
		}

		//更新优惠券
		if ($info['couponid']) {
			$_TGLOBAL['db']->query("UPDATE ".tname('couponslog')." SET UseTime='$_TGLOBAL[timestamp]', Status=1 WHERE ID = '$info[couponid]'");
		}
		
		//更新己支付
		$_TGLOBAL['db']->query("UPDATE ".tname('paylog')." SET PaidStatus=1 WHERE ID = '$payid'");


        $s = getcount('park_enter_msg', "id='$id'", 'json');
        $json = json_decode($s, true);
    	//通知服务器己交费
    	$array = array(
    		'SessionNumber'    => 	time(),
    		'SessionType'      => 	0x13010,
    		'AssociateKey'     => 	intval($json['AssociateKey']),
    		'ParkNumber'       => 	intval($json['ParkNumber']),
    		'PlateNumber'      => 	$json['PlateNumber'],
    		'KeepTime'         => 	intval($json['KeepTime']),
    		'ReceiveMoney'     => 	floatval($json['ReceiveMoney']),
    		'DiscountMoney'    => 	floatval($json['DiscountMoney']),
    		'FactMoney'        => 	floatval($json['FactMoney']),
    		'Remark'           => 	$json['Remark'],
    		'OperateResult'    => 	1,
    		'ResultDiscription'=> 	$json['ResultDiscription'],
    		'ReserveName'      => 	'',
    		'ResreveInt'       => 	0
    		);
    	$return = make_outcar_feeok($array);
        
		
		//给用户推荐己支付模板
		template_enter($info['PlateNumber'], 'paied', $info['FeeMoney'], $payid, $info['ParkNumber'], 0);
        
        //获取分享代码
        require_once "source/jssdk.php";
        $jssdk = new JSSDK($_TCONFIG['weixin_AppId'], $_TCONFIG['weixin_AppSecret']);
        $signPackage = $jssdk->GetSignPackage();
        
        //关闭微信页面
        echo template('closeweixin', get_defined_vars());
        exit;
    }
}


$info = $_TGLOBAL['db']->getrow("SELECT s.ParkNumber, s.FeeMoney, s.PlateNumber, s.PaidStatus, 
                                  m.Openid, m.CustomerID, m.Balance
								  FROM ".tname('park_enter_msg')." s 
								  LEFT JOIN ".tname('members')." m ON s.CustomerID=m.CustomerID
								  WHERE s.id='$id'
								  ");

//优惠券抵扣 根据客户ID，查找可用的最优惠的优惠券

//己支付，跳到己缴费
if ($info['PaidStatus']) {
    Header("Location: index.php?do=paied&id=".$id);
}

$couponid = @(int)$_GET['couponid'];

if ($couponid) {
	$ary  = $_TGLOBAL['db']->getrow("SELECT l.ID, c.Fee FROM ".tname('couponslog')." l
	LEFT JOIN ".tname('coupons')." c ON l.CouponsID=c.ID
	WHERE l.CustomerID='$info[CustomerID]'
	AND l.Status=0
	AND l.OverTime>='$_TGLOBAL[timestamp]'
	AND l.ID='$couponid'
	");
	$coupons = $ary['Fee'];
} else {
	$ary = getcoupons($info['CustomerID'], $info['FeeMoney']);
	$coupons = $ary['Fee'];
}

//余额抵扣
$Balance = $info['Balance'];
if ($coupons >= $info['FeeMoney']) { //优惠券大于车费时，不用余额
	$Balance = 0;
} else {
    $Balance = ($info['FeeMoney'] - $coupons) < $Balance ? ($info['FeeMoney'] - $coupons) : $Balance; //当支付金额大于余额时，支付金额为用户余额
}

$realmoney = $info['FeeMoney'] - $coupons - $Balance; //实际支付
$realmoney < 0 && $realmoney = 0;


//添加支付记录明细
$arr = array(
		'msgid'			   =>	$id,
		'CustomerID'       => 	$info['CustomerID'],
		'ParkNumber'       => 	$info['ParkNumber'],
		'PlateNumber'      => 	$info['PlateNumber'],
		'FeeMoney'         => 	$info['FeeMoney'],
		'Code'             => 	$coupons,
		'couponid'		   =>	$ary['ID'],
		'Balance'          => 	$Balance,
		'Cash'             => 	$realmoney,
		'PaidStatus'       => 	0,
		'LogTime'          => 	$_TGLOBAL['timestamp']
		);
$payid = inserttable('paylog', $arr, 1);


//实付金额大于0，才用微支付
if ($realmoney > 0) {

    require_once "./wxpay/example/WxPay.JsApiPay.php";
    require_once './wxpay/example/log.php';
    
    //初始化日志
    //$logHandler= new CLogFileHandler("./wxpay/logs/".date('Y-m-d').'.log');
    //$log = Log::Init($logHandler, 15);
    
    //打印输出数组信息
    function printf_info($data)
    {
    	foreach($data as $key=>$value){
    		echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    	}
    }
    
    //①、获取用户openid
    $tools = new JsApiPay();
    //$openId = $tools->GetOpenid();
    $openId = $info['Openid'];
    //$openId = 'ovwdGuCzVp7kfRxwtfeoTG1Rv_wA';
    
    $order_no = time().'_'.$id.'_'.$payid; //时间戳加上id
    //②、统一下单
    $input = new WxPayUnifiedOrder();
    $input->SetBody('人人优泊 订单：'.$order_no);
    $input->SetAttach("test");
    //$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
    
    $input->SetOut_trade_no($order_no);
    
    $input->SetTotal_fee($realmoney*100);
    //$input->SetTotal_fee("1");
    $input->SetTime_start(date("YmdHis"));
    $input->SetTime_expire(date("YmdHis", time() + 600));
    $input->SetGoods_tag("test");
    $input->SetNotify_url(getsiteurl()."notify_pay.php");
    
    $input->SetTrade_type("JSAPI");
    $input->SetOpenid($openId);
    $order = WxPayApi::unifiedOrder($input);
    $jsApiParameters = $tools->GetJsApiParameters($order);

    echo template('paycar', get_defined_vars());
} else {
    echo template('pay_manual', get_defined_vars());
}

