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
if($_GET['action'] == 'add') {
	$sign = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('sign')." WHERE openid='".$_SESSION['openid']."'");
	if(empty($sign)){
		echo json_encode(array('status'=>2,'code'=>'您未报名参加学习'));
		exit;
	} else {
		$content = $_POST['content'];
		$wx_info = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$_SESSION['openid']."'");
		$insert = array(
			'openid' => $_SESSION['openid'],
			'content' => $content,
			'phone'	=> $wx_info['phone'],
			'inputtime' => time()
		);
		inserttable("change_coach",$insert);
		$is_insert = mysql_affected_rows();//获取插入条数 
		if($is_insert > 0) {
			 echo json_encode(array('status'=>1,'code'=>'成功'));
			 $partner = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news')." WHERE class_id=40");
			if(!empty($partner)){
				for($i=0;$i<count($partner);$i++){
					$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=11&phone=".$partner[$i]['manager_phone'];
					$result = json_decode(file_get_contents($url),TRUE);
				}
			}
			 exit;
		}else{
			 echo json_encode(array('status'=>0,'code'=>'失败'));
			 exit;
		}
	}
}
$value['title'] = '更换教练申请';
$openid = $_SESSION['openid'];
$weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
echo template('my_coach_change', get_defined_vars());
?>