<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

//if (empty($_SESSION['openid'])) {
//	header("Location:/ydxc/index.php?do=getwxinfo");
//	exit();
//}

$userwxinfo = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('wx_user')." where `openid`='" . $_SESSION['openid'] . "'");
$userwxinfo = $userwxinfo[0];

echo template('my', get_defined_vars());
?>