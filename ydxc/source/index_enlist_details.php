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

//更新阅读次数
//$_TGLOBAL['db']->query('UPDATE '.tname('course')." SET readno=readno+1 WHERE id='$id'");
if($_GET['action'] == 'visit') {
	$phone = $_POST['phone'];
	$code = $_POST['code'];
	if($code == $_SESSION['code']) {
		$update = array(
		   "phone"  => $phone,
		  );
		  $where = array(
		  	'openid'=>$_SESSION['openid'],
		  );
		 updatetable("wx_user",$update,$where);
		 
		 $captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE phone='".$phone."'");
		 if(!empty($captain)){
		 	$updt = array('openid'=>$_SESSION['openid']);
		 	$whe = array('phone'=>$phone);
		 	updatetable("captain",$updt,$whe);
		 }
		 echo json_encode(array('status'=>1,'code'=>'验证成功'));
		 exit;
	}else{
		 echo json_encode(array('status'=>0,'code'=>'验证码不正确'));
		 exit;
	}
}
if($_GET['action'] == 'send') {
	$phone=$_GET['phone'];
	if(!empty($phone)){
		$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE phone='".$phone."'");
		if(!empty($wx_user)){
			echo json_encode(array('status'=>5,'code'=>'该号码已被注册'));
		 	exit;
		}
	}
	$msgc = rand(1000, 9999);
	$_SESSION['code'] = $msgc;
	$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?msgc=".$msgc."&tpid=3&phone=".$phone;
	$result = json_decode(file_get_contents($url),TRUE);
	if($result['returnstatus']=='Success') {
		 echo json_encode(array('status'=>1,'code'=>'发送成功'));
		 exit;
	}else{
		 echo json_encode(array('status'=>0,'code'=>'发送失败'));
		 exit;
	}
}
$id = $_GET['id'];
$coach = $_GET['coach'];
$courseshow            = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('course')." WHERE id=".$id);
$courseshow['coach'] = $coach;
$openid = $_SESSION['openid'];
$weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
echo template('enlist_details', get_defined_vars());
?>