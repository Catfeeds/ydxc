<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/index.php?do=getwxinfo");
	exit();
}

$openid = $_SESSION['openid'];
$tj_news = $_TGLOBAL['db']->getall("select * from ".tname('member_notice')." where type=2 and openid='".$openid."' order by inputtime desc");

echo template('my_tj_code', get_defined_vars());

?>