<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_paycar_ok.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$id = @(int)$_GET['id'];
!$id && die('error');


$sql = "SELECT  p.*, m.Openid
	  FROM ".tname('paylog')." p
	  LEFT JOIN ".tname('members')." m ON p.CustomerID=m.CustomerID
	  WHERE p.id='$id'
	  ";
$info = $_TGLOBAL['db']->getrow($sql);
$_SESSION['member']['openid'] = $info['Openid']; //由于是从模板点击过来，实现自动登录

echo template('paycar_ok', get_defined_vars());
