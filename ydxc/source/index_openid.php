<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: index_userhome.php 2010-6-28 11:04:54 jerry $
*/
!defined('IN_CTB') && die('Access Denied');

$appid  = $_TCONFIG['weixin_AppId'];
$secret = $_TCONFIG['weixin_AppSecret'];
$code   = $_GET["code"];
//$tc   = $_CTB['siteurl']."index.php?do=openid";
$tc    = $cururl;  //redirect_uri url值 必须和网页授权的域名值一样  STATE  . urlencode($tc) . 
/*$base  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid;
$base .= "&redirect_uri=" . urlencode($tc) . "&response_type=code&scope=snsapi_userinfo&state=" . urlencode($tc) . "#wechat_redirect";*/
$base  = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid;
$base .="&redirect_uri=" . urlencode($tc) . "&response_type=code&scope=snsapi_userinfo&state=#wechat_redirect";
//echo $tc;die;
if ($code == NULL) {
    header("Location: $base");
}

/**
 * 获取信息
 * @param type $url
 * @return type
 */
function getRespons($url) {
    $ret = file_get_contents($url);
    return json_decode($ret, true);
}

$accToken = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid;
$accToken.="&secret=" . $secret . "&code=" . $code . "&grant_type=authorization_code";
$resToken = getRespons($accToken);
//var_dump($resToken);exit;

if ($resToken["openid"] == NULL || $resToken["access_token"] == NULL) {
    echo "OPENID NULL\r\n";
    exit;
}

$usinfo = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $resToken["access_token"];
$usinfo.="&openid=" . $resToken["openid"] . "&lang=zh_CN";
//var_dump(getRespons($usinfo));

$u = getRespons($usinfo);  //获取登录人员的个人信息
//var_dump($u);exit;
$_SESSION['member'] = $u;
//var_dump($_SESSION['member']['openid']);die;

//跳转到用户登录或注册页
$_SESSION['member']['invite'] = $_REQUEST['state'];

/*
//更新用户信息   没有进入更新信息
$arr = array(
		'CusName'          => 	$_SESSION['member']['nickname'],
		'Sex'              => 	$_SESSION['member']['sex'],
		'zone'             => 	$_SESSION['member']['province'].$_SESSION['userinfo']['city'],
		'img'			   => $_SESSION['member']['headimgurl'],	'openid'		   =>   $_SESSION['member']['openid'],
			);
updatetable('members',$arr, array('Openid' => $_SESSION['member']['openid']));


$sql = "SELECT *  FROM ".tname('members') . " WHERE openid ='".$_SESSION['member']['openid']."'";
//实现自动登录
$userarr = array(
	'userid'           => 	$userinfo['uid'],
	'username'         => 	$userinfo['username'],
	'password'         => 	$userinfo['password']
	);
insertsession($userarr);

//设置cookie
ssetcookie('auth', authcode("$userinfo[password]\t$userinfo[uid]", 'ENCODE'), 0);
*/

//weixin_sendmessage($_SESSION['member']['openid'], '亲，欢迎您回来！');

//var_dump($_REQUEST['state']);die;
//header("Location: ".$_REQUEST['state']);
header("Location: ".$cururl);

