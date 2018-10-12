<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/index.php?do=getwxinfo"); 
	exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';	
$wx = new Weixin_class();

$data = $_POST['data'];

$class_id = $_GET['class'];
$tj = $_GET['tj'];
$price = $_GET['money'];
if(!empty($tj)){
	
	$name = $data['uname'];
	$phone = $data['phone'];
	$tjz_id = $data['tjz_id'];
	$news = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$tjz_id);
	$org_id = $news['class_id'];
	$tj = array(
			"openid"		=> $_SESSION['openid'],
			"name"		=> $name,
			"phone"		=> $phone,
			"station"	=> $tjz_id,
			"organization" => $org_id,
			"inputtime"	=> time(),
		);
		
	inserttable("check",$tj);
	$insert_id = $_TGLOBAL['db']->insert_id();
	$is_insert = mysql_affected_rows();//获取插入条数
} else {
	$name = $data['uname'];
	$phone = $data['phone'];
	$card_id = $data['card_id'];
	$school = $data['school'];
	$coach_id = $data['coach_id'];
	$coach_km = $data['coach_km'];
	$inv = $data['inv'];
	$zd_price = $data['zd_price'];
	
	$sign = array(
				"name"		=> $name,
				"mobile"		=> $phone,
				'courseid'	=> $class_id,
				'coach_id'	=> $coach_id,
				'kemu'		=> $coach_km,
				'inv'		=> $inv,
				'money'		=> $zd_price,
				"cardno"		=> $card_id,
				"area"		=> $school,
				"openid"		=> $_SESSION['openid'],
				"date"		=> time()
			);
			
	inserttable("sign",$sign);
	$insert_id = $_TGLOBAL['db']->insert_id();
	$is_insert = mysql_affected_rows();//获取插入条数
	
	//更新wx_user表里的name phone 身份证数据
	$where = array('openid'=>$_SESSION['openid']);
	$updt = array(
				'name'		=>	$name,
				'phone'		=>	$phone,
				'card_id'	=>	$card_id,
				'shcool'		=>	$school
			);
	updatetable('wx_user',$updt,$where);
}
if ($is_insert > 0) {
	$code = 0;
	$openid = $_SESSION['openid'];
	if(!empty($tj)){
		$out_trade_no = "tjnew_".time().$wx->getRandChar(8);
	} else {
		$out_trade_no = "ydnew_".time().$wx->getRandChar(8);
	}
	$total_fee = $price * 100;
	if (!empty($total_fee) && $total_fee > 0 && !empty($openid)) {
		$code = 1;
		$msg = "我们会在两个工作日内联系您，请保持手机畅通，耐心等待，谢谢！";
		$unifiedOrderResult = $wx->unifiedorder($total_fee, $openid, '驾校学车', $out_trade_no);
		//var_dump($unifiedOrderResult);
		$timeStamp = intval(time()/10);
		$url = $_SERVER[HTTP_REFERER];
		//echo $url;
		$nonceStr = $wx->getRandChar(15);
		//echo $url;
		$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);
		//var_dump($unifiedOrderResult);exit();
		$package = "prepay_id=".$unifiedOrderResult->prepay_id;
		$data = array("timeStamp"=>$timeStamp,"nonceStr"=>$nonceStr,
			"package"=>$package, "signType"=>"MD5", "appId"=>'wx09e39aed7d3c3912');
			
		$paySign = $wx->get_signature($data);
		$code = 1;
		$content = array('package'=>$package, 'paySign'=>$paySign, 'appId'=>'wx09e39aed7d3c3912', 'timestamp'=>$timeStamp, 'nonceStr'=>$nonceStr, 'signature'=>$signature);
		
		if(!empty($class_id)){
			$sn = array("sn"=>$out_trade_no);
			$where= array("id"=>$insert_id);
			updatetable("sign",$sn,$where);
		} else {
			$sn = array("sn"=>$out_trade_no);
			$where = array("id"=>$insert_id);
			updatetable("check",$sn,$where);
		}
	}
	if (empty($_SESSION['openid'])) {
		$code = -1;
	}
	echo json_encode(array('code' => $code, 'msg' => $msg, 'content' => $content), JSON_UNESCAPED_UNICODE);
 	//$_TGLOBAL['db']->query("UPDATE ".tname('captain')." SET `openid`='".$_SESSION['openid']."' WHERE phone = '$phone' ");
}

?>
