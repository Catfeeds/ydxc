<?php
/*
 *  Copyright (c) 2014 The CCP project authors. All Rights Reserved.
 *
 *  Use of this source code is governed by a Beijing Speedtong Information Technology Co.,Ltd license
 *  that can be found in the LICENSE file in the root of the web site.
 *
 *   http://www.yuntongxun.com
 *
 *  An additional intellectual property rights grant can be found
 *  in the file PATENTS.  All contributing project authors may
 *  be found in the AUTHORS file in the root of the source tree.
 */

include_once("CCPRestSDK.php");

//主帐号
$accountSid= '8aaf070856b0e0520156b5aeda8e0076';

//主帐号Token
$accountToken= '9bbc2ff115f346d7988018e152f0dbcb';

//应用Id
$appId='8aaf070856b0e0520156b5aedab50077';

//请求地址，格式如下，不需要写https://
$serverIP='app.cloopen.com';

//请求端口 
$serverPort='8883';

//REST版本号
$softVersion='2013-12-26';


/**
  * 发送模板短信
  * @param to 手机号码集合,用英文逗号分开
  * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
  * @param $tempId 模板Id
  */       

     // 初始化REST SDK
     global $accountSid,$accountToken,$appId,$serverIP,$serverPort,$softVersion;
     $rest = new REST($serverIP,$serverPort,$softVersion);
     $rest->setAccount($accountSid,$accountToken);
     $rest->setAppId($appId);
    
     // 发送模板短信
     //echo "【忆学汇】您的验证码为{1}，请于{2}内正确输入，如非本人操作，请忽略此短信。";
	 $to  = "";
	 $msg = 'ok';
	 if (!empty($_REQUEST['phone'])) {
	 	$to = $_REQUEST['phone'];
	 } 
	 $randCharObj = new RandChar();
	 $visit = $randCharObj->getRandChar(5);
	 
	 $uid = $_GET['uid'];
	 if (!empty($to)) {
	 	     $result = $rest->sendTemplateSMS($to,array($visit),'112026');
		     if($result == NULL ) {
		         $msg = "result error!";
		     } else if($result->statusCode!=0) {
		         $msg = "error code :" . $result->statusCode . "<br>";
		         $msg .= "error msg :" . $result->statusMsg . "<br>";
		         //TODO 添加错误处理逻辑
		     }else{
		         $msg = "Sendind TemplateSMS success!<br/>";
		         // 获取返回信息
		         $smsmessage = $result->TemplateSMS;
		         $msg .= "dateCreated:".$smsmessage->dateCreated."<br/>";
		         $msg .= "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
		         //TODO 添加成功处理逻辑
		     }
	 }
	 
	 echo json_encode(array('msg'=>$msg, 'code'=>1, 'return'=>array('visit'=>$visit,'uid'=>$uid)), JSON_UNESCAPED_UNICODE);
	 exit();
	 
	 
class RandChar{

  function getRandChar($length){
   $str = null;
   $strPol = "0123456789";
   $max = strlen($strPol)-1;

   for($i=0;$i<$length;$i++){
    $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
   }

   return $str;
  }
 }


	 
?>
