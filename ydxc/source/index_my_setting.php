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
$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
if(!empty($wx_user)){
	$phone = $wx_user['phone'];
	$name = $wx_user['name'];
	$card_id = $wx_user['card_id'];
	$shcool = $wx_user['shcool'];
}
echo template('my_setting', get_defined_vars());
?>