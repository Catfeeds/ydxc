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

$id = $_GET['id'];

//更新阅读次数
$_TGLOBAL['db']->query('UPDATE '.tname('news')." SET readno=readno+1 WHERE id='$id'");

$newsshow            = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id='$id'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
$class_id         = $newsshow['class_id'];
$newsshow['img'] = substr($newsshow['img'],1);
$newsshow['img1'] = substr($newsshow['img1'],1);

$cd = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$newsshow['sscd']);
$newsshow['sscd_name'] = $cd['title'];

	$comment = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$id);
	if(empty($comment)){
		$newsshow['avg'] = '0';
	} else {
		$total_sort = $_TGLOBAL['db']->getrow("select sum(sort1) as sort1 from ".tname('comment')." where cid=".$id);
		$total_count = $_TGLOBAL['db']->getrow("select count(*) as count from ".tname('comment')." where cid=".$id);
		$avg = round($total_sort['sort1']/$total_count['count']);
		$newsshow['avg'] = $avg;
	}
//百度地图根据经纬度获取地址信息
//$address_url = "http://api.map.baidu.com/geocoder/v2/?location=".$cd['lat'].",".$cd['lng']."&output=json&pois=1&ak=DBd897f58d7a63e585485e3dea011253";
//$address = file_get_contents($address_url);
//$address_arr = json_decode($address, true);

$comment = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('comment')." WHERE cid='$id' order by inputtime desc");

$openid = $_SESSION['openid'];
$wx_user = $_TGLOBAL['db']->getrow("SELECT k2_status FROM ".tname('wx_user')." WHERE openid='$openid'");

//控制只能选择一次科三教练
$sign = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('sign')." WHERE ispay=1 and openid='".$openid."' order by paydate desc");
if(empty($sign)){
	$sign['kemu'] = 0;
}
echo template('coach_detail_k2', get_defined_vars());
?>