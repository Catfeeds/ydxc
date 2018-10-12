<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_db/drive/mysql.class.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_db/config/database.php';

if (!empty($_REQUEST['data']) || !empty($_SESSION['openid'])) {
	$data = $_REQUEST['data'];
	//echo $data;
	$data = json_decode($data, JSON_UNESCAPED_UNICODE);
	$data = json_decode($data);
	
	$_SESSION['openid'] = $_SESSION['openid']?$_SESSION['openid']:$data->openid;
	$db = DB::getDBClass();
	
	if (count($db->where(array('openid'=>$data->openid))->select('wxuserinfo')) <= 0) {
		$db->add('wxuserinfo', array('openid'=>$data->openid, 
					'info'=>json_encode($data, JSON_UNESCAPED_UNICODE)));
	}
	
	$url = "home.html";
	header("Location:" . $url);
	exit();
}

$url = "/l_wx/getwxinfo.php?method=getUserInfo&state=index";
header("Location:" . $url);
exit();

/*
if (!empty($_REQUEST['openid'])) {
	$_SESSION['openid'] = $_REQUEST['openid'];
	$url = "home.html";
	header("Location:" . $url);
	exit();
}

$url = "/l_wx/getwxinfo.php?method=getOpenId&state=index";
header("Location:" . $url);
exit();*/


?>