<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

//if (empty($_SESSION['openid'])) {
//	header("Location:/index.php?do=getwxinfo");
//	exit();
//}

//更新阅读次数
//$_TGLOBAL['db']->query('UPDATE '.tname('course')." SET readno=readno+1 WHERE id='$id'");
$id = $_GET['id'];
$value = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('activity')." where id=".$id." order by id desc limit 1");
$value['img'] = substr($value['img'], 1);
$value['img1'] = substr($value['img1'], 1);
/*$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('partner_rule')." order by id desc limit 1");
$value = $_TGLOBAL['db']->fetch_array($query);*/
	/*print_r($value);*/
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
echo template('new_detail', get_defined_vars());
?>