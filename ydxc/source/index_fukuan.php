<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

$newsshow['name'] = '在线付款';


if ($_POST){

	$openId = $_SESSION['member']['openid'];

/*
	$unifiedOrder = new UnifiedOrder_pub();
      
    //var_dump($unifiedOrder);
    //设置统一支付接口参数
    //设置必填参数
    //appid已填,商户无需重复填写
    //mch_id已填,商户无需重复填写
    //noncestr已填,商户无需重复填写
    //spbill_create_ip已填,商户无需重复填写
    //sign已填,商户无需重复填写
    $unifiedOrder->setParameter("openid","$openid");//商品描述
    $unifiedOrder->setParameter("body","贡献一分钱");//商品描述
    //自定义订单号，此处仅作举例
    $timeStamp = time();
    $out_trade_no = WxPayConf_pub::APPID."$timeStamp";
    $unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
    $unifiedOrder->setParameter("total_fee","1");//总金额
    $unifiedOrder->setParameter("notify_url",WxPayConf_pub::NOTIFY_URL);//通知地址 
    $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
    //非必填参数，商户可根据实际情况选填
    //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
    //$unifiedOrder->setParameter("device_info","XXXX");//设备号 
    //$unifiedOrder->setParameter("attach","XXXX");//附加数据 
    //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
    //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
    //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
    //$unifiedOrder->setParameter("openid","XXXX");//用户标识
    //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
  
    $prepay_id = $unifiedOrder->getPrepayId();
	
	
*/
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
	//$openId = 'ovwdGuCzVp7kfRxwtfeoTG1Rv_wA';

	$order_no = time().'_'.$_POST['sign_id']; //时间戳加上客户ID 再加原价金额
	
	//②、统一下单
	$input = new WxPayUnifiedOrder();
	$input->SetBody('学费');
	$input->SetAttach("test");
	//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));

	$input->SetOut_trade_no($order_no);

	$input->SetTotal_fee($_POST['price']*100);
	//$input->SetTotal_fee("1");
	$input->SetTime_start(date("YmdHis"));
	//$input->SetTime_expire(date("YmdHis", time() + 600));  // 这个字段不是必须填写的，如果提示时间过短，可以注释
	$input->SetGoods_tag("test");
	$input->SetNotify_url(getsiteurl()."notify.php");

	$input->SetTrade_type("JSAPI");
	$input->SetOpenid($openId);
	$order = WxPayApi::unifiedOrder($input);
	//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
	printf_info($order);die;  // 展示生成的订单信息
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

$courseid = $_GET['courseid'];
$sign_id  = $_GET['id'];
$course   = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('course')." WHERE id='$courseid'");


echo template('fukuan', get_defined_vars());
?>