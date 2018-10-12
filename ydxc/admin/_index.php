<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: index.php 2010-1-12 11:49:05 jerry $
*/

//通用文件
include_once('../common.php');

//登录检查
!$_TCOOKIE['adminauth'] && header("Location: module.php");


include 'main.php';
?>