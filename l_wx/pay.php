<?php
	include_once $_SERVER['DOCUMENT_ROOT'] . '/global.php';

	$method = $_REQUEST['method'];
	
	include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';	
	$wx = new Weixin_class();
	$code = 0;
	$msg = "OK";
	$content = null;
	switch($method) {
		case 'unifiedorder' :
			$openid = $_SESSION['openid'];
			$out_trade_no = "wxxc_".time().$wx->getRandChar(8);
			$total_fee = 1*100;
			if (!empty($total_fee) && $total_fee > 0 && !empty($openid)) {
				if ($res) {
					$unifiedOrderResult = $wx->unifiedorder($total_fee, $openid, '相册', $out_trade_no);
					//var_dump($unifiedOrderResult);
					$timeStamp = intval(time()/10);
					$url = $_SERVER[HTTP_REFERER];
					//echo $url;
					$nonceStr = $wx->getRandChar(15);
					$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);
					//var_dump($unifiedOrderResult);exit();
					$package = "prepay_id=".$unifiedOrderResult->prepay_id;
					$data = array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,
						"package"=>$package, "signType"=>"MD5", "appId"=>APPID);
						
					$paySign = $wx->get_signature($data);
					$code = 1;
					$content = array('package'=>$package, 'paySign'=>$paySign, 'appId'=>APPID, 'timestamp'=>$timeStamp, 'nonceStr'=>$nonceStr, 'signature'=>$signature);
				} else {
					$msg = "FAIL";
				}
			}
			if (empty($_SESSION['openid'])) {
				$code = -1;
			}
		
		break;	
		
		default :
			//echo null;
			break;
	}
//}
echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
exit();
?>