<?php
/*
	[CTB] (C) 2007-2009 
	$Id: cp_profile.php 2011-10-13 23:50:50 jerry $
*/
header('Content-Type: text/html; charset=utf-8');
!defined('IN_CTB') && die('Access Denied');
$openid = $_SESSION['member']['openid'];
//获取个人信息
$profile = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname("members")." WHERE openid= '$openid' ");
$profile['get_CusPhone'] = get_cardno_star($profile['CusPhone']);

//修改个人资料
if($_POST){
	
	//修改姓名
	if($_POST['CusName']) {
		updatetable('members', array('CusName'=>$_POST['CusName']), array('openid' => $openid));
		$ok = '姓名修改成功！';
	}
	
	//修改性别
	if($_POST['Sex']) {
		updatetable('members', array('Sex'=>$_POST['Sex']), array('openid' => $openid));
		$ok = '性别修改成功！';
	}
	
	//修改手机 验证码
	if($_POST['mobilecode']) {
		if($_SESSION['mobilecode'] != $_POST['mobilecode']){
			$ok = '验证码错误！';
			//$jumpto = 'index.php?do=profile&fs=tel';
			$jumpto = 'index.php';
		}else{
			$ok = '验证码正确！';
			$jumpto = 'index.php?do=profile&fs=tel&bu=2';
		}
		
	}
	
	//修改手机
	if($_POST['CusPhone']) {
		updatetable('members', array('CusPhone'=>$_POST['CusPhone']), array('openid' => $openid));
		$ok = '手机修改成功！';
	}
	
	//修改地址
	if($_POST['editaddress']) {
		$arr['zone']        = $_POST['a']." ".$_POST['b']." ".$_POST['c'];
		$arr['HomeAddress'] = $_POST['HomeAddress'];
		updatetable('members',$arr, array('openid' => $openid));
		$ok = '地址修改成功！';
	}
	
	//以下是获取代金券的  暂时注释掉
	/*
	$members = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE openid = '$openid' ");
	if($members['CusName'] && $members['CusPhone'] && $members['Sex'] && $members['HomeAddress']){
		$coupon = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('coupons')." WHERE id=3 ");
		//完善信息 获得代金券 $profile['CustomerID']  完善信息代金券id：3
		$res = insert_usercoupons($openid, 3);
		$res && $ok .= "<br/>你已经完善资料，恭喜你获得{$coupon[Fee]}元代金券！！";
	}
	*/
	
	
	/*$members = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE openid = '$openid' ");
	$Status = getcount('coupons','id=3','Status');
	if($members['CusName'] && $members['CusPhone'] && $members['Sex'] && $members['HomeAddress'] && $Status){
		$count = getcount('couponslog',"CustomerID='$members[CustomerID]' AND CouponsID=3" );
		if(!$count){
			$arr = array(
				'PromotionID'     => 0,
				'CustomerID'      => $members['CustomerID'],
				'CouponsID'       => 3,
				'ParkLog'         => 0,
				'OverTime'        => strtotime("+7 day", $_TGLOBAL['timestamp']),
				'LogTime'         => $_TGLOBAL['timestamp'],
				);
			inserttable('couponslog', $arr);  //添加代金券
		}
	}*/
	
	//$signs = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('couponslog')." WHERE CustomerID='$profile[CustomerID]' AND ");
	
	
	!$jumpto && $jumpto = 'index.php?do=profile';
	showmessage_ajax(array('ok' => $ok, 'jumpto' => $jumpto));
}

//省市县
$zone = explode(' ', $userinfo['zone']); 
if($zone[1]=='区' && $zone[1]=='区' && $zone[1]=='区'){
	$zone[1] ='';
}



//姓名修改
if($_GET['fs'] == 'name'){
	echo template('profile_name', get_defined_vars());
	die;
}

//修改性别
if($_GET['fs'] == 'sex'){
	echo template('profile_sex', get_defined_vars());
	die;
}

//修改电话
if($_GET['fs'] == 'tel'){
	$bu = $_GET['bu'];
	!$bu && $bu = 2 ;
	echo template('profile_tel_'.$bu, get_defined_vars());
	die;
}

//修改地址
if($_GET['fs'] == 'address'){
	echo template('profile_address', get_defined_vars());
	die;
}




echo template('profile', get_defined_vars());
?>