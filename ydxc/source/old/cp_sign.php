<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_sign.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$openid = $_SESSION['member']['openid'];

//签到
if($_GET['sign'] == 1){
	$sign = $_TGLOBAL['db']->getrow(" SELECT * FROM ".tname('sign')." WHERE CustomerID = '$userinfo[CustomerID]' ORDER BY LogTime DESC LImit 0,1");
	if(date('Y-m-d',$sign['LogTime']) == date("Y-m-d",$_TGLOBAL['timestamp'])){
		$return['msg'] = "对不起，你今天已经签到了！";
		$return['error'] = 1;
		$return['jumpto'] = 'index.php?do=couponslog';
		echo json_encode($return);
		die;
	}else{
		$arr = array('CustomerID'=>$userinfo['CustomerID'],'LogTime'=>$_TGLOBAL['timestamp']);
		inserttable("sign",$arr);
		$return['msg'] = "签到成功！";
		$return['error'] = 0;
		
		//每日签到 代金券id = 4
		//$Status = getcount('coupons',"id=4",'Status');
		$coupon = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('coupons')." WHERE id=4 ");
		//新表签到 送代金券和签到在一起了
		if($coupon['Status']){
			$brr = array(
					'PromotionID'    => 0, //系统发送
					'CustomerID'     => $userinfo['CustomerID'],
					'CouponsID'      => 4 , 
					'ParkLog'        => 0 , // 通用？
					'Status'         => 0 , // 未使用
					'OverTime'       => strtotime("+7 day", $_TGLOBAL['timestamp']),
					'LogTime'        => $_TGLOBAL['timestamp'],
				);
			inserttable('couponslog',$brr);
			$return['msg'] .= "<br/>你成功领取{$coupon[Fee]}元代金券！";
		}
		$return['jumpto'] = 'index.php?do=couponslog';
		echo json_encode($return);
		die;
	}

}

//领钱
if($_GET['sign'] == 2){
	//余额变化表
	/*$Balance = getcount('members',"CustomerID='$userinfo[CustomerID]'",'Balance');
	$arr = array(
			'userid'          => $userinfo['id'] ,
			'op'              => 'qd' ,
			'money'           => 1 ,
			'cur_money'       => $Balance + 1 , 
			'date'            =>$_TGLOBAL['timestamp'],
		);
	inserttable('member_money',$arr);
	//会员表
	$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET Balance=Balance+1 WHERE CustomerID='$userinfo[CustomerID]'");
	*/

	//添加到记录表
	/*$arr = array( 'uid' => $userinfo['id'],
				   'op' =>  'qd',
				   'money' => 1,
				   'cur_money' => $userinfo['Balance'],
				   'remark' => 	$_POST['remark'],
				  );
	add_member_money($arr);*/
	$coupons = $_TGLOBAL['db']->getrow(" SELECT * FROM ".tname('couponslog')." WHERE CustomerID = '$userinfo[CustomerID]' AND CouponsID=4  ORDER BY LogTime LImit 0,1");
	if(date('Y-m-d',$coupons['LogTime']) == date("Y-m-d",$_TGLOBAL['timestamp'])){
		$return['msg'] = "对不起，你今天已经领取了代金券！";
		$return['error'] = 1;
		$return['jumpto'] = 'index.php?do=couponslog';
		echo json_encode($return);
	}else{
		$arr = array(
				'PromotionID'    => 0, //系统发送
				'CustomerID'     => $userinfo['CustomerID'],
				'CouponsID'      => 4 , //每日签到
				'ParkLog'        => 0 , // 通用？
				'Status'         => 0 , // 未使用
				'OverTime'       => strtotime("+7 day", $_TGLOBAL['timestamp']),
				'LogTime'        => $_TGLOBAL['timestamp'],
			);
		inserttable('couponslog',$arr);
		$return['msg']    = "你成功领取一元代金券！";
		$return['error']  = 0;
		$return['jumpto'] = 'index.php?do=couponslog';
		echo json_encode($return);		
	}
	die;
}










//页面显示 是否已经签到
$signs = $_TGLOBAL['db']->getrow(" SELECT * FROM ".tname('sign')." WHERE CustomerID = '$userinfo[CustomerID]' ORDER BY LogTime DESC LImit 0,1");
if(date('Y-m-d',$signs['LogTime']) == date("Y-m-d",$_TGLOBAL['timestamp'])){
	$is_sign = 1;
}

//页面显示 是否已经领取代金券
$couponslog = $_TGLOBAL['db']->getrow(" SELECT * FROM ".tname('couponslog')." WHERE CustomerID = '$userinfo[CustomerID]' AND CouponsID=4 ORDER BY LogTime LImit 0,1");
if(date('Y-m-d',$signs['LogTime']) == date("Y-m-d",$_TGLOBAL['timestamp'])){
	$is_get = 1;
}

echo template('sign', get_defined_vars());
?>