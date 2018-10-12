<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_lostpass.php 2010-6-19 12:53:46 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$refer = empty($_GET['refer']) ? rawurldecode($_TCOOKIE['_refer']) : $_GET['refer'];
preg_match("/(admincp|do|cp)\.php\?do\=([a-z]+)/i", $refer, $ms);
/*
if($ms) {
	if($ms[1] != 'cp' || $ms[2] != 'sendmail') $refer = '';
}*/

if(empty($refer)) {
	$refer = 'cp.php?do=index';
}

if(submitcheck('btnsubmit')) {
	$username  = trim($_POST['username']);
	$email	   = trim($_POST['email']);
	$authinput = $_POST['authinput'];

	session_start();
	//判断校验码
	if ($_SESSION['code'] != $_POST['authinput'] || $_POST['authinput'] == "") {
		showmessage('验证码输入错误');
	}

	//判断此username是否存在
	$query = $_TGLOBAL['db']->query("SELECT uid, email FROM ".tname('members')." WHERE username='$username'");
	if (!($userinfo = $_TGLOBAL['db']->fetch_array($query))) {
		showmessage('users_were_not_empty_please_re_login');
	}

	if ($email != $userinfo['email']) {
		showmessage('你填写的邮箱与注册时的邮箱不符合，请确认！');
	}

	$newpassword = random(6, 1);
	//更新用户的密码
	$userarr = array(
			'password'        => 	md5($newpassword)
		);
	updatetable('members', $userarr, array('uid' => $userinfo['uid']));

	$subject = "你的密码已经被重设 新密码为：$newpassword";
	$message = "新密码为：$newpassword \r\n 来自：$_TCONFIG[sitename] 网址：$_CTB[siteurl]  \r\n 发送时间：".date("Y-m-d H:i", $_TGLOBAL['timestamp']);

	include_once(S_ROOT.'./source/function_sendmail.php');
	sendmail($email, $subject, $message);

	
	showmessage('新的密码已经发到你的注册邮箱，请注意查收，并尽快登录修改你的密码');

} else {

	$formhash = formhash();

}

echo template('cp_lostpass', get_defined_vars());
?>