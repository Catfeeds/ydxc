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

$pxxy = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE class_id=28 limit 0,1");

echo template('pxxy', get_defined_vars());
?>