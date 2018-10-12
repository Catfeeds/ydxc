<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_password.php 2010-6-22 0:10:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

if(submitcheck('btnsubmit')) {
	//检查参数
	$oldpassword  = $_POST['oldpassword'];
	$password     = $_POST['password'];
	$password2    = $_POST['password2'];

	if($password != $password2) {
		showmessage('password_inconsistency');
	}

	if(!$password || $password != addslashes($password)) {
		showmessage('profile_passwd_illegal');
	}

	session_start();
	//判断校验码
	if ($_SESSION['code'] != $_POST['authinput'] || $_POST['authinput'] == "") {
		showmessage('验证码输入错误');
	}

	//取出旧密码
	$query = $_TGLOBAL['db']->query("SELECT password FROM ".tname('members')." WHERE uid='$_TGLOBAL[ctb_uid]'");
	$pass = $_TGLOBAL['db']->fetch_array($query);
	if (md5($oldpassword) != $pass['password']) {
		showmessage('oldpassword_is_wrong');
	}

	$password = md5($password);
	//更新密码
	$_TGLOBAL['db']->query("UPDATE ".tname('members')." SET password = '$password'  WHERE uid='$_TGLOBAL[ctb_uid]'");

	$userid = $_TGLOBAL['ctb_uid'];
	//设置cookie
	ssetcookie('auth', authcode("$password\t$userid", 'ENCODE'), 2592000);

	$_TGLOBAL['ctb_uid'] = $userid;
	$_TGLOBAL['ctb_username'] = $username;
	showmessage('password_is_success');

} else {

	$formhash = formhash();

}

echo template('cp_password', get_defined_vars());
?>