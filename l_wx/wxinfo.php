<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';
$method = $_REQUEST['method'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/config.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
$wx = new Weixin_class();

$code = 1;
$msg = "OK";
$content = null;
switch($method) {

	case 'getwxjs':
		$timeStamp = intval(time()/10);
		$url = $_SERVER[HTTP_REFERER];
		$nonceStr = $wx->getRandChar(15);
		$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);
		$package = "prepay_id=" . $unifiedOrderResult->prepay_id;
		$data = array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,
			"package"=>$package, "signType"=>"MD5", "appId"=>APPID);
		$paySign = $wx->get_signature($data);
		$content = array('appId'=>APPID, 'timestamp'=>$timeStamp, 'nonceStr'=>$nonceStr, 'signature'=>$signature);
		break;
			
	default :
		//echo null;
		break;
}
echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
exit();
?>