<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';

$sn =$_GET['sn'];
if (empty($sn)) {
	exit();
}


$sign = $_TGLOBAL['db']->getrow("select * from ".tname('sign')." where sn='".$sn."'");
if ($sign['ispay'] == 1) {
	exit();
}

$updt = array("ispay"=>1,"paydate"=>time());

$where = array("sn"=>$sn);

updatetable("sign", $updt, $where);

$sign = $_TGLOBAL['db']->getrow("select * from ".tname('sign')." where sn='".$sn."'");

$content = "已成功报名，祝您学习顺利";

$news = array(
			'openid'		=>	$sign['openid'],
			'type'		=>	1,
			'content'	=>	$content,
			'inputtime'		=>	time()
		);
inserttable('member_notice',$news);



//更新教练培训人数

$coach_id = $sign['coach_id'];
$_TGLOBAL['db']->query('UPDATE '.tname('news')." SET ljpxrs=ljpxrs+1 WHERE id='$coach_id'");

$jlinfo = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id='".$sign['coach_id']."'");//查询教练信息
$url = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=5&phone=".$jlinfo['coach_phone']."&stu_name=".$sign['name']."&stu_phone=".$sign['mobile'];
$result = json_decode(file_get_contents($url),TRUE);

$url1 = "http://ydxctrue.yidianxueche.cn/api/shortmessage/jianzhou.php?tpid=7&phone=".$sign['mobile'];
$result1 = json_decode(file_get_contents($url1),TRUE);

//更新成功推荐人数
if(!empty($sign['inv'])){
	$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$sign['inv']);
	if(!empty($captain)){
		$_TGLOBAL['db']->query('UPDATE '.tname('captain')." SET success_num=success_num+1 WHERE id='".$sign['inv']."'");
	}
}

$wx = new Weixin_class();

	if(!empty($sign['inv'])){
		$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$sign['inv']);

		if(!empty($captain['cptid'])){ //如果有上级，就显示队员和队员的上级（合伙人）；否则只显示合伙人
			$sign['duiyuan_name'] = $captain['name'];
			$duiyuan = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$captain['cptid']);
			$sign['captain_name'] = $duiyuan['name'];
		} else {
			$sign['captain_name'] = $captain['name']; //显示合伙人
			$sign['duiyuan_name'] = '无';
		}
	}
//组装发送消息内容
$content = '学员姓名：'.$sign['name'].' , 电话：'.$sign['mobile'].' , 身份证号：'.$sign['cardno'].
			' , 地址：'.$sign['area'].' , 成交合伙人：'.$sign['captain_name'].' , 成交队员：'.$sign['duiyuan_name'].
			' , 时间：'.date("Y-m-d H:i:s",$sign['paydate']);
$data1 = array(
			'touser' => 'o2l0cwjjem5xNUH5Is9fUec_jhEE',
			'msgtype'=> 'text',
			'text' 	 => array('content'=>$content)
		 );

$data2 = array(
			'touser' => 'o2l0cwj6bKfp1IlK60lL6exB-sA0',
			'msgtype'=> 'text',
			'text' 	 => array('content'=>$content)
		 );

$data3 = array(
			'touser' => 'o2l0cwspBtFyXaNYxggTQEaqPFAM',
			'msgtype'=> 'text',
			'text' 	 => array('content'=>$content)
		 );
		 
$data4 = array(
			'touser' => 'o2l0cwkgaEOA7AA5yKvn7zi6cngo',
			'msgtype'=> 'text',
			'text' 	 => array('content'=>$content)
		 );

$data5 = array(
			'touser' => 'o2l0cwi5RqbVJFvht-vyOIzcDCs0',
			'msgtype'=> 'text',
			'text' 	 => array('content'=>$content)
		 );

$res1 = $wx->send_msg($data1);
$res2 = $wx->send_msg($data2);
$res3 = $wx->send_msg($data3);
$res4 = $wx->send_msg($data4);
$res5 = $wx->send_msg($data5);

?>