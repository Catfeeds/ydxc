<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

//if (empty($_SESSION['openid'])) {
	//header("Location:/ydxc/index.php?do=getwxinfo");
	//exit();
//}
//更新阅读次数
//$_TGLOBAL['db']->query('UPDATE '.tname('course')." SET readno=readno+1 WHERE id='$id'");
//
//$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 ORDER BY id DESC");
//$coaches = array();
//$coaches1 = array();
//while ($value = $_TGLOBAL['db']->fetch_array($query)) {
//
//	$comment = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value['id']);
//
//	if(empty($comment)){
//		$value['avg'] = '0';
//		$value['img'] = substr($value['img'],1);
//		$cd_info = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value['sscd']);
//		$value['sscd'] = $cd_info['title'];
//		$coaches[]       = $value;
//	}
//}
//$query1 = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 ORDER BY id DESC");
//while ($value1 = $_TGLOBAL['db']->fetch_array($query1)) {
//
//	$comment1 = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value1['id']);
//	if(!empty($comment1)){
//		$value1['img'] = substr($value1['img'],1);
//		$cd_info1 = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value1['sscd']);
//		$value1['sscd'] = $cd_info1['title'];
//
//			$total_sort1 = $_TGLOBAL['db']->getrow("select sum(sort1) as sort1 from ".tname('comment')." where cid=".$value1['id']);
//			$total_count1 = $_TGLOBAL['db']->getrow("select count(*) as count from ".tname('comment')." where cid=".$value1['id']);
//			$avg1 = round($total_sort1['sort1']/$total_count1['count']);
//			$value1['avg'] = $avg1;
//
//		array_push($coaches,$value1);
//	}
//}
echo template('coach', get_defined_vars());
?>
