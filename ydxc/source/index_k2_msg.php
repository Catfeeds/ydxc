<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/ydxc/index.php?do=getwxinfo"); 
	exit();
}

$openid = $_SESSION['openid'];
$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
if($_GET['action'] == 'send') {
	$phone=$_GET['phone'];
	$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=5&phone=".$phone."&stu_name=".$wx_user['name']."&stu_phone=".$wx_user['phone'];
}
?>