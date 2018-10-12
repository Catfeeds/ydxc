<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/ydxc/index.php?do=getwxinfo"); 
	exit();
}

$id = $_REQUEST['id'];

if(!empty($id)){
	$cd_info  = $_TGLOBAL['db']->getrow("SELECT title,id,lng,lat FROM ".tname('news')." WHERE id=".$id);
}

echo template('go', get_defined_vars());

?>