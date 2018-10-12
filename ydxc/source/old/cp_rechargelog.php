<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_rechargelog.php 2010-6-21 23:18:24 jerry $
*/
//充值记录  余额变化表：member_money
!defined('IN_CTB') && die('Access Denied');


$perpage = 8;
$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
$page<1 && $page = 1;
$start   = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);
$where = "WHERE m.CustomerID='$userinfo[CustomerID]' AND s.money>0";

$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) 
														FROM ".tname('member_money')." s
														LEFT JOIN ".tname('members')." m ON s.userid=m.id
														$where"), 0);
if($count) {
	$query = $_TGLOBAL['db']->query("SELECT s.*, m.CusName
								FROM ".tname('member_money')." s
								LEFT JOIN ".tname('members')." m ON s.userid=m.id
								$where ORDER BY date DESC LIMIT $start,$perpage");

	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			$value['LogMonth'] = date('Y-m',$value['date']);
			$value['date'] = date('Y-m-d H:i',$value['date']);
			$list[$value['LogMonth']][]       = $value;
			//$list[]       = $value;
	}
}


								
$multi = multi($count, $perpage, $page, get_current_url());
ajax_list($list); //处理ajax

echo template('rechargelog', get_defined_vars());
