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

$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." WHERE openid='".$openid."' and ispay=1 order by paydate desc");
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	$class_info = $_TGLOBAL['db']->getrow("select * from ".tname('course')." where id=".$value['courseid']);
//	$value['price'] = $class_info['zd_price'];
	$value['class_name'] = $class_info['name'];
	$coach = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value['coach_id']);
	$value['xingming'] = $coach['xingming'];
	$cd = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$coach['sscd']);
	$value['title'] = $cd['title'];
	$value['lng'] = $cd['lng'];
	$value['lat'] = $cd['lat'];
	$orders[]       = $value;
}

echo template('my_order', get_defined_vars());
?>