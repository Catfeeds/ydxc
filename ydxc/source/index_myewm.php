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

$url = "http://".$_SERVER['HTTP_HOST'] . "/index.php?yqopenid=".$_SESSION['openid'];
$userwxinfo = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('wx_user')." where `openid`='" . $_SESSION['openid'] . "'");
$userwxinfo = $userwxinfo[0];

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
	$msgText = "您的短信验证码是". $msgc .",如非本人操作，请忽略。（易点学车）";
	$url1 = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?msgc=".$msgc."&tpid=3&phone=".$phone;
//	$url2 = "http://121.199.15.121:8888/sms.aspx?action=send&userid=240&account=%E6%98%93%E7%82%B9%E5%AD%A6%E8%BD%A6&password=666666&mobile=".$phone."&content=".$msgText."&sendTime=&extno=";

	$result = json_decode(file_get_contents($url1),TRUE);

	if($result['returnstatus']=='Success') {
		 echo json_encode(array('status'=>1,'code'=>'发送成功'));
		 exit;
	}else{
		 echo json_encode(array('status'=>0,'code'=>'发送失败'));
		 exit;
	}
}
$openid = $_SESSION['openid'];
$weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
echo template('my_ewm', get_defined_vars());
?>