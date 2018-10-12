<?php
define("TOKEN", "weixin");

//		$content = file_get_contents('php://input');
//$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/wx.txt", "w") or die("Unable to open file!");
//			fwrite($file, $content.'hello');
//			fclose($file);exit();
$wechatObj = new wechatCallbackapiTest();
if (isset($_GET['echostr'])) {
    $wechatObj->valid();
}else{
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest {

    public function valid() {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
        }
	}

	private function checkSignature() {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
	public function responseMsg() {
		$content = file_get_contents('php://input');
		$postObj = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NOCDATA);
		 //$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		//file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/l_wx/wx.txt", json_encode($postStr));
		 if (!empty($postObj)){
		 	$fromUsername = $postObj->FromUserName;
			$toUsername = $postObj->ToUserName;
			$keyword = trim($postObj->Content);
			$msgType = trim($postObj->MsgType);
			$event = "";

			if ("text" != $msgType) {
				$event = trim($postObj->Event);
				$eventKey = trim($postObj->EventKey);
			}

			if (!empty($keyword)) {
				if ($keyword == "cs") {
					$textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
					$msgType = "text";
	                $contentStr = date("Y-m-d H:i:s",time());
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, "http://kj.yooyor.com/index.php?openid=".$fromUsername);
	                echo $resultStr;exit();
				}
			}

			if ("event" == $msgType) {
				if ("subscribe" == $event) {
					$textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
					$msgType = "text";
	                $contentStr = date("Y-m-d H:i:s",time());
	                $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $fromUsername);
	                echo $resultStr;exit();
					$data = array();
					$title = trim($content[0]);
					$des = trim($content[1]);
					$pclurl = WEB_PATH . "/upload_file/images/" . trim($content[2]);
					$url = trim($content[3]);
					//$url = WEB_PATH . "/wx_html/index.html?wechat_card_js=1&weiId=" . $fromUsername;
					$newTpl = "
						<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[news]]></MsgType>
							<ArticleCount>1</ArticleCount>
							<Articles>
							<item>
							<Title><![CDATA[$title]]></Title>
							<Description><![CDATA[$des]]></Description>
							<PicUrl><![CDATA[$pclurl]]></PicUrl>
							<Url><![CDATA[$url]]></Url>
							</item>

							</Articles>
							</xml>
					";

	                $contentStr = date("Y-m-d H:i:s",time());
	                $resultStr = sprintf($newTpl, $fromUsername, $toUsername, $time);
	                echo $resultStr;
				} else if ('CLICK' == $event){
					if('key_xbpb' == $eventKey) {
						$data = array();
						$title = "科教英文小学霸网络评比";
						$des = "给孩子加人气，助TA实现人生梦想！";
						$pclurl = "http://kj.yooyor.com/client/public/css/self/image/banner.png";
						$url = "http://kj.yooyor.com/index.php?openid=".$fromUsername;
						//$url = WEB_PATH . "/wx_html/index.html?wechat_card_js=1&weiId=" . $fromUsername;
						$newTpl = "
							<xml>
								<ToUserName><![CDATA[%s]]></ToUserName>
								<FromUserName><![CDATA[%s]]></FromUserName>
								<CreateTime>%s</CreateTime>
								<MsgType><![CDATA[news]]></MsgType>
								<ArticleCount>1</ArticleCount>
								<Articles>
								<item>
								<Title><![CDATA[$title]]></Title>
								<Description><![CDATA[$des]]></Description>
								<PicUrl><![CDATA[$pclurl]]></PicUrl>
								<Url><![CDATA[$url]]></Url>
								</item>

								</Articles>
								</xml>
						";

		                $contentStr = date("Y-m-d H:i:s",time());
		                $resultStr = sprintf($newTpl, $fromUsername, $toUsername, $time);
		                echo $resultStr;
					}
				}
			}
		 }
	}
}


?>