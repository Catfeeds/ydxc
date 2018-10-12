<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

//if (empty($_SESSION['openid'])) {
//	header("Location:/ydxc/index.php?do=getwxinfo");
//	exit();
//}

if($_GET['action'] == 'post') {
	$data = $_POST['data'];
	$sql = "insert into `ctb_partner_apply` (`username`,`phone`,`school`,`actid`,`inputtime`) VALUES ('".$data['username']."','".$data['phone']."','".$data['school']."',".$data['actid'].",".time().")";
	$query = $_TGLOBAL['db']->query($sql);
	if($query) {
		echo json_encode(array('status'=>1,'code'=>'申请成功'));
		$partner = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news')." WHERE class_id=38");
		if(!empty($partner)){
			for($i=0;$i<count($partner);$i++){
				$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=9&phone=".$partner[$i]['manager_phone'];
				$result = json_decode(file_get_contents($url),TRUE);
			}
		}
	}else{
		echo json_encode(array('status'=>0,'code'=>'申请失败'));
	}
	exit;
}

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

//$value = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('partner_rule')." order by id desc limit 1");
//$value['img'] = substr($value['img'],1);
//$value['signup_time'] = date('Y年m月d日',$value['signup_time']);

$id = $_GET['id'];
$value = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('activity')." where id=".$id." order by id desc limit 1");
$value['img'] = substr($value['img'], 1);
$value['img1'] = substr($value['img1'], 1);

$openid = $_SESSION['openid'];
$weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
echo template('partner', get_defined_vars());
?>