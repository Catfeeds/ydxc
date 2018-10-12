<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if ($_REQUEST['yqopenid']) {
	$_SESSION['yqopenid'] = $_REQUEST['yqopenid'];
}

//判断是否经过微信授权
//if (empty($_SESSION['openid'])) {
	//header("Location:/index.php?do=getwxinfo");
	//exit();
//}

//	if(!empty($_SESSION['yqopenid'])){
//	  $yq = $_TGLOBAL['db']->getrow("select id from ".tname('captain')." where display=0 and openid='".$_SESSION['yqopenid']."'");
//		  if(!empty($yq)){
//		  	$_SESSION['yqopenid'] = null;
//		  }
//	}

$openid = $_SESSION['openid'];
$wx_user = $_TGLOBAL['db']->getrow("select card_id from ".tname('wx_user')." where openid='$openid'");
$card_id = $wx_user['card_id'];
if(!empty($card_id)){
	//更新学员科目状态
	$url = "https://www.122erp.com/Json/Json/GetStudentList/?CGUID=E1D9EEC7-5074-4F57-A990-8A7443B12BF0&sfzmhm=$card_id";
	$data = file_get_contents($url);
	$data = stripslashes($data);
	$data = trim($data,"(");
	$data = trim($data,")");
	$data = trim($data,'"');
	$de_data = json_decode($data,true);
	$km2 = $de_data['Data'][0]['Km2'];  //科目2    2:合格  3:不合格
	$km3 = $de_data['Data'][0]['Km3'];  //科目3    2:合格  3:不合格
	$where = array('openid'=>$openid);
	$updt = array('k2_status'=>$km2,'k3_status'=>$km3);
	updatetable('wx_user',$updt,$where);
}


// 四个班级
$courses  = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('course')." ORDER BY id DESC LIMIT 0,4");


//优质教练
$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and good_coach=1 and display=1 ORDER BY id DESC");
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	$value['img'] = substr($value['img'],1);
	$cd_info = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value['sscd']);
	$value['sscd'] = $cd_info['title'];
	
	$comment = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value['id']);
	if(empty($comment)){
		$value['avg'] = 0;
	} else {
		$total_sort = $_TGLOBAL['db']->getrow("select sum(sort1) as sort1 from ".tname('comment')." where cid=".$value['id']);
		$total_count = $_TGLOBAL['db']->getrow("select count(*) as count from ".tname('comment')." where cid=".$value['id']);
		$avg = round($total_sort['sort1']/$total_count['count']);
		$value['avg'] = $avg;
	}
	$teachers[]       = $value;
}

//首页活动
$activity = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('activity')." where catid=1 ORDER BY id DESC LIMIT 0,3");
for($i=0;$i<count($activity);$i++) {
	$activity[$i]['img'] = substr($activity[$i]['img'],1);
}
//最新活动
$activity_new = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('activity')." where catid=2 ORDER BY id DESC LIMIT 0,3");
for($i=0;$i<count($activity_new);$i++) {
	$activity_new[$i]['img'] = substr($activity_new[$i]['img'],1);
}

//简介
$jianjie = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where class_id=2 ORDER BY id DESC LIMIT 0,1");
$content = preg_replace("/<img.+?\/>/", "", $jianjie['content']);

$user_info = $_TGLOBAL['db']->getrow("select k2_status from ".tname('wx_user')." where openid='$openid'");
$comment_info = $_TGLOBAL['db']->getall("select * from ".tname('comment')." where openid='$openid'");
$comment_num = count($comment_info);

$class_name['name'] = '易点学车';
echo template('index', get_defined_vars());
?>
