<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: common.php 2010-1-11 10:18:01 jerry $
*/

define('IN_CTB', TRUE);
define('X_VER', '2.0');
define('X_RELEASE', '20151204');
define('D_BUG', '1');
/**
 * 错误日志开启
 */
ini_set("display_errors", "On");
  //error_reporting(E_ALL);
 error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
 
D_BUG ? error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING) : error_reporting(0);
$_TGLOBAL = $_TCONFIG =  $_TCOOKIE = array();

//header("Cache-control: private"); //提交表单信息不被清空
session_start();

//程序目录
define('S_ROOT', dirname(__FILE__).DIRECTORY_SEPARATOR);

//基本文件
if(file_exists(S_ROOT.'./config.php')){ 
	include_once(S_ROOT.'./config.php');
}else{
	die('系统文件config.php不存在，请检查');
}

//通用函数
include_once(S_ROOT . './lib/function/function_common.php');
include_once(S_ROOT . './lib/function/function_weixin.php');

//GPC过滤
$magic_quote = get_magic_quotes_gpc();
if(empty($magic_quote)) {
	$_GET  = saddslashes($_GET);
	$_POST = saddslashes($_POST);
}



//本站URL
if(empty($_CTB['siteurl'])) $_CTB['siteurl'] = getsiteurl();
$_TGLOBAL['ctb_starttime'] = isset($_TGLOBAL['ctb_starttime']) ? $_TGLOBAL['ctb_starttime'] : 0; //防止数据库中报错

//链接数据库
dbconnect();

//缓存文件
foreach (array('config','weixin_class') as $value) {
	if(file_exists(S_ROOT . './data/data_' . $value . '.php')) {
		include_once(S_ROOT . './data/data_' . $value . '.php');
	}else{
		include_once(S_ROOT . './lib/function/function_cache.php');
		$cache_func = $value.'_cache';
		$cache_func();		
	}
}
include_once(S_ROOT . './data/data_setting.php');
include_once(S_ROOT . './data/data_mail.php');
include_once(S_ROOT . './data/data_spam.php');


// 还有 微信公众号的类别、 配置信息没有更改缓存文件
include_once(S_ROOT . './lib/function/function_cache.php');
//loadcache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限

// loadcache() 引入缓存文件函数（如果没有就自己生成）
//loadcache('menu'        ,'id', '', 'orderlist'); // 后台菜单缓存
//loadcache('news_class'  ,'id', '', 'orderlist'); 
loadcache('admin_role'  ,'id', '', 'orderlist'); 
loadcache('course','id', '', 'id'); 
loadcache('member_group','id', '', 'orderlist'); 
loadcache('news_class'  ,'id', '', 'orderlist', 1);  // 为树状缓存

$_TCONFIG['weixin_AppId']     = 'wx09e39aed7d3c3912';
$_TCONFIG['weixin_AppSecret'] = '76cfa4026c9361f11df0774283d08d35';
//include_once(S_ROOT . './lib/ccdos.php'); // 连续请求 5秒内10次

//时间
//$mtime = explode(' ', microtime());
//$_TGLOBAL['timestamp'] = $mtime[1];
//$_TGLOBAL['ctb_starttime'] = $_TGLOBAL['timestamp'] + $mtime[0];

//生成时间戳
$_TGLOBAL['timestamp'] = intval(time()/10);

/**
* 	作用：产生随机字符串，不长于32位
*/
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
	$str ="";
	for ( $i = 0; $i < 32; $i++ )  {
		$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
	}

//处理时差
if(sgmdate('H:i') != date('H:i')) {
	$_TGLOBAL['timestamp'] = $_TGLOBAL['timestamp'] + $_TGLOBAL['setting']['timeoffset'] * 3600;
}

//计划任务
if ($_TGLOBAL['setting']['cronnextrun'] && $_TGLOBAL['setting']['cronnextrun'] <= $_TGLOBAL['timestamp']) {
	require_once S_ROOT.'./source/function_cron.php';
	runcron();
}

//COOKIE
$prelength = strlen($_CTB['cookiepre']);
foreach($_COOKIE as $key => $val) {
	if(substr($key, 0, $prelength) == $_CTB['cookiepre']) {
		$_TCOOKIE[(substr($key, $prelength))] = empty($magic_quote) ? saddslashes($val) : $val;
	}
}

//启用GIP
if ($_CTB['gzipcompress'] && function_exists('ob_gzhandler')) {
	ob_start('ob_gzhandler');
} else {
	ob_start();
}

//初始化
$_TGLOBAL['ctb_uid'] = 0;
$_TGLOBAL['ctb_username'] = '';
$_TGLOBAL['refer'] = empty($_SERVER['HTTP_REFERER']) ? '' : $_SERVER['HTTP_REFERER'];

//登录注册防灌水机
$_TCONFIG['sitekey'] = '';
if(empty($_TCONFIG['login_action'])) $_TCONFIG['login_action'] = md5('login'.md5($_TCONFIG['sitekey']));
if(empty($_TCONFIG['register_action'])) $_TCONFIG['register_action'] = md5('register'.md5($_TCONFIG['sitekey']));

//整站风格
if(iswap()){
	$_TCONFIG['template'] = 'wap';
}
if(empty($_TCONFIG['template'])) {
	$_TCONFIG['template'] = 'default';
}

if(isset($_TCOOKIE['mytemplate'])) {
	$_TCOOKIE['mytemplate'] = str_replace('.','',trim($_TCOOKIE['mytemplate']));
	if(file_exists(S_ROOT.'./template/'.$_TCOOKIE['mytemplate'].'/style.css')) {
		$_TCONFIG['template'] = $_TCOOKIE['mytemplate'];
	} else {
		ssetcookie('mytemplate', '');
	}
}

//处理REQUEST_URI
if(!isset($_SERVER['REQUEST_URI'])) {  
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'];
	if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
}

//生成当前页面地址
//var_dump($_REQUEST);die;
!isset($_SESSION['member']['openid']) && $_SESSION['member']['openid'] = isset($_GET['openid']) ? $_GET['openid'] : ''; //处理传递过来的时自动登录

if (!$_SESSION['member']['openid'] && is_weixin()) {
	//$cururl = $_CTB['siteurl'].'index.php?do='.$_GET['do'];
	//$cururl = rawurlencode($_CTB['siteurl'].$_SERVER['REQUEST_URI']);
	
	$cururl = $_CTB['siteurl'].$_SERVER['REQUEST_URI'];
	//include_once(S_ROOT.'./source/index_openid.php');  // 配置中验证token的url出错  redirect_uri 出错
}

//判断后台登录状态
/*if(isset($_TCOOKIE['adminauth'])) {
	list($password, $uid) = explode("\t", authcode($_TCOOKIE['adminauth'], 'DECODE'));
	$_TGLOBAL['adm_userid'] = intval($uid);
	if($_TGLOBAL['adm_userid']) {
		$query = $_TGLOBAL['db']->query("SELECT a.*, s.name storename FROM ".tname('admin')." a
												JOIN ".tname('store')." s ON a.storeid=s.id
												WHERE a.userid='$_TGLOBAL[adm_userid]' AND a.password='$password'");
		if($admininfo = $_TGLOBAL['db']->fetch_array($query)) {
			$_TGLOBAL['adm_username']   = addslashes($admininfo['username']);
			$_TGLOBAL['adm_name']       = addslashes($admininfo['name']);
			$_TGLOBAL['adm_storeid']    = addslashes($admininfo['storeid']);
			$_TGLOBAL['adm_storename']  = addslashes($admininfo['storename']);
			$_TGLOBAL['adm_role_id']    = $admininfo['role_id'];
		}
	}
}*/

if(isset($_TCOOKIE['adminauth'])) {
	list($password, $uid) = explode("\t", authcode($_TCOOKIE['adminauth'], 'DECODE'));
	$_TGLOBAL['adm_userid'] = intval($uid);
	if($_TGLOBAL['adm_userid']) {
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('admin')." WHERE userid='$_TGLOBAL[adm_userid]' AND password='$password'");
		if($admininfo = $_TGLOBAL['db']->fetch_array($query)) {
			$_TGLOBAL['adm_username']   = addslashes($admininfo['username']);
			//$_TGLOBAL['adm_name']       = addslashes($admininfo['name']);
			//$_TGLOBAL['adm_storeid']    = addslashes($admininfo['storeid']);
			//$_TGLOBAL['adm_storename']  = getcount('store', "id=$_TGLOBAL[adm_storeid]", 'name');
			$_TGLOBAL['adm_role_id']    = $admininfo['role_id'];
		}
	}
}

//判断用户登录状态
checkauth();



$_TGLOBAL['setting']['class_template'] = array(
											   'list_news'       => '文章列表',
											   'list_pic'   => '图片列表',
											   'intro'      => '单文章介绍',
											   );  //文章类别，显示模板
											   
//表格行单击时的颜色
!isset($_TCONFIG['table_tr_click']) && $_TCONFIG['table_tr_click'] = '#febf00';

$_TGLOBAL['setting']['sex'] = array(
							   '1'       => '男',
							   '2'       => '女',
							   '3'       => '保密',
							   );  //
$_TGLOBAL['setting']['banner_flag']  = array(
							   '1'       => '导航下焦点图',
							   '2'       => '手机焦点图',
							   );  //
											   
$_TGLOBAL['setting']['weixin_type'] = array('click'		=> '点击推事件', 
											'view' => '跳转URL',
											'scancode_push' => '扫码推事件',
											); //微信菜单事件类型
											   
$_TGLOBAL['setting']['kemu']  = array(
							   '2'       => '科目二',
							   '3'       => '科目三',
							   //'tjz'       => '体检站',
							   );  //
$_TGLOBAL['setting']['drive_type'] = array(
											'C1' => 'C1',
											'C2'	 => 'C2',	
										);
/**
 * 循环取出  场地id => 场地name
 */									
$cd_info = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news')." WHERE class_id=5");
for($i=0;$i<count($cd_info);$i++){
	$cd_info_arr[$cd_info[$i]['id']] = $cd_info[$i]['title'];	
}																		
$_TGLOBAL['setting']['sscd'] = $cd_info_arr;






