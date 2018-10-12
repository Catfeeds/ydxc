<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_orders.php 2010-6-23 21:13:30 jerry $
*/
// 停车记录
//进出场记录：park_enter_msg
!defined('IN_CTB') && die('Access Denied');


$perpage = 8;
$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
$page<1 && $page = 1;
$start   = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);

//$where = "WHERE p.CustomerID='$userinfo[CustomerID]' AND EnterExitType=3 "; //EnterExitType=4 出场 PaidStatus=1 支付状态1:已支付
$where = " WHERE p.CustomerID='$userinfo[CustomerID]' "; //EnterExitType 支付记录表没有这些字段

//park_enter_msg=>paylog 改变表名，其他字段以及关联都不用修改
$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) 
									FROM ".tname('park_enter_msg')." p
									LEFT JOIN ".tname('members')." m ON p.CustomerID=m.CustomerID 
									LEFT JOIN ".tname('park')." pa ON p.ParkNumber	=pa.ParkNumber 
														$where"), 0);
														
if($count) {  //park_enter_msg=>paylog 改变表名，其他字段以及关联都不用修改
	$query = $_TGLOBAL['db']->query("SELECT p.*, m.CusName, pa.ParkName
									FROM ".tname('park_enter_msg')." p
									LEFT JOIN ".tname('members')." m ON p.CustomerID=m.CustomerID 
									LEFT JOIN ".tname('park')." pa ON p.ParkNumber	=pa.ParkNumber 
								$where ORDER BY LogTime DESC LIMIT $start,$perpage");

	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			//$arr = array(); //构建数组，获取出场查询的条件
			$value['LogMonth'] = date('Y-m',$value['LogTime']);
			$value['LogTime']  = date('Y-m-d H:i',$value['LogTime']);  //park_enter_msg=>paylog 改变表名，其他字段以及关联都不用修改
			//$arr = $_TGLOBAL['db']->getrow("SELECT FeeMoney FROM ".tname('park_enter_msg')." WHERE CustomerID='$value[CustomerID]' AND ParkNumber='$value[ParkNumber]' AND PlateNumber='$value[PlateNumber]' AND EnterExitType in (2,4) AND id>'$value[id]' ORDER BY id ASC LIMIT 0,1 ");
			//$value['FeeMoney'] = $arr['FeeMoney'] ? $arr['FeeMoney'] : '0';  //出场缴费 获取出场金额
			//$value['FeeMoney'] = $value['EnterExitType'];
			$list[$value['LogMonth']][]       = $value;
			
			
	}
}


$multi = multi($count, $perpage, $page, get_current_url());
ajax_list($list); //处理ajax


echo template('orders', get_defined_vars());
