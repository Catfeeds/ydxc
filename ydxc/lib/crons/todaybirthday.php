<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: todaybirthday.php 2013-6-28 21:42:34 jerry $
*/

!defined('IN_CTB') && die('Access Denied');


//将用户 next_birthday 下次生日提醒时间为空的，更新为当前的年加月加日
$where = "WHERE next_birthday <= 0 AND cardno!=''";
$sql   = "SELECT * FROM ".tname('members')." $where ORDER BY uid ASC";
$query = $_TGLOBAL['db']->query($sql);
while ($value = $_TGLOBAL['db']->fetch_array($query)) {

	$ary = getIDCardInfo($value['cardno']);
	$date = date('Y-', $_TGLOBAL['timestamp']). $ary['montyday'];
	$date = strtotime($date);

	//更新
	$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET next_birthday = '$date' WHERE uid='$value[uid]'");
}


//提醒时间小于当前时间
$where = "WHERE next_birthday <= $_TGLOBAL[timestamp] AND openid!=''";
//$where = "WHERE next_birthday <= $_TGLOBAL[timestamp] AND openid!=''"; //测试

$sql   = "SELECT * FROM ".tname('members')." $where ORDER BY uid ASC";
$query = $_TGLOBAL['db']->query($sql);

$ACCESS_TOKEN = weixin_access_token();

while ($value = $_TGLOBAL['db']->fetch_array($query)) {

	$ary = getIDCardInfo($value['cardno']);
	$date = date('Y-', $_TGLOBAL['timestamp']). $ary['montyday'];

	$first = "亲爱的会员，你的生日是：".date('Y年m月d日', $value['next_birthday']);
	$keyword2 = date('Y年m月d日 H:i', $value['regdate']);
	
	$data = "
	  {
			   \"touser\":\"oVmsMjyFV-KZuAkZN8UzvifugUjE\",
			   \"template_id\":\"$value[openid]\",
			   \"url\":\"$_CTB[siteurl]\",
			   \"topcolor\":\"#FF0000\",
			   \"data\":{
					   \"first\": {
						   \"value\":\"$first\",
						   \"color\":\"#173177\"
					   },
					   \"keyword1\":{
						   \"value\":\"$value[username]\",
						   \"color\":\"#ff0000\"
					   },
					   \"keyword2\": {
						   \"value\":\"$keyword2\",
						   \"color\":\"#173177\"
					   },
					   \"remark\":{
						   \"value\":\"祝你生日快乐哦！\",
						   \"color\":\"#173177\"
					   }
			   }
		   }
	";
	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token={$ACCESS_TOKEN}"; 
	$return = weixin_post($url, $data);
	$ary = json_decode($return);

	//记录发送明细
	$arr = array(
			'title'            => 	$first,
			'content'          => 	$data,
			'is_read'          => 	1,
			'uid'              => 	$value['uid'],
			'date'             => 	$_TGLOBAL['timestamp']
			);
	inserttable('message', $arr);


	//更新提醒时间为365天后
	$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET next_birthday = next_birthday + 365 * 24 * 60 *60 WHERE uid='$value[uid]'");
}




?>