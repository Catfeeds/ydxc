<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_couponslog.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$fs = $_GET['fs'];
!$fs && $fs = 1;

$perpage = 10;
$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
$page<1 && $page = 1;
$start   = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);
$where = "WHERE cl.CustomerID='$userinfo[CustomerID]' ";

//优惠券 人人优泊发送
if($fs == 1){
	$where .=" AND ParkLog = 0 ";
}
//商家券 有停车场编号的券
if($fs == 2){
	$where .=" AND ParkLog <> 0 ";
}

//更新优惠券类型  未使用的过期的 更新为：2
$sql = "UPDATE ".tname('couponslog')." SET Status=2 WHERE OverTime < $_TGLOBAL[timestamp] AND Status = 0 ";
$_TGLOBAL['db']->query($sql);

//总共张数
$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) 
													FROM ".tname('couponslog')." cl
													LEFT JOIN ".tname('coupons')." c ON c.id=cl.CouponsID
													LEFT JOIN ".tname('park')." p ON p.id=cl.Parklog
													$where ORDER BY OverTime DESC"), 0);

//未使用的代金券张数
$isuage_count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) 
													FROM ".tname('couponslog')." cl
													LEFT JOIN ".tname('coupons')." c ON c.id=cl.CouponsID
													LEFT JOIN ".tname('park')." p ON p.id=cl.Parklog
													$where AND cl.OverTime > $_TGLOBAL[timestamp] AND cl.Status=0 ORDER BY OverTime DESC"), 0);
// 分段显示 未使用的和已经过期的
//$isuage_count = $isuage_count % $perpage - 1;

if($count) {
	$query = $_TGLOBAL['db']->query("SELECT cl.*, c.Fee, c.Coupons, p.ParkName
								FROM ".tname('couponslog')." cl
								LEFT JOIN ".tname('coupons')." c ON c.id=cl.CouponsID
								LEFT JOIN ".tname('park')." p ON p.id=cl.Parklog
								$where ORDER BY cl.Status ASC, cl.OverTime DESC LIMIT $start,$perpage");

	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			//$value['state']    = $value['OverTime'] > $_TGLOBAL['timestamp'] ? '0' : '1'; // 是否已经过期 1：过期
			$value['LogMonth'] = date('Y-m',$value['OverTime']);
			$value['OverTime'] = date('Y-m-d',$value['OverTime']);
			//$list[$value['LogMonth']][]       = $value;
			$list[]       = $value;
	}
}
//var_dump($list);

$multi = multi($count, $perpage, $page, get_current_url());

ajax_list($list); //处理ajax


echo template('couponslog_'.$fs, get_defined_vars());
