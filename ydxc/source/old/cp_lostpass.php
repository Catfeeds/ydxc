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
	//�ж�У����
	if ($_SESSION['code'] != $_POST['authinput'] || $_POST['authinput'] == "") {
		showmessage('��֤���������');
	}

	//�жϴ�username�Ƿ����
	$query = $_TGLOBAL['db']->query("SELECT uid, email FROM ".tname('members')." WHERE username='$username'");
	if (!($userinfo = $_TGLOBAL['db']->fetch_array($query))) {
		showmessage('users_were_not_empty_please_re_login');
	}

	if ($email != $userinfo['email']) {
		showmessage('����д��������ע��ʱ�����䲻���ϣ���ȷ�ϣ�');
	}

	$newpassword = random(6, 1);
	//�����û�������
	$userarr = array(
			'password'        => 	md5($newpassword)
		);
	updatetable('members', $userarr, array('uid' => $userinfo['uid']));

	$subject = "��������Ѿ������� ������Ϊ��$newpassword";
	$message = "������Ϊ��$newpassword \r\n ���ԣ�$_TCONFIG[sitename] ��ַ��$_CTB[siteurl]  \r\n ����ʱ�䣺".date("Y-m-d H:i", $_TGLOBAL['timestamp']);

	include_once(S_ROOT.'./source/function_sendmail.php');
	sendmail($email, $subject, $message);

	
	showmessage('�µ������Ѿ��������ע�����䣬��ע����գ��������¼�޸��������');

} else {

	$formhash = formhash();

}

echo template('cp_lostpass', get_defined_vars());
?>