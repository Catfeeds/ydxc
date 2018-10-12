<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_orders.php 2010-6-23 21:13:30 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

if($_GET['op']=='del'){
	$id = $_GET['id'];
	$_TGLOBAL['db']->query("DELETE FROM ".tname('member_car')." WHERE id = $id ");
	showmessage_ajax(array('ok' => '删除成功！！', 'jumpto' => 'index.php?do=car'));
}




$perpage = $_GET['PageSize'] ? $_GET['PageSize'] : 10;
$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
$page<1 && $page = 1;
$start   = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);

$wheresql = "WHERE CustomerID='$userinfo[CustomerID]'";

$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) 
								FROM ".tname('member_car')."
								$wheresql"), 0);
if($count) {
	$list = $_TGLOBAL['db']->getall("SELECT *
								FROM ".tname('member_car')."
								$wheresql 
								ORDER BY id DESC
								LIMIT $start,$perpage");
	foreach($list as $key=>$val){
		$list[$key]['CarNumber'] = tran_carno($val['CarNumber']);
	}
}
$multi = multi($count, $perpage, $page, get_current_url());

//ajax_list($list);

//还可添加车辆数
$carnums = 3 - $count;

echo template('car', get_defined_vars());
?>