<?php
//网站根目录
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/config.php';
//微信信息
class Weixin_class {
	//查询订单
	function orderquery($out_trade_no) {
		$url ="https://api.mch.weixin.qq.com/pay/orderquery";
		$appid = APPID;
		$mchid = MACID;
		$nonce_str = $this->getRandChar(15);

		$data = array(
		    'appid'=>$appid,
		    'mch_id'=>$mchid,
		    'nonce_str'=>$nonce_str,
		    'out_trade_no'=>$out_trade_no,
	    );
		$sign = $this->get_signature($data);

		$post = "<xml>
			<appid>$appid</appid>
			<mch_id>$mchid</mch_id>
			<nonce_str>$nonce_str</nonce_str>
			<out_trade_no>$out_trade_no</out_trade_no>
			<sign>$sign</sign>
		</xml>";
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		// grab URL, and printe
		$data = curl_exec($ch);
		curl_close($ch);

		$xml = simplexml_load_string($data);//转换post数据为simplexml对象
		$res = "";
		foreach($xml->children() as $child) {    //遍历所有节点数据
			$res .= ',"'.$child->getName() . '":"' . $child . '"';
		}

		$res = substr($res,1);
		$res = "{" . $res . "}";
		$res = json_decode($res);
		return $res;
	}
	//统一下单
	function unifiedorder($total_fee, $openid, $body, $out_trade_no) {
		$url ="https://api.mch.weixin.qq.com/pay/unifiedorder";
		$appid = APPID;
		$mchid = MACID;
		$nonce_str = $this->getRandChar(15);
		$spbill_create_ip = SPBILL_CREATE_IP;
		$notify_url =  "http://" . $_SERVER['HTTP_HOST']."/l_wx/paycallback.php";
		$trade_type = "JSAPI";

		$data = array(
		    'appid'=>$appid,
		    'mch_id'=>$mchid,
		    'nonce_str'=>$nonce_str,
		    'body'=>$body,
		    'out_trade_no'=>$out_trade_no,
		    'total_fee'=>$total_fee,
		    'notify_url'=>$notify_url,
		    'trade_type'=>$trade_type,
		    'openid'=>$openid,
		    'spbill_create_ip'=>$spbill_create_ip
	    );
//var_dump($data);
		$sign = $this->get_signature($data);

		$post = "<xml>
			<appid>$appid</appid>
			<mch_id>$mchid</mch_id>
			<nonce_str>$nonce_str</nonce_str>
			<body>$body</body>
			<openid>$openid</openid>
			<out_trade_no>$out_trade_no</out_trade_no>
			<total_fee>$total_fee</total_fee>
			<notify_url>$notify_url</notify_url>
			<trade_type>$trade_type</trade_type>
			<spbill_create_ip>$spbill_create_ip</spbill_create_ip>
			<sign>$sign</sign>
		</xml>";
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		// grab URL, and printe
		$data = curl_exec($ch);
		curl_close($ch);

		$xml = simplexml_load_string($data);//转换post数据为simplexml对象
		$res = "";
		foreach($xml->children() as $child) {    //遍历所有节点数据
			$res .= ',"'.$child->getName() . '":"' . $child . '"';
		}

		$res = substr($res,1);
		$res = "{" . $res . "}";
		$res = json_decode($res);
		return $res;
	}

	function curl_post_ssl($url, $vars, $second=30,$aHeader=array()) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_VERBOSE, '1');
		//超时时间
		curl_setopt($ch,CURLOPT_TIMEOUT,$second);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		//这里设置代理，如果有的话
		//curl_setopt($ch,CURLOPT_PROXY, '10.206.30.98');
		//curl_setopt($ch,CURLOPT_PROXYPORT, 8080);
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);// 只信任CA颁布的证书
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);// 检查证书中是否设置域名，并且是否与提供的主机名匹配

		//以下两种方式需选择一种
		//echo ROOT_PATH . "<br/>";
		//第一种方法，cert 与 key 分别属于两个.pem文件
		//默认格式为PEM，可以注释
		//curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLCERT, $_SERVER['DOCUMENT_ROOT'].'/l_wx/cert/cert.pem');
		//默认格式为PEM，可以注释
		//curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
		curl_setopt($ch,CURLOPT_SSLKEY, $_SERVER['DOCUMENT_ROOT'].'/l_wx/cert/key.pem');
		//curl_setopt($ch, CURLOPT_CAINFO, ROOT_PATH.'cert/rootca.pem'); // CA根证书（用来验证的网站证书是否是CA颁布）

		//第二种方式，两个文件合成一个.pem文件
		//curl_setopt($ch,CURLOPT_SSLCERT,getcwd().'/all.pem');

		if( count($aHeader) >= 1 ) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}

		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
		$data = curl_exec($ch);
		if($data) {
			curl_close($ch);
			return $data;
		} else {
			$error = curl_errno($ch);
			echo "call faild, errorCode:$error\n";
			curl_close($ch);
			return false;
		}
	}

	//获取订单详情
	function get_order_info($order_id) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/merchant/order/getbyid?access_token=$access_token";
		$post = array();
		$post["order_id"] = $order_id;
		$data = $this->file_get_contents_post($url, $post);

		$card_info = json_decode($data);

		return $card_info;
	}
	//生产永久二维码
	function create_ewm($post) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=$access_token";
		$data = $this->file_get_contents_post($url, $post);

		$res = json_decode($data);
		return $res->url;
		/*
		if (isset($res->ticket)) {
			//通过ticket换取二维码
			$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $res->ticket;
			define('BASE_PATH',$_SERVER['DOCUMENT_ROOT']);

			$name = '/upload_file/erweima/ewm_'.time().".jpg";

			file_put_contents(BASE_PATH . $name,$url);
			return $name;
		}*/
	}
	//卡券code解码
	function card_decrypt($post) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/code/decrypt?access_token=$access_token";
		$res = $this->file_get_contents_post($url, $post);
		$res = json_decode($res);
		return $res;
	}

	//卡卷使用
	function card_consume($post) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/code/consume?access_token=$access_token";
		$res = $this->file_get_contents_post($url, $post);

		$res = json_decode($res);

		return $res;
	}

	//向用户发送消息
	function send_msg($post) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$access_token";
		$data = $this->file_get_contents_post($url, $post);

		$card_list = json_decode($data);

		return $card_list;
	}
	//向用户发送图文消息
	function send_msg_img($post) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=$access_token";
		$data = $this->file_get_contents_post($url, $post);

		$card_list = json_decode($data);

		return $card_list;
	}

	//批量查询卡卷列表
	function get_card_list() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/batchget?access_token=$access_token";
		$post = array();
		$post["offset"] = 0;
		$post["count"] = 0;
		$data = $this->file_get_contents_post($url, $post);

		$card_list = json_decode($data);

		return $card_list;
	}

	//卡卷详情
	function get_card_info($card_id) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/get?access_token=$access_token";
		$post = array();
		$post["card_id"] = $card_id;
		$data = $this->file_get_contents_post($url, $post);

		$card_info = json_decode($data);

		return $card_info;
	}

	//导入门店
	function add_store() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/location/batchadd?access_token=$access_token";
		$post = array();
		$post["offset"] = 0;
		$post["count"] = 0;
		$data = $this->file_get_contents_post($url, $post);

		$store_list = json_decode($data);

		return $store_list;
	}

	//拉取门店列表
	function get_store() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/location/batchget?access_token=$access_token";
		$post = array();
		$post["offset"] = 0;
		$post["count"] = 0;
		$data = $this->file_get_contents_post($url, $post);

		$store_list = json_decode($data);

		return $store_list;
	}

	//获取用户openid
	function get_user_openid() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$codeurl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' .
						APPID  . '&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';
		$data = file_get_contents($url);
		$user_info = json_decode($data);
		return $user_info;
	}

	//获取用户信息
	function get_user_info($openid) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
		$data = file_get_contents($url);
		$user_info = json_decode($data);

		return $user_info;
	}

	//获取关注用户列表
	function get_user_list($next_openid="") {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=$access_token&next_openid=$next_openid";

		$data = file_get_contents($url);
		$user_list = json_decode($data);

		return $user_list;
	}

	//生成卡卷二维码
	function create_card_qrcode($card_id) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/qrcode/create?access_token=$access_token";
		$post = null;
		$post["action_name"] = "QR_CARD";
		$card = array();
		$card["card_id"] = $card_id;
		$action_info = array();
		$action_info["card"] = $card;
		$post["action_info"] = $action_info;
		$data = $this->file_get_contents_post($url, $post);
		$card_info = json_decode($data);

		return $card_info;
	}

	//生成带参数的二维码
	function create_qrcode_for_ticket($ticket) {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $ticket;

		$card_info = json_decode($data);

		return $card_info;
	}

	//自定义菜单
	public function createMenu() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=$access_token";
		$post = array();

		$button = array();
		$button["type"] = "click";
		$button["name"] = "小学霸网络评比";
		$button["key"] = "key_xbpb";

		$post["button"][] = $button;

		//echo $url;

		var_dump($this->file_get_contents_post($url, $post));
	}

	//获取最新颜色列表
	function get_colors() {
		$access_token=$this->get_acctoken();
		$access_token = $access_token[0];
		$url = "https://api.weixin.qq.com/card/getcolors?access_token=$access_token";

		$data = file_get_contents($url);
		$color_list = json_decode($data);
		if ("ok" == $color_list.errmsg) {
			$color_list = $color_list.colors;
		} else {
			$color_list = array();
		}
		return $color_list;
	}

	//获取acctoken
	function get_acctoken() {
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/access_token.txt", "r+") or die("Unable to open file!");

		$access_token_info = fread($file,"500");
		$access_token_info = explode(",", $access_token_info);
		fclose($file);

		if (time() - $access_token_info[1] > 7000 ) {
			$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' .
						APPID  . '&secret='. APPSECRET;
			//echo $url;
			$data = file_get_contents($url);
			$access_token = json_decode($data);
			$access_token_info[0] = $access_token->access_token;
			$access_token_info[1] = time();
			$txt = $access_token_info[0] . "," . $access_token_info[1];
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/access_token.txt", "w") or die("Unable to open file!");
			fwrite($file, $txt);
			fclose($file);
		}

		return $access_token_info;
	}

	//获取api_ticket
	function get_api_ticket() {
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket.txt", "r+") or die("Unable to open file!");
		$api_ticket_info = fread($file,"500");
		$api_ticket_info = explode(",", $api_ticket_info);
		fclose($file);

		if (time() - $api_ticket_info[1] > 7000 ) {

			$access_token=$this->get_acctoken();
			$access_token = $access_token[0];
			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=wx_card';
			$data = file_get_contents($url);
			$api_ticket = json_decode($data);
			$api_ticket_info[0] = $api_ticket->ticket;
			$api_ticket_info[1] = time();
			$txt = $api_ticket_info[0] . "," . $api_ticket_info[1];
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket.txt", "w") or die("Unable to open file!");
			fwrite($file, $txt);
			fclose($file);
		}

		return $api_ticket_info;
	}
	function getJsApiTicket() {
	  	$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket_js.txt", "r+") or die("Unable to open file!");

		$api_ticket_info = fread($file,"500");
		$api_ticket_info = explode(",", $api_ticket_info);
		fclose($file);
		if (time() - $api_ticket_info[1] > 7000 ) {
			$access_token=$this->get_acctoken();
			$access_token = $access_token[0];

			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token='.$access_token.'';
			$data = file_get_contents($url);
			$api_ticket = json_decode($data);
			//var_dump($api_ticket);
			$api_ticket_info[0] = $api_ticket->ticket;
			$api_ticket_info[1] = time();
			$txt = $api_ticket_info[0] . "," . $api_ticket_info[1];
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket_js.txt", "w") or die("Unable to open file!");
			fwrite($file, $txt);
			fclose($file);
		}
		return $api_ticket_info[0];
	}

	//卡券JsAPiTicket
	function getWxCardApiTicket() {
	  	$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket_wxcard.txt", "r+") or die("Unable to open file!");

		$api_ticket_info = fread($file,"500");
		$api_ticket_info = explode(",", $api_ticket_info);
		fclose($file);
		if (time() - $api_ticket_info[1] > 7000 ) {
			$access_token=$this->get_acctoken();
			$access_token = $access_token[0];

			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$access_token.'&type=wx_card';

			$data = file_get_contents($url);
			$api_ticket = json_decode($data);
			$api_ticket_info[0] = $api_ticket->ticket;
			$api_ticket_info[1] = time();
			$txt = $api_ticket_info[0] . "," . $api_ticket_info[1];
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/l_wx/api_ticket_wxcard.txt", "w") or die("Unable to open file!");
			fwrite($file, $txt);
			fclose($file);
		}
		return $api_ticket_info[0];
	}
	//模拟post提交
	function file_get_contents_post($url, $post=array()) {
		$post = json_encode($post, JSON_UNESCAPED_UNICODE);
		//$post = str_replace("\/", "/",  $post);
		//echo $post;
	    $options = array(
	        'http' => array(
	            'method' => 'POST',
	            // 'content' => 'name=caiknife&email=caiknife@gmail.com',
	            'header' => "Content-type: application/x-www-form-urlencoded ",
	            'content' => $post,
	        ),
	    );
		//echo $url;
	    $result = file_get_contents($url, false, stream_context_create($options));

	    return $result;
	}


	/**
	 * 复制操作
	 *
	 */
	function _copy($src, $dst) {
	    if ( ! is_dir($src)) {
	        if ( ! copy($src, $dst)) {
	            return _log('Unable to copy files', $src);
	        }
	    } else {
	        mkdir($dst);
	        $ls = scandir($src);

	        for ($i = 0; $i < count($ls); $i++) {
	            if ($ls[$i] == '.' OR $ls[$i] == '..') continue;

	            $_src = $src.'/'.$ls[$i];
	            $_dst = $dst.'/'.$ls[$i];

	            if ( is_dir($_src)) {
	                if ( ! _copy($_src, $_dst)) {
	                    return _log('Unable to copy files', $_src);
	                }
	            } else {
	                if ( ! copy($_src, $_dst)) {
	                    return _log('Unable to copy files', $_src);
	                }
	            }
	        }
	    }
	    return TRUE;
	}

	/**
	 * 生成随机数
	 */
	 function getRandChar($length){
		   $str = null;
		   $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
		   $max = strlen($strPol)-1;

		   for($i=0;$i<$length;$i++){
		    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
		   }

		   return $str;
	  }

	 //jsapi签名
	 public function get_js_signature($nonceStr, $timestamp, $url) {
	    $jsapiTicket = trim($this->getJsApiTicket());

	    // 这里参数的顺序要按照 key 值 ASCII 码升序排序
	    $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
		//echo $string;
	    $signature = sha1($string);
		

	    return $signature;
  }

	 //签名
	 function get_signature($data){
		//签名步骤一：按字典序排序参数
		@ksort($data);
		$string = $this->ToUrlParams($data);
		//签名步骤二：在string后加入KEY
		$string = $string . "&key=".KEY;
		//签名步骤三：MD5加密
		$string = md5($string);
		//签名步骤四：所有字符转为大写
		$result = strtoupper($string);
		return $result;
	}

	 //卡券签名
	 function get_signature_for_card($data){
		$string = "";
		foreach ($data as $k => $v) {
			$string .= $v;
		}

		//$string = $string . "&key=3Zwc3qWorJor4tZQu0xKUpy8RVHnQcBp";
		//签名步骤三：加密
		//$string = $this->getWxCardApiTicket() . $string;
		$string = $data[0] . APPSECRET . $data[1];

		$string = sha1($string);

		return $string;
	}
	/**
	 * 格式化参数格式化成url参数
	 */
	public function ToUrlParams($data)
	{
		$buff = "";
		foreach ($data as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}

		$buff = substr($buff, 0, strlen($buff)-1);
		return $buff;
	}
}
