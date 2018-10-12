<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';
$wx = new Weixin_class();
$wx->createMenu();