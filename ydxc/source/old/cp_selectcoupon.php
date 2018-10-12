<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_couponslog.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$where = "WHERE cl.CustomerID='$userinfo[CustomerID]' AND cl.OverTime > $_TGLOBAL[timestamp] AND cl.Status=0";

$query = $_TGLOBAL['db']->query("SELECT cl.*, c.Fee, c.Coupons
							FROM ".tname('couponslog')." cl
							LEFT JOIN ".tname('coupons')." c ON c.id=cl.CouponsID
							$where ORDER BY OverTime DESC");

while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	$list[]       = $value;
}

echo template('selectcoupon', get_defined_vars());
