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

$id = $_GET['coach'];

//更新阅读次数
$_TGLOBAL['db']->query('UPDATE '.tname('news')." SET readno=readno+1 WHERE id='$id'");

$newsshow            = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id='$id'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
$class_id         = $newsshow['class_id'];
$newsshow['img'] = substr($newsshow['img'],1);

$cd = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$newsshow['sscd']);
$newsshow['sscd_name'] = $cd['title'];

//更新选择教练
$updt = array('kemu'=>3,'coach3_id'=>$id,'k3_time'=>time());
$where = array('openid'=>$_SESSION['openid'],'ispay'=>1);
updatetable('sign',$updt,$where);

//更新教练培训人数
$openid = $_SESSION['openid'];
$sign = $_TGLOBAL['db']->getrow("select * from ".tname('sign')." where openid='".$openid."'");
$coach_id = $sign['coach3_id'];
$_TGLOBAL['db']->query('UPDATE '.tname('news')." SET ljpxrs=ljpxrs+1 WHERE id='$coach_id'");

//选择教练  发送短信
$openid = $_SESSION['openid'];
$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
$coach = $_TGLOBAL['db']->getrow("SELECT coach_phone FROM ".tname('news')." WHERE id='".$id."'");
$coach_phone = $coach['coach_phone'];
$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=6&phone=".$coach_phone."&stu_name=".$wx_user['name']."&stu_phone=".$wx_user['phone'];
$result = json_decode(file_get_contents($url),TRUE);

echo template('coach_confirm', get_defined_vars());
?>