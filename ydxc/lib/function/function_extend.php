<?php
// 引入通用文件
//include_once('./common.php');
// 引入必须文件
/*
require_once(S_ROOT . './lib/tiaoxingma/BCGFontFile.php');
require_once(S_ROOT . './lib/tiaoxingma/BCGColor.php');
require_once(S_ROOT . './lib/tiaoxingma/BCGDrawing.php');

// 引入条形码技术文件
require_once(S_ROOT . './lib/tiaoxingma/BCGcode39.barcode.php');
*/




//echo tiaoxingma('hallo');

function tiaoxingma($str){
	// 设置颜色
	$color_black = new BCGColor(0, 0, 0);
	$color_white = new BCGColor(255, 255, 255);
	
	// 加载文字样式
	$font = new BCGFontFile(S_ROOT . './lib/tiaoxingma/font/Arial.ttf', 18);
	
	$drawException = null;
	try {
		$code = new BCGcode39();
		$code->setScale(2); // 分辨率
		$code->setThickness(30); // 厚度
		$code->setForegroundColor($color_black); // 条形码颜色
		$code->setBackgroundColor($color_white); // 空白区域颜色
		$code->setFont($font); // Font (or 0)
		$code->parse($str); // 测试文字
	} catch(Exception $exception) {
		$drawException = $exception;
	}

	/* 参数列表
	1 - 文件名（空：屏幕上显示）
	2 - 背景颜色 */
	$drawing = new BCGDrawing('', $color_white);
	if($drawException) {
		$drawing->drawException($drawException);
	} else {
		$drawing->setBarcode($code);
		$drawing->draw();
	}

	// 它是一个图像（如果你把它保存到一个文件中），你就可以把它删除
	header('Content-Type: image/png');

	// 保存为PNG格式的图片
	return $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);
}

?>