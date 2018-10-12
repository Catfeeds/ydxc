<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
$wx = new Weixin_class();
$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." WHERE ispay=NULL OR ispay='' OR ispay='NULL' ");
	

while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	var_dump($wx->orderquery($value['sn']));
	exit();
}

if ('SUCCESS' == $res->trade_state) {
	$url = "http://ydxctrue.yidianxueche.cn/index.php?do=update_order_status&sn=".$out_trade_no;
	file_get_contents($url);
	echo "<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>";
	exit();
}


?>