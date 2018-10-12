<?php
$to = "";
$msg = 'ok';
if (!empty($_REQUEST['phone'])) {
    $to = $_REQUEST['phone'];
} else {
	echo json_encode(array('msg' => $msg, 'code' => 0, 'return' => array('visit' => $visit)), JSON_UNESCAPED_UNICODE);

	exit();
}
$msgc = $_REQUEST['msgc'];
$tpid = $_REQUEST['tpid'];
$quantity = $_REQUEST['quantity'];

if (!empty($tpid)) {
	$ch = curl_init();
	switch ($tpid) {
		case 1: 
			$msgText = "【熊猫联采】您的账号".$msgc."审核通过。";
			break;
		case 2: 
			$msgText = "【熊猫联采】您的账号".$msgc."审核未通过，请检查您提交的资料。";
			break;
		case 3: 
			$msgText = "【蓝掌柜】您的短信验证码是".$msgc.",如非本人操作，请忽略。";
			break;
		case 4:
			$msgText = "【熊猫联采】id为".$msgc."的商品库存仅剩".$quantity.",请及时补货";
			break;
	}
	$post_data = array(
	    "account" => "sdk_yslc",
	    "password" => "sdk_yslc",
	    "destmobile" => $to,
	    "msgText" => $msgText,
	    "sendDateTime" => ""
	);
	
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$post_data = http_build_query($post_data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_exec($ch);
	curl_close($ch);
}
echo json_encode(array('msg' => $msg, 'code' => 1, 'return' => array('visit' => $visit)), JSON_UNESCAPED_UNICODE);
exit();