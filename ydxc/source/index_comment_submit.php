<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/ydxc/index.php?do=getwxinfo"); 
	exit();
}

$userwxinfo = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('wx_user')." where `openid`='" . $_SESSION['openid'] . "'");
$userwxinfo = $userwxinfo[0];

$content = $_POST['content'];
$sort1 = $_POST['rating'];
$coach_id = $_POST['coach_id'];
$inputtime = time();

$comment = array(
			'content'	=>	$content,
			'openid'		=>	$_SESSION['openid'],
			'sort1'		=>	$sort1,
			'cid'		=>	$coach_id,
			'inputtime'	=>	$inputtime
		);

if($userwxinfo['k2_status']==2){
	inserttable('comment',$comment);
}

echo template('my', get_defined_vars());
?>