<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_index.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$openid = $_SESSION['member']['openid'];

//获取分享代码
require_once "source/jssdk.php";
$jssdk = new JSSDK($_TCONFIG['weixin_AppId'], $_TCONFIG['weixin_AppSecret']);
$signPackage = $jssdk->GetSignPackage();

//分享领取代金券
/* if($_GET['op']=='share_coupon'){
	//分享信息 获得代金券 $profile['CustomerID']  分享信息代金券id：6
	$is_ok = insert_usercoupons($openid, 6);
	if($is_ok){
		showmessage_ajax(array('ok' => '分享成功,你成功领取代金券！', 'jumpto' => './'));
	}else{
		showmessage_ajax(array('error' => '你已经领取代金券！', 'jumpto' => './'));
	}
	die;
} */

//新用户进来领取代金券
if($_GET['op']=='new'){
	//获取好友信息
	$member = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE id='$_GET[id]' ");
	//好友获得代金券
	$is_ok = insert_usercoupons($member['Openid'], 6);
	//获取优惠券信息
	$coupon = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('coupons')." WHERE id=7 ");
	echo template('share_new', get_defined_vars());
	die;
}


if($_POST){
	//判断 用户手机是不是存在
	$username    = $_POST['username'];
	$PromotionID = $_POST['PromotionID'];
	$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE CusPhone='$username'");
	if ($member=$_TGLOBAL['db']->fetch_array($query)) {
		//showmessage_ajax(array('error' => '错误：手机号码已存在！'));
		$ok = 0;
	}else{
		$CustomerID = makecustomrno();
		$arr = array(
				'CustomerID'       => $CustomerID	,
				//'Openid'           => 	$_SESSION['member']['openid'], //为了让他再次登录的时候需要进入登录页面，所以不把openid写入数据库，到时候娶不到会员信息，则进入登录页面
				'CusName'          => 	$_SESSION['member']['nickname'],
				'CusPhone'         => 	$username,
				'PlateNumber'      => 	'',
				'Balance'          => 	0,
				'Sex'              => 	$_SESSION['member']['sex'],
				'Age'              => 	0,
				'zone'             => 	$_SESSION['member']['province'].$_SESSION['userinfo']['city'],
				'HomeAddress'      => 	'',
				'Status'           => 	1,
				'LogTime'          => 	$_TGLOBAL['timestamp'],
				'usertype'         => 	1,
				'img'			   => $_SESSION['member']['headimgurl'],
				);
		$id = inserttable('members', $arr, 1);
		//分享信息 获得代金券 $profile['CustomerID']  优惠券注册信息代金券id：7
		$is_ok = insert_usercoupons($openid, 7, $PromotionID, $CustomerID);
		
		
		
		
		$ok    = 1;
	}
	
	echo template('share_ok', get_defined_vars());
	die;
}

	
echo template('share', get_defined_vars());
?>