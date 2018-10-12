<?php
/*
	[CTB] (C) 2007-2009 
	$Id: cp_newreg.php 2012-12-20 16:24:08 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$_TCONFIG['denyuserreg'] && showmessage('deny_newuser_reg');

//取消注册页面，变为登录页面
if($_POST['username']) {
	//检查注册参数
	$username  = trim($_POST['username']);
	$isdisable = $_TCONFIG['userregstate'] ? 1 : 0; //禁用状态

	if(!$username || $username != addslashes($username)) {
		showmessage('profile_email_illegal');
	}

	$password = md5($password);

	//判断 用户手机是不是存在
	/*$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE CusPhone='$username'");
	if ($member=$_TGLOBAL['db']->fetch_array($query)) {
		showmessage_ajax(array('error' => '错误：手机号码已存在！'));
	}*/

	//判断手机校验码
	if ($_SESSION['mobilecode'] != $_POST['mobilecode']) {
		showmessage_ajax(array('error' => '手机验证码输入错误'));
	}
	
	$arr = array(
			'CustomerID'       => 	makecustomrno(),
			'Openid'           => 	$_SESSION['member']['openid'],   //注册登录自动获取信息
			'CusName'          => 	$_SESSION['member']['nickname'],  //注册登录自动获取信息
			'CusPhone'         => 	$username,
			'PlateNumber'      => 	'',
			'Balance'          => 	0,
			'Sex'              => 	$_SESSION['member']['sex'],    //注册登录自动获取信息
			'Age'              => 	0,
			//'zone'             => 	$_SESSION['member']['province'].$_SESSION['userinfo']['city'],
			'HomeAddress'      => 	'',
			'Status'           => 	1,
			'LogTime'          => 	$_TGLOBAL['timestamp'],
			'usertype'         => 	1,
			'img'			   => $_SESSION['member']['headimgurl'],
			);
			
	//判断用户手机号是不是存在
	$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE CusPhone='$username'");
	if (!$member=$_TGLOBAL['db']->fetch_array($query)) {
		//如果不存在
		$id = inserttable('members', $arr, 1);
		$CustomerID = $arr['CustomerID'];
		//$ok = '用户注册成功！';
	}else{
		updatetable('members', array('Openid' => $_SESSION['member']['openid']), array('CusPhone'=>$username ));
		$CustomerID = $member['CustomerID'];
		//$ok = '用户登录成功！';
	}
	
	
	//判断用户是不是存在车辆信息
	echo $count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('member_car')." 
															WHERE CustomerID='$CustomerID' "), 0);
	
	if($count){
		$jumpto = 'index.php?do=index';
	}else{
		//$jumpto = 'index.php?do=newreg&op=ok'; //中间页面不要，直接跳转都绑定车辆页面
		$jumpto = 'index.php?do=caradd';
	}
	
	showmessage_ajax(array('ok' => $ok, 'jumpto' => $jumpto));
	
} 

if($_GET['op'] == 'ok'){
	echo template('newreg_ok', get_defined_vars());
	die;
}




echo template('newreg', get_defined_vars());
?>