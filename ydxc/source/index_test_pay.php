<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
$wx = new Weixin_class();
$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." ");

while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	if (empty($value['sn']) || 'NULL' == $value['sn'] || NULL == $value['sn']) {
		continue;
	}
	$res = $wx->orderquery($value['sn']);
	
	if ('SUCCESS' == $res->trade_state) {
		$updt = array("ispay"=>1,"paydate"=>strtotime($res->time_end));

		$where = array("sn"=>$value['sn']);
		
		updatetable("sign", $updt, $where);
		
		echo "<font style='color: green;' >" . $value['name'] . " - " . $res->trade_state_desc . '-' . $value['sn'] . "</font><br/>";
	} else {
		$updt = array("ispay"=>NULL,"paydate"=>NULL);

		$where = array("sn"=>$sn);
		
		updatetable("sign", $updt, $where);
	}
	echo $value['name'] . " - " . $res->trade_state_desc . "<br/>";
}




?>