<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/index.php?do=getwxinfo"); 
	exit();
}

//更新阅读次数
//$_TGLOBAL['db']->query('UPDATE '.tname('course')." SET readno=readno+1 WHERE id='$id'");
$coach = $_GET['coach'];
if(!empty($coach)){
	$coach_info = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." where id=$coach");
	if(!empty($coach_info['drive_type'])){
		$courseshow = $_TGLOBAL['db']->query("SELECT * FROM ".tname('course')." where drive_type='".$coach_info['drive_type']."'");
	} else {
		$courseshow            = $_TGLOBAL['db']->query("SELECT * FROM ".tname('course'));
	}
} 
while ($value = $_TGLOBAL['db']->fetch_array($courseshow)) {
	$value['coach'] = $coach;
	$course[]       = $value;

}
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
echo template('enlist', get_defined_vars());
?>