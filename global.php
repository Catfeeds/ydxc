<?php
session_start();

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);

//if (empty($_REQUEST['openid']) && empty($_SESSION['openid'])) {
//	//header("Location: /client/index.html");
//	$code = -1;
//	$msg = "未关注";
//
//	echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => ''), JSON_UNESCAPED_UNICODE);
//	exit();
//}