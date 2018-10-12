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
//更新阅读次数
//$_TGLOBAL['db']->query('UPDATE '.tname('course')." SET readno=readno+1 WHERE id='$id'");
$id = $_GET['id'];
$coach = $_GET['coach'];
$courseshow            = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('course')." WHERE id=".$id);
$coach_info = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$coach);
$sscd = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$coach_info['sscd']);
//百度地图根据经纬度获取地址信息
//$address_url = "http://api.map.baidu.com/geocoder/v2/?location=".$sscd['lat'].",".$sscd['lng']."&output=json&pois=1&ak=DBd897f58d7a63e585485e3dea011253";
//$address = file_get_contents($address_url);
//$address_arr = json_decode($address, true);

if(!empty($_SESSION['yqopenid'])){
	$inv = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE openid='".$_SESSION['yqopenid']."'");
}

echo template('enlist_order', get_defined_vars());
?>