<?php
define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
$wx = new Weixin_class();

$method=$_REQUEST['method']?$_REQUEST['method']:'getCode';


switch ($method) {//获取code
	case "getCode":
		$state = $_REQUEST['state']?$_REQUEST['state']:"STATE";
		$scope = $_REQUEST['scope']?$_REQUEST['scope']:"snsapi_base";
		
		$redirect_uri = urldecode($_REQUEST["redirect_uri"])?urldecode($_REQUEST["redirect_uri"]):"http://" . $_SERVER['HTTP_HOST']."/l_wx/getwxinfo.php?method=getOpenId";//urlencode
		if (!empty($redirect_uri)) {
			$codeurl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' .
								APPID  . '&redirect_uri='. 
								$redirect_uri .'&response_type=code&scope='.$scope.'&state=' . 
								$state . '#wechat_redirect';
		}
//		/echo $codeurl;exit();
		header("Location:$codeurl");
		break;
	//根据openid获取用户信息
	case "getUserInfoForOpenid":
		$openid = $_REQUEST['openid'];
		if (!empty($openid)) {
			$access_token = $wx->get_acctoken();
			$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token[0]."&openid=$openid&lang=zh_CN";
			//echo $url;
			$data = file_get_contents($url);
			$data = json_decode($data, JSON_UNESCAPED_UNICODE);
			if (!$data['errcode']) {
				echo json_encode($data, JSON_UNESCAPED_UNICODE);
				exit();
			} else {
				echo "";
			}
		}
		break;
		
	case "getUserInfo":
		$code = @$_REQUEST["code"];
		$state = $_REQUEST['state']?$_REQUEST['state']:"STATE";
		
		$getaccessurl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.
						APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		//echo $getaccessurl;
		$data = file_get_contents($getaccessurl);
		$data = json_decode($data, true);
		
		
		if ($data["errcode"] == 40029 || $data['errcode'] == 41008) {//code无效重新获取
			$url = "/l_wx/getwxinfo.php?method=getCode&state=".$state."&scope=snsapi_userinfo&redirect_uri=".urlencode("http://" . $_SERVER['HTTP_HOST']."/l_wx/getwxinfo.php?method=getUserInfo");
			header("Location:" . $url);
			exit();
		}
		$infourl = "https://api.weixin.qq.com/sns/userinfo?access_token=".$data['access_token'] . 
			"&openid=" . $data['openid'] . "&lang=zh_CN";
			
		$user_info = file_get_contents($infourl);
		$data= json_encode($user_info, JSON_UNESCAPED_UNICODE);
		
		switch($state) {
			case 'addStudent':
				
				$url = "/s_user/student.php?method=showbm&data=".$data;
				header("Location:" . $url);
				exit();
				break;
			case 'showxxds':
				$url = "/s_user/tp.php?method=showxxds&data=".$data;
				header("Location:" . $url);
				exit();
				break; 
				
			case 'index':
				$url = "/client/getinfo.php?data=".$data;
				header("Location:" . $url);
				exit();
				break; 
			case 'ydxcnew':
				$url = "/index.php?do=getwxinfo&data=".$data;
				header("Location:" . $url);
				exit();
				break; 
		}
		
		//var_dump($data);exit();
		break;
		
	case "getOpenId":
		$code = @$_REQUEST["code"];
		$state = $_REQUEST['state']?$_REQUEST['state']:"STATE";
		
		$getaccessurl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid='.
						APPID.'&secret='.APPSECRET.'&code='.$code.'&grant_type=authorization_code';
		//echo $getaccessurl;
		$data = file_get_contents($getaccessurl);
		$data = json_decode($data, true);
		if ($data["errcode"] == 40029 || $data['errcode'] == 41008) {//code无效重新获取
			$url = "/l_wx/getwxinfo.php?method=getCode&state=".$state;
			header("Location:" . $url);
			exit();
		}
		switch($state) {
			case 'addStudent':
				
				$url = "/s_user/student.php?method=showbm&openid=".$data["openid"];
				header("Location:" . $url);
				exit();
				break;
			case 'showxxds':
				$url = "/s_user/tp.php?method=showxxds&openid=".$data["openid"];
				header("Location:" . $url);
				exit();
				break; 
				
			case 'index':
				$url = "/client/getinfo.php?openid=".$data["openid"];
				header("Location:" . $url);
				exit();
				break; 
		}
		
		var_dump($data);exit();
		break;
}

/*
$url = "https://api.weixin.qq.com/connect/oauth2/access_token?appid=" . 
APPID ."&secret=" . 
APPSECRET ."&code=" . $code . "&grant_type=authorization_code";*/
						




