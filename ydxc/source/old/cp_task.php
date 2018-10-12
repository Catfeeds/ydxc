<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_task.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$openid = $_SESSION['member']['openid'];

//获得代金券数量
$sum_fee = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT sum(c.Fee) FROM ".tname('couponslog')." cl
									JOIN ".tname('coupons')." c ON cl.CouponsID = c.id 
									JOIN ".tname('members')." m ON cl.CustomerID = m.CustomerID 
									WHERE Openid='$openid' "), 0);
!$sum_fee && $sum_fee=0;

// 代金券是否可用的状态
$sql          = "SELECT id, Status, Fee FROM ".tname('coupons');
$Status_li    = $_TGLOBAL['db']->getall($sql, 'id');
$Status_data  = $Status_li[3];   //是否完善资料 可用 id=3
$Status_car   = $Status_li[5];   //是否绑定车辆 可用 id=3
$Status_share = $Status_li[6];   //是否分享 可用 id=3

// 是否已经完成各个任务
$sql         = "SELECT cl.CouponsID FROM ".tname('couponslog')." cl
									JOIN ".tname('coupons')." c ON cl.CouponsID = c.id 
									JOIN ".tname('members')." m ON cl.CustomerID = m.CustomerID 
									WHERE Openid='$openid' ";
$oktask_li  = $_TGLOBAL['db']->getall($sql, 'CouponsID');
$oktask_data  = $oktask_li[3];   //是否完善资料 完成 id=3
$oktask_car   = $oktask_li[5];   //是否绑定车辆 完成 id=3
$oktask_share = $oktask_li[6];   //是否分享 完成 id=3




echo template('task', get_defined_vars());
?>