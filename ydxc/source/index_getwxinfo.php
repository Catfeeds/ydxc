<?php

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");


if (!empty($_REQUEST['data']) || !empty($_SESSION['openid'])) {
	$data = $_REQUEST['data'];
	//echo $data;
	$data = json_decode($data, JSON_UNESCAPED_UNICODE);
	$data = json_decode($data);
	
	$_SESSION['openid'] = $_SESSION['openid']?$_SESSION['openid']:$data->openid;
	
	if (count($_TGLOBAL['db']->getall("SELECT * FROM ".tname('wx_user')." where `openid` = '$data->openid' ")) <= 0) {
		$sign = array(
		   "openid"  => $data->openid,
		   "nickname"  => $data->nickname,
		   'sex' => $data->sex,
		   "city"  => $data->city,
		   "country"  => $data->country,
		   "province"  => $data->province,
		   "headimgurl"  => $data->headimgurl,
		   "subscribe_time" => time()
		  );
		  
		 inserttable("wx_user",$sign);
	}
	
	$url = "/";
	header("Location:" . $url);
	exit();
}

$url = "/l_wx/getwxinfo.php?method=getUserInfo&state=ydxcnew";
header("Location:" . $url);
exit();


?>