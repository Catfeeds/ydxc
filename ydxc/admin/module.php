<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: module.php 2009-5-3 21:46:55 jerry $
*/
//通用文件
include_once('../common.php');
include_once(S_ROOT.'./lib/function/function_admin.php');
//echo makeno('store', 'barcode', 12, '001');

//加载缓存
loadcache('menu'        ,'id', '', 'orderlist'); // 后台菜单缓存
loadcache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限


// 组合一级二级菜单
foreach($_TGLOBAL['menu'] as $key=>$val){
	if($val['pid']==0){
		$top_menu[] = $val; //组合一级菜单
		$dos[] = $val['mod']; //允许的方法
	}else{
		$left_menu[] = $val; //组合二级菜单
		$acs[$val['mod']][] = $val['ac'];  //允许的ac
	}
}


$ac  = (empty($_GET['ac']) || !in_array($_GET['ac'], $dos)) ? 'system' : $_GET['ac'];
$op  = empty($_GET['op']) ? '' : $_GET['op'];
$mod = (empty($_GET['mod']) || !in_array($_GET['mod'], $acs[$ac])) ? 'login' : $_GET['mod'];

//焦点菜单
$actives = array($op => ' class="active"');

include_once('./'.$ac.'_'.$mod.'.php');

//检查是否记录管理员日志
isset($_TCONFIG['allowadminlog']) && adminlogs();
?>