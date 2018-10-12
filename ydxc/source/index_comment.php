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
$userwxinfo = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('wx_user')." where `openid`='" . $openid . "'");
$userwxinfo = $userwxinfo[0];


$sign = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('sign')." WHERE openid='".$openid."' and ispay=1 order by id desc limit 0,1");
$coach_id = $sign['coach_id'];
if(!empty($sign)){
	$class = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('course')." WHERE id=".$sign['courseid']);
	$class_title = $class['name'];
	$coach =  $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$sign['coach_id']);
	$cd = $coach['sscd'];
	$cd = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$cd);
	$lng = $cd['lng'];
	$lat = $cd['lat'];
	//百度地图根据经纬度获取地址信息
//	$address_url = "http://api.map.baidu.com/geocoder/v2/?location=".$lat.",".$lng."&output=json&pois=1&ak=DBd897f58d7a63e585485e3dea011253";
//	$address = file_get_contents($address_url);
//	$address_arr = json_decode($address, true);
	$kemu = $coach['kemu'];
	$xingming = $coach['xingming'];
	$coach_phone = $coach['coach_phone'] ? $coach['coach_phone'] : '无';
}

echo template('my_study', get_defined_vars());
?>