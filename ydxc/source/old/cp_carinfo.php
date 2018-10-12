<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_orders.php 2010-6-23 21:13:30 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$carid = $_GET['carid'];

//开启自动付款绑定
if($_GET['op']=='band'){
	$id = $_GET['id'];
	$_TGLOBAL['db']->query("UPDATE ".tname('member_car')." SET BindPay = 1 WHERE CarID = '$carid' ");
	//showmessage_ajax(array('ok' => '自动付款开启成功！！', 'jumpto' => 'index.php?do=carinfo&carid='.$carid));
	showmessage_ajax(array('ok' => '自动付款开启成功！！', 'jumpto' => 'index.php?do=car'));
	die;
}

//解除自动付款绑定
if($_GET['op']=='jieband'){
	$id = $_GET['id'];
	$_TGLOBAL['db']->query("UPDATE ".tname('member_car')." SET BindPay = 0 WHERE CarID = '$carid' ");
	//showmessage_ajax(array('ok' => '自动付款关闭成功！！', 'jumpto' => 'index.php?do=carinfo&carid='.$carid));
	showmessage_ajax(array('ok' => '自动付款关闭成功！！', 'jumpto' => 'index.php?do=car'));
	die;
}



$car       = $_TGLOBAL['db']->getrow("SELECT CarNumber, BindPay FROM ".tname('member_car')." WHERE carid='$carid'");
$car_month = $_TGLOBAL['db']->getall("SELECT p.ParkName, mu.Money, mu.StartTime,  mu.EndTime   FROM ".tname("month_user")." mu
									JOIN ".tname('park')." p ON mu.ParkNumber=p.ParkNumber 
									WHERE carid='$carid'");
									
$car['CarNumber']= tran_carno($car['CarNumber']);

echo template('car_info', get_defined_vars());
?>