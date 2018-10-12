<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_logout.php 2010-6-21 23:33:11 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$_TGLOBAL['db']->query('DELETE FROM '.tname('session') . " WHERE userid='$_TGLOBAL[ctb_uid]'");
clearcookie();

showmessage('logout_is_success', 'index.php', 2);
?>