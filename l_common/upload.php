<?php
//ini_set("display_errors", "On");
//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/tool/upload.php';
$upload = new ImagesTool();
echo json_encode($upload->upload());
exit();
