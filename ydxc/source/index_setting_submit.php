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

if($_GET['action'] == 'update') {
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$card_id = $_POST['card_id'];
	$shcool = $_POST['shcool'];
	
//	if(!empty($phone)){
//		$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE phone='".$phone."'");
//		if(!empty($wx_user)){
//			echo json_encode(array('status'=>2,'code'=>'该手机号已存在'));
//		 	exit;
//		}
//	}
	
	$updt = array(
		'name'	=>	$name,
		'phone' => 	$phone,
		'card_id' =>	$card_id,
		'shcool'	=>	$shcool
	);
	$where = array('openid' => $_SESSION['openid']);
	updatetable("wx_user",$updt,$where);
	$is_insert = mysql_affected_rows();//获取插入条数 
	if($is_insert) {
		if(!empty($phone)){
			$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE phone='".$phone."'");
			if(!empty($captain)){
				$update = array('openid'=>$_SESSION['openid']);
				$wh = array('phone'=>$phone);
				updatetable("captain",$update,$wh);
			}
		}
		 echo json_encode(array('status'=>1,'code'=>'成功'));
		 exit;
	}else{
		 echo json_encode(array('status'=>0,'code'=>'失败'));
		 exit;
	}
}

$value['title'] = '修改信息';

?>