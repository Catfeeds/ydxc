<?php
/*
	[CTB] (C) 2007-2009 
	$Id: order4user.inc.php 2010-7-1 11:37:19 jerry $
*/

!defined('IN_CTB') && die('Access Denied');


//ͳ�������û��Ķ�������
$query = $_TGLOBAL['db']->query("SELECT userid, COUNT(*) nums
								FROM ".tname('orders')."
								GROUP BY userid
								");
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET order_nums = '$value[nums]' WHERE uid='$value[userid]'"); //�����û��Ķ�����
}


//ÿ�ո����û����Ƽ�����
$query = $_TGLOBAL['db']->query("SELECT uid, weixin
								FROM ".tname('members')."
								WHERE weixin!=''
								");
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$nums = @(int)getcount('members', "recomm_id= '$value[weixin]'");
		$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET nums = '$nums' WHERE uid='$value[uid]'"); //�����û����Ƽ�������ֱ��
}



?>