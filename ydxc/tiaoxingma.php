<?php
// 引入通用文件
include_once('./common.php');
// 引入必须文件
require_once(S_ROOT . './lib/tiaoxingma/BCGFontFile.php');
require_once(S_ROOT . './lib/tiaoxingma/BCGColor.php');
require_once(S_ROOT . './lib/tiaoxingma/BCGDrawing.php');

// 引入条形码技术文件
require_once(S_ROOT . './lib/tiaoxingma/BCGcode39.barcode.php');
require_once(S_ROOT . './lib/function/function_extend.php');

$str = $_GET['str'];
echo tiaoxingma($str);
?>