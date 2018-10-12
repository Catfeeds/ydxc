<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: ccdos.php 防止CCDOS攻击 2011-9-2 21:14:43 jerry $
	同一会话，如果在5秒钟内，刷新了10次就将响应指向到本地服务(http://127.0.0.1)
*/

!defined('IN_CTB') && die('Access Denied');

@session_start(); 
$timestamp  = time(); 
$cc_nowtime = $timestamp ;
if (isset($_SESSION['cc_lasttime'])){
   $cc_lasttime = $_SESSION['cc_lasttime'];
   $cc_times = $_SESSION['cc_times'] + 1;
   $_SESSION['cc_times'] = $cc_times;
}else{
   $cc_lasttime = $cc_nowtime;
   $cc_times = 1;
   $_SESSION['cc_times'] = $cc_times;
   $_SESSION['cc_lasttime'] = $cc_lasttime;
}


// 5秒内请求次数 
if (($cc_nowtime - $cc_lasttime) < 5){
   if ($cc_times >= 10){  //请求10次
       //header(sprintf("Location: %s",'http://127.0.0.1'));
	   showmessage('你请求太过于频繁，请稍候再访问');
       exit;
    }
}else{
   $cc_times = 0;
   $_SESSION['cc_lasttime'] = $cc_nowtime;
   $_SESSION['cc_times'] = $cc_times;
}

