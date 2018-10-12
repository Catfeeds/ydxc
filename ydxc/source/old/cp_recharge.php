<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_recharge.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

if ($op == 'add') 
	{
	//require_once "source/jssdk.php";
	//$jssdk = new JSSDK($_TCONFIG['weixin_AppId'], $_TCONFIG['weixin_AppSecret']);
	//$signPackage = $jssdk->GetSignPackage();

	require_once "./wxpay/example/WxPay.JsApiPay.php";
	require_once './wxpay/example/log.php';

	//初始化日志
	$logHandler= new CLogFileHandler("./wxpay/logs/".date('Y-m-d').'.log');
	$log = Log::Init($logHandler, 15);

	//打印输出数组信息
	function printf_info($data)
	{
		foreach($data as $key=>$value){
			echo "<font color='#00ff55;'>$key</font> : $value <br/>";
		}
	}

	//①、获取用户openid
	$tools = new JsApiPay();
	//$openId = $tools->GetOpenid();
	$openId = $_SESSION['member']['openid'];
//$openId = 'ovwdGuCzVp7kfRxwtfeoTG1Rv_wA';

	$order_no = time().'_'.$userinfo['CustomerID']."_".$_POST['pmount']; //时间戳加上客户ID 再加原价金额
	//②、统一下单
	$input = new WxPayUnifiedOrder();
	$input->SetBody('人人优泊会员充值');
	$input->SetAttach("test");
	//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));

	$input->SetOut_trade_no($order_no);

	$input->SetTotal_fee($_POST['amount']*100);
	//$input->SetTotal_fee("1");
	$input->SetTime_start(date("YmdHis"));
	$input->SetTime_expire(date("YmdHis", time() + 600));
	$input->SetGoods_tag("test");
	$input->SetNotify_url(getsiteurl()."notify.php");

	$input->SetTrade_type("JSAPI");
	$input->SetOpenid($openId);
	$order = WxPayApi::unifiedOrder($input);
	//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
	//printf_info($order);
	$jsApiParameters = $tools->GetJsApiParameters($order);

	//获取共享收货地址js函数参数
	//$editAddress = $tools->GetEditAddressParameters();

	//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
	/**
	 * 注意：
	 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
	 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
	 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
	 */

	//$return['data'] = $jsApiParameters;
	//echo json_encode($return);
	
	
	echo $jsApiParameters;
	exit;
}
$userinfo['CusPhone'] = get_cardno_star($userinfo['CusPhone']);
echo template('recharge', get_defined_vars());
