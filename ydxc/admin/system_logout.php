<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: syste_logout.php 2010-01-12 18:58:22 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$_TGLOBAL['db']->query('UPDATE '.tname('admin')." SET logintime='' WHERE userid ='$_TGLOBAL[adm_userid]'");
ssetcookie('adminauth', '', -86400 * 365);

$_TGLOBAL['adm_userid'] = $_TGLOBAL['adm_username'] = $_TGLOBAL['adm_role_id'] = '';

showmsg('退出系统成功，正在返回管理员首页','index.php');

?>