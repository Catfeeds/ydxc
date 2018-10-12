<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");


$sn =$_GET['sn'];
if (empty($sn)) {
	exit();
}
$updt = array("ispay"=>2,"inputtime"=>time());

$where = array("sn"=>$sn);

updatetable("check", $updt, $where);

$check = $_TGLOBAL['db']->getrow("SELECT organization,phone from ".tname('check')." WHERE sn='".$sn."'");
$code_info = $_TGLOBAL['db']->getall("SELECT id,tj_code_new,tj_code from ".tname('tj_code_info')." WHERE is_use=1 and belong_to=".$check['organization']." limit 0,1");
$code_id = $code_info[0]['id'];
$is_use = array('is_use'=>2);
$where = array('id'=>$code_id);
//print_r($code_info); exit;
updatetable('tj_code_info', $is_use ,$where);

$tj_code_new = $code_info[0]['tj_code_new'];
$tj_code_old = $code_info[0]['tj_code'];
$tj_code = array("code"=>$tj_code_new,"old_code"=>$tj_code_old);
$where = array("sn"=>$sn);
updatetable('check',$tj_code,$where);

if(!empty($code_info)){
	$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=8&phone=".$check['phone']."&old_code=".$tj_code_old."&new_code=".$tj_code_new;
	$result = json_decode(file_get_contents($url),TRUE);
}

$sign = $_TGLOBAL['db']->getrow("select * from ".tname('check')." where sn='".$sn."'");
if(!empty($code_info)){
	$content = "申请成功，体检码为：".$tj_code_old.", 验证码为：".$tj_code_new;
} else {
	$content = "对不起，体检码已发放完，请联系客服领取体检码。";
}

$news = array(
			'openid'		=>	$sign['openid'],
			'type'		=>	2,
			'content'	=>	$content,
			'inputtime'	=>	time()
		);
inserttable('member_notice',$news);

$not_use = $_TGLOBAL['db']->getall("SELECT id,tj_code_new,tj_code from ".tname('tj_code_info')." WHERE is_use=1 and belong_to=".$check['organization']);
$news_class = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news_class')." WHERE id=".$check['organization']);
$tjz_name = $news_class['name'];
if(!empty($not_use)){
	if(count($not_use)==15){
		$partner = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news')." WHERE class_id=39");
		if(!empty($partner)){
			for($i=0;$i<count($partner);$i++){
				$url1 = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=10&phone=".$partner[$i]['manager_phone']."&tjz=".$tjz_name;
				$result1 = json_decode(file_get_contents($url1),TRUE);
			}
		}
	}
}
?>