<?php
$to = "";
$msg = 'ok';
if (!empty($_REQUEST['phone'])) {
    $to = $_REQUEST['phone'];
} else {
	echo json_encode(array('msg' => $msg, 'code' => 0, 'return' => array('visit' => $visit)), JSON_UNESCAPED_UNICODE);

	exit();
}
$msgc = $_REQUEST['msgc'];  			//返回内容
$tpid = $_REQUEST['tpid'];

$quantity = $_REQUEST['quantity'];

$stu_name = $_REQUEST['stu_name'];
$stu_phone = $_REQUEST['stu_phone'];

$old_code = $_REQUEST['old_code'];
$new_code = $_REQUEST['new_code'];

$tjz = $_REQUEST['tjz'];

if (!empty($tpid)) {
	$ch = curl_init();
//	$tpid = 0; //停止短信发送
	switch ($tpid) {
		case 1: 
			//$msgText = "【熊猫联采】您的账号".$msgc."审核通过。";
			break;
		case 2: 
			//$msgText = "【熊猫联采】您的账号".$msgc."审核未通过，请检查您提交的资料。";
			break;
		case 3: 
			$msgText = "您的短信验证码是".$msgc.",如非本人操作，请忽略。（易点学车）";
			break;
		case 4:
			//$msgText = "【熊猫联采】id为".$msgc."的商品库存仅剩".$quantity.",请及时补货";
			break;
		case 5: 
			$msgText = "亲爱的教练员，学员".$stu_name."（电话：".$stu_phone."）已经成功选择你作为科目二老师！请在24小时内进行沟通。（易点学车）";
			break;
		case 6: 
			$msgText = "亲爱的教练员，学员".$stu_name."（电话：".$stu_phone."）已经成功选择你作为科目三老师！请在24小时内进行沟通。（易点学车）";
			break;
		case 7: 
			$msgText = "亲爱的学员您好！您已经成功报名，您的下一步操作是在首页“报名体检”页面内申请一个体检码，申请成功之后请根据提示进行下一步操作。学员Q群：681469774，加入群内可询问以及交流，也可以拨打服务电话:400-689-8909，祝您学车愉快！（易点学车）";
			break; 
		case 8: 
			$msgText = "请将此页面截屏：您已经成功申请体检码（体检码：".$old_code."，验证码：".$new_code."），请带上手机、身份证原件到所选择体检站进行体检。（易点学车）";
			break;
		case 9: 
			$msgText = "有用户申请为合伙人，请及时到后台查看处理（易点学车）";
			break;
		case 10: 
			$msgText = "(".$tjz.")体检码已不足，请及时到后台查看处理（易点学车）";
			break;
		case 11: 
			$msgText = "有学员提交更换教练申请，请及时到后台查看处理（易点学车）";
			break;
		case 12: 
			$msgText = "有学员提交投诉建议，请及时到后台查看处理（易点学车）";
			break;
	}
	$post_data = array(
	    "account" => "sdk_bkxm",
	    "password" => "jianzhou",
	    "destmobile" => $to,
	    "msgText" => $msgText,
	    "sendDateTime" => ""
	);
	$url = "http://121.199.15.121:8888/sms.aspx?action=send&userid=317&account=djjx&password=djjx123&mobile=".$to."&content=".$msgText."&sendTime=&extno=";
    if (isset($url)) {
        echo json_encode(simplexml_load_string(file_get_contents($url)));
    }
    exit();
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$post_data = http_build_query($post_data);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_URL, 'http://www.jianzhou.sh.cn/JianzhouSMSWSServer/http/sendBatchMessage');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	var_dump(curl_exec($ch));
	curl_close($ch);
}
echo json_encode(array('msg' => $msg, 'code' => 1, 'return' => array('visit' => $visit)), JSON_UNESCAPED_UNICODE);
exit();