<?php
$url = "home.html";
header("Location:" . $url);
	exit();
session_start();
if (!empty($_REQUEST['openid'])) {
	$_SESSION['openid'] = $_REQUEST['openid'];
	$url = "home.html";
	header("Location:" . $url);
	exit();
}

$url = "/l_wx/getwxinfo.php?method=getOpenId&state=index";
header("Location:" . $url);
exit();


?>