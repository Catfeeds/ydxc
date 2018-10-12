<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_index.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$openid = $_SESSION['member']['openid'];

//var_dump($openid);die;
//查看openid是不是会员
if($openid){
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE openid='$openid'");
	if (!($userinfo = $_TGLOBAL['db']->fetch_array($query))) {
		showmessage('你还没有注册，请先注册在扫描！！', 'index.php?do=newreg');
		//showmessage_ajax(array('ok'=>'users_were_not_empty_please_re_login'));
	}	
}else{
	showmessage('你还没有注册，请先注册在扫描！！', 'index.php?do=newreg');
}

//查看会员有没有领取代金券
if($userinfo){
	$CouponsID  = $_GET['CouponsID'];
	$ParkLog    = $_GET['ParkLog'];
	//如果没有代金券编号 则返回首页
	!$CouponsID && showmessage('请选择优泊的停车券扫描！！', 'index.php?do=index');
	$ParkLog    && $parkname = getcount('park', "id='$ParkLog'",'ParkName');
	!$parkname  && $parkname = '人人优泊';
	
	//获取停车券信息，用于页面显示
	$coupons = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('coupons')." WHERE id='$CouponsID' ");
	
	$Couponslog = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('couponslog')." WHERE CouponsID='$CouponsID' AND CustomerID = '$userinfo[CustomerID]'");
	if($Couponslog){
		//领取失败  已经领取这个代金券
		echo template('scan_false', get_defined_vars());
	}else{
		
		$arr = array(
			'PromotionID'     => 0,
			'CustomerID'      => $userinfo['CustomerID'],
			'CouponsID'       => $CouponsID,
			'ParkLog'         => $ParkLog, //停车场
			'OverTime'        => strtotime("+7 day", $_TGLOBAL['timestamp']),
			'LogTime'         => $_TGLOBAL['timestamp'],
			'Status'          => 0,
			);
			
		inserttable('couponslog', $arr);  //添加代金券
		//领取这个代金券成功
		echo template('scan_ok', get_defined_vars());
	}
	
}







?>