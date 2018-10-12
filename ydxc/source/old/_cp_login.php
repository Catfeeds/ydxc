<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_login.php 2010-6-21 23:33:00 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

if($_TGLOBAL['ctb_uid']) {
	showmessage('do_success', 'index.php?do=index', 0);
}

//$_TCOOKIE['_refer'] = $_TGLOBAL['refer'];

$refer = empty($_GET['refer']) ? rawurldecode($_TCOOKIE['_refer']) : $_GET['refer'];
preg_match("/(admincp|do|index)\.php\?do\=([a-z]+)/i", $refer, $ms);
/*
if($ms) {
	if($ms[1] != 'cp' || $ms[2] != 'sendmail') $refer = '';
}*/

if(empty($refer)) {
	$refer = 'index.php?do=index';
}

$openid = $_SESSION['member']['openid'];

if(submitcheck('btnsubmit')  || ($op == 'weixinlog' && $openid) ) {
	$username  = trim($_POST['username']);	
	$password  = trim($_POST['password']);
	$password  = md5($password);
	$authinput = $_POST['authinput'];

	/*session_start();
	//判断校验码
	if ($_SESSION['code'] != $_POST['authinput'] || $_POST['authinput'] == "") {
		showmessage('验证码输入错误');
	}*/

	//判断此username是否存在
	if ($username) {
		$query = $_TGLOBAL['db']->query("SELECT uid, password, times, isdisable FROM ".tname('members')." WHERE username='$username'");
	}
	if ($op == 'weixinlog' && $openid) {
		$query = $_TGLOBAL['db']->query("SELECT uid, username, password, times, isdisable FROM ".tname('members')." WHERE openid='$openid'");
	}

	if (!($userinfo = $_TGLOBAL['db']->fetch_array($query))) {
		showmessage('users_were_not_empty_please_re_login');
	}
	$username = $userinfo['username'];

	$password = $userinfo['password'];
	if ($password != $userinfo['password']) {
		showmessage('login_failure_please_re_login');
	}

	if (1 == $userinfo['isdisable']) {
		showmessage('users_were_close_please_re_login');
	}

	//添加登录
	$userarr = array(
		'userid'           => 	$userinfo['uid'],
		'username'         => 	$username,
		'password'         => 	$password
		);
	insertsession($userarr);

	//更新用户的登录信息
	$userarr = array(
			'lastvisit'        => 	$_TGLOBAL['timestamp'],
			'lastip'           => 	getonlineip(),
			'times'            => 	$userinfo['times'] + 1
		);
	updatetable('members', $userarr, array('uid' => $userinfo['uid']));

	//设置cookie
	ssetcookie('auth', authcode("$password\t$userinfo[uid]", 'ENCODE'), $_POST['islogged'] ? 2592000 : 0);
	ssetcookie('loginuser', 31536000);
	ssetcookie('_refer', '');

	$_TGLOBAL['ctb_uid'] = $userinfo[uid];
	$_TGLOBAL['ctb_username'] = $username;
	showmessage('login_success',$refer);

} else {

	$formhash = formhash();

}

//当获取到用户的openid后，查询数据库是否有此openid对应的用户
if ($openid) {

	$query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE openid='$openid'");
	$isweixinlog = 0;
	if ($userinfo = $_TGLOBAL['db']->fetch_array($query)) {
		$isweixinlog = 1;
	}
}


$top_name = '用户登陆';
echo template('cp_login', get_defined_vars());
?>