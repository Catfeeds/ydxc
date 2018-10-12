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
$baoming_news = $_TGLOBAL['db']->getall("select * from ".tname('member_notice')." where type=1 and openid='".$openid."'");
$tj_news = $_TGLOBAL['db']->getall("select * from ".tname('member_notice')." where type=2 and openid='".$openid."'");

echo template('my_news', get_defined_vars());
?>