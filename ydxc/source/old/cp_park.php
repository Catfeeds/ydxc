<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_park.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
//header("location:http://j.map.baidu.com/ARC_5");
header("location:http://map.baidu.com/mobile/webapp/place/detail/qt=inf&uid=cd9d05ddc3d2b6cb85420e12/vt=map");
//header("location:http://map.baidu.com/mobile/webapp/index/index/");

echo template('park', get_defined_vars());
?>