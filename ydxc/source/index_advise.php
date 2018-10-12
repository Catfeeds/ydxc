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
	$content = $_POST['content'];
	$insert = array(
		'openid' => $_SESSION['openid'],
		'content' => $content,
		'inputtime' => time()
	);
	inserttable("tousu",$insert);
	$is_insert = mysql_affected_rows();//获取插入条数 
	if($is_insert > 0) {
		 echo json_encode(array('status'=>1,'code'=>'成功'));
		 $partner = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news')." WHERE class_id=41");
		 $msgText = "有学员提交投诉建议，请及时到后台查看处理";
		if(!empty($partner)){
			for($i=0;$i<count($partner);$i++){
				$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=12&phone=".$partner[$i]['manager_phone'];
//				$url = "http://121.199.15.121:8888/sms.aspx?action=send&userid=240&account=%E6%98%93%E7%82%B9%E5%AD%A6%E8%BD%A6&password=666666&mobile=".$partner[$i]['manager_phone']."&content=".$msgText."&sendTime=&extno=";
				$result = json_decode(file_get_contents($url),TRUE);
			}
		}
		 exit;
	}else{
		 echo json_encode(array('status'=>0,'code'=>'失败'));
		 exit;
	}
}

$value['title'] = '您的建议';
$openid = $_SESSION['openid'];
$weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$openid."'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
echo template('advise', get_defined_vars());
?>