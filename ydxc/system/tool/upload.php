<?php
/******************************************************************************

参数说明:
$max_file_size  : 上传文件大小限制, 单位BYTE
$destination_folder : 上传文件路径
$watermark   : 是否附加水印(1为加水印,其他为不加水印);

使用说明:
1. 将PHP.INI文件里面的"extension=php_gd2.dll"一行前面的;号去掉,因为我们要用到GD库;
2. 将extension_dir =改为你的php_gd2.dll所在目录;
返回码说明：

******************************************************************************/
include_once $_SERVER['DOCUMENT_ROOT'] . '/system/tool/FileAddFolderTool.php';

//图片上传相关配置
define("DESTINATION_FOLDER", "/data/upload/images/");//文件上传路径 本地绝对路径
define("UPLOAD_FILE_MAX_SIZE", 10000000);//文件大小限制
define("WATER_STRING", "");//水印文字
define("WATER_IMG", $_SERVER['DOCUMENT_ROOT'] . "/data/images/logo.png");//水印图片


class ImagesTool {
	function upload() {
		$uptypes = array ( // 上传文件类型列表
				'image/jpg',
				'image/jpeg',
				'image/png',
				'image/pjpeg',
				'image/gif',
				'image/bmp',
				'image/x-png' 
		);
		
		$max_file_size = UPLOAD_FILE_MAX_SIZE; // 上传文件大小限制, 单位BYTE
		$destination_folder = $_SERVER['DOCUMENT_ROOT'] . DESTINATION_FOLDER; // 上传文件路径
		$watermark = 2; // 是否附加水印(1为加水印,其他为不加水印);
		$watertype = 1; // 水印类型(1为文字,2为图片)
		$waterstring = WATER_STRING; // 水印字符串
		$waterimg = WATER_IMG; // 水印图片
		$imgpreview = 1; // 是否压缩图(1为要,其他为不);
		$overwrite = true;
		$r_msg = array (); // 返回消息
		$r_msg ["code"] = "";
		$r_msg ["path"] = "";
		if ($_SERVER ['REQUEST_METHOD'] == 'POST') {
			if (! is_uploaded_file ( $_FILES ["Filedata"] ["tmp_name"] )) { // 是否存在文件
				$r_msg ["code"] = "80";
				return $r_msg;
			}
			
			$file = $_FILES ["Filedata"];
			if ($max_file_size < $file ["size"]) { // 检查文件大小
				$r_msg ["code"] = "81";
				return $r_msg;
			}
			
			if (! in_array ( $file ["type"], $uptypes )) { // 检查文件类型
				$r_msg ["code"] = "82";
				return $r_msg;
			}
			$year = Date("y");
			$m = Date("m");
			$d = Date("d");
			$rand = time() . rand(10000, 100000);
			$fileTool = new FileAddFolderTool();
			if (! file_exists ( $destination_folder )) {
				mkdir ( $destination_folder, 0777, true );
			}
			$fileTool->addFolder($destination_folder . $year);
			$fileTool->addFolder($destination_folder . $year . "/" . $m);
			$fileTool->addFolder($destination_folder . $year . "/" . $m . "/" . $d);

			$filename = $file ["tmp_name"];
			$image_size = getimagesize ( $filename );
			$pinfo = pathinfo ( $file ["name"] );
			$ftype = $pinfo ['extension'];
			$savefile =DESTINATION_FOLDER . $year . "/" . $m . "/" . $d . "/" . $rand. "." . $ftype;//相对路径
			$destination = $destination_folder . $year . "/" . $m . "/" . 
												$d . "/" . $rand. "." . $ftype;//绝对路径

			if (file_exists ( $destination ) && $overwrite != true) {
				$r_msg ["code"] = "83";
				return $r_msg;
			}
			if (! move_uploaded_file ( $file ["tmp_name"], $destination )) {
				$r_msg ["code"] = "84";
				return $r_msg;
			}
			//处理图片旋转问题
			$image = imagecreatefromstring(file_get_contents($destination));
			/*$exif = exif_read_data($destination);
			 //echo $exif['Orientation']. ' -- ' . $path;
			if(!empty($exif['Orientation'])) {
			 switch($exif['Orientation']) {
			 case 8:
			  $image = imagerotate($image,90,0);
			  break;
			 case 3:
			  $image = imagerotate($image,180,0);
			  break;
			 case 6:
			  $image = imagerotate($image,-90,0);
			  break;
			 }
			}*/
			imagejpeg($image,$destination);
			$pinfo = pathinfo ( $destination );
			$fname = $pinfo ["basename"];
			
			if ($watermark == 1) { // 加水印
				$r_msg ["code"] = $this->imageWaterMark ( $destination, 9, WATER_IMG );
				if ("69" != $r_msg ["code"]) {
					return $r_msg;
				}
			}
			
			if ($imgpreview == 1) { // 创建缩略图
				$r_msg ["code"] = $this->cut ( $destination, 360, 640 );
				if ("50" != $r_msg ["code"]) {
					return $r_msg;
				}
			}
			$r_msg ["code"] = "89";
			$r_msg ["path"] = $savefile;
			return $r_msg; // 上传成功！
		}
	}

	/**
	 * 图片裁剪
	 *
	 * @param string $src
	 *        	图片路径
	 * @param int $w
	 *        	缩略图宽度
	 * @param int $h
	 *        	缩略图高度
	 * @return mixed 返回缩略图路径
	 * 
	 */
	function cut($src, $w, $h) {
		$temp = pathinfo ( $src );
		$name = $temp ["basename"]; // 文件名
		$dir = $temp ["dirname"]; // 文件所在的文件夹
		$extension = $temp ["extension"]; // 文件扩展名
		$savepath = "{$dir}/" . "s_" . "{$name}"; // 缩略图保存路径,新的文件名为*.thumb.jpg
		                                          
		// 获取图片的基本信息
		$info = GetImageSize ( $src );
		$width = $info [0]; // 获取图片宽度
		$height = $info [1]; // 获取图片高度
		$per1 = round ( $width / $height, 6); // 计算原图长宽比
		$per2 = round ( $w / $h, 6); // 计算缩略图长宽比
		                              
		// 计算缩放比例
		if ($per1 > $per2 || $per1 == $per2) {
			// 原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
			$per = $w / $width;
		}
		if ($per1 < $per2) {
			// 原图长宽比小于缩略图长宽比，则按照高度优先
			$per = $h / $height;
		}
		
		$dst_x = 0;//设定需要载入的图片在新图中的x坐标
		$dst_y = 0;//设定需要载入的图片在新图中的y坐标
		//如果宽大于高，以高为主
		if ($per1 > $per2) {
			$hb =  round($height/$h, 6);
			$temp_w = $w*$hb;
			$temp_h = $h*$hb;
			$dst_x =abs($width - $temp_w)/2;
		} else {
			$hb =  round($width/$w, 6);
			$temp_h = $h*$hb;
			$temp_w = $w*$hb;
			$dst_y =abs($height - $temp_h)/2; 
		}
		//echo $width . ' - ' . $temp_w;exit();
		
		//$dst_x =($width - $temp_w)/2;
		//$dst_y =($height - $temp_h)/2; 
		//如果高大于宽，以宽为主
		/*if ($width <= $height) {
			$hb =  round($w/$width, 6);
			$temp_h = $height*$hb;
			if ($width*$hb < $w) {
				$temp_w = $width*$hb;
			} else {
				$pre =  round($w/$width, 6);
				$temp_w = $w;
			}
			$temp_h = $h;
			$dst_x = ($width - $w)/2;
			$dst_y = ($height - $h)/2;
		}*/
		//$per = $w / $width;
		//$temp_w = intval ( $width * $per ); // 计算原图缩放后的宽度
		//$temp_h = intval ( $height * $per ); // 计算原图缩放后的高度
		
		while ($temp_w > 800) {
			$temp_w /= 2;
			$temp_h /= 2;
		}
		$temp_img = imagecreatetruecolor ( $temp_w, $temp_h ); // 创建画布
		$im = $this->create ( $src );
		$temp_w += $dst_x;
		$temp_h += $dst_y;
		imagecopyresampled ( $temp_img, $im, 0, 0, $dst_x, $dst_y, $temp_w, $temp_h, $width, $height );
		imagejpeg ( $temp_img, $savepath, 100 );
		imagedestroy ( $im );
		
		return "50";
	}
	
	/**
	 * 缩略图主函数
	 *
	 * @param string $src
	 *        	图片路径
	 * @param int $w
	 *        	缩略图宽度
	 * @param int $h
	 *        	缩略图高度
	 * @return mixed 返回缩略图路径
	 *         *
	 */
	function resize($src, $w, $h) {
		$temp = pathinfo ( $src );
		$name = $temp ["basename"]; // 文件名
		$dir = $temp ["dirname"]; // 文件所在的文件夹
		$extension = $temp ["extension"]; // 文件扩展名
		$savepath = "{$dir}/" . "s_" . "{$name}"; // 缩略图保存路径,新的文件名为*.thumb.jpg
		                                          
		// 获取图片的基本信息
		$info = GetImageSize ( $src );
		$width = $info [0]; // 获取图片宽度
		$height = $info [1]; // 获取图片高度
		$per1 = round ( $width / $height, 2 ); // 计算原图长宽比
		$per2 = round ( $w / $h, 2 ); // 计算缩略图长宽比
		                              
		// 计算缩放比例
		if ($per1 > $per2 || $per1 == $per2) {
			// 原图长宽比大于或者等于缩略图长宽比，则按照宽度优先
			$per = $w / $width;
		}
		if ($per1 < $per2) {
			// 原图长宽比小于缩略图长宽比，则按照高度优先
			$per = $h / $height;
		}
		$temp_w = intval ( $width * $per ); // 计算原图缩放后的宽度
		$temp_h = intval ( $height * $per ); // 计算原图缩放后的高度
		$temp_img = imagecreatetruecolor ( $temp_w, $temp_h ); // 创建画布
		$im = $this->create ( $src );
		imagecopyresampled ( $temp_img, $im, 0, 0, 0, 0, $temp_w, $temp_h, $width, $height );
		imagejpeg ( $temp_img, $savepath, 100 );
		imagedestroy ( $im );
		if ($per1 > $per2) {
			return $this->addBg ( $savepath, $w, $h, "w" );
			// 宽度优先，在缩放之后高度不足的情况下补上背景
		}
		if ($per1 == $per2) {
			return "50";
			// 等比缩放
		}
		if ($per1 < $per2) {
			return $this->addBg ( $savepath, $w, $h, "h" );
			// 高度优先，在缩放之后宽度不足的情况下补上背景
		}
	}
	
	/**
	 * 添加背景
	 *
	 * @param string $src
	 *        	图片路径
	 * @param int $w
	 *        	背景图像宽度
	 * @param int $h
	 *        	背景图像高度
	 * @param String $first
	 *        	决定图像最终位置的，w 宽度优先 h 高度优先 wh:等比
	 * @return 返回加上背景的图片 *
	 */
	function addBg($src, $w, $h, $fisrt = "w") {
		$bg = imagecreatetruecolor ( $w, $h );
		$white = imagecolorallocate ( $bg, 255, 255, 255 );
		imagefill ( $bg, 0, 0, $white ); // 填充背景
		                                 
		// 获取目标图片信息
		$info = GetImageSize ( $src );
		$width = $info [0]; // 目标图片宽度
		$height = $info [1]; // 目标图片高度
		$img = $this->create ( $src );
		if ($fisrt == "wh") {
			// 等比缩放
			return "50";
		} else {
			if ($fisrt == "w") {
				$x = 0;
				$y = ($h - $height) / 2; // 垂直居中
			}
			if ($fisrt == "h") {
				$x = ($w - $width) / 2; // 水平居中
				$y = 0;
			}
			imagecopymerge ( $bg, $img, $x, $y, 0, 0, $width, $height, 100 );
			imagejpeg ( $bg, $src, 100 );
			imagedestroy ( $bg );
			imagedestroy ( $img );
			return "50";
		}
	}
	
	/**
	 * 创建图片，返回资源类型
	 *
	 * @param string $src
	 *        	图片路径
	 * @return resource $im 返回资源类型
	 *         *
	 */
	function create($src) {
		$info = GetImageSize ( $src );
		switch ($info [2]) {
			case 1 :
				$im = imagecreatefromgif ( $src );
				break;
			case 2 :
				$im = imagecreatefromjpeg ( $src );
				break;
			case 3 :
				$im = imagecreatefrompng ( $src );
				break;
		}
		return $im;
	}
	
	/*
	 * 功能：PHP图片水印 (水印支持图片或文字) 参数： $groundImage 背景图片，即需要加水印的图片，暂只支持GIF,JPG,PNG格式； $waterPos水印位置，有10种状态，0为随机位置； 1为顶端居左，2为顶端居中， 3为顶端居右； 4为中部居左，5为中部居中，6为中部居右； 7为底端居左，8为底端居中，9为底端居右； $waterImage图片水印，即作为水印的图片，暂只支持GIF,JPG,PNG格式； $waterText文字水印，即把文字作为为水印，支持ASCII码，不支持中文； $textFont文字大小，值为1、2、3、4或5，默认为5； $textColor文字颜色，值为十六进制颜色值，默认为#FF0000(红色)； 注意：Support GD 2.0，Support FreeType、GIF Read、GIF Create、JPG 、PNG $waterImage 和 $waterText 最好不要同时使用，选其中之一即可，优先使用 $waterImage。 当$waterImage有效时，参数$waterString、$stringFont、$stringColor均不生效。 加水印后的图片的文件名和 $groundImage 一样。 作者：田洪强
	 */
	function imageWaterMark($groundImage, $waterPos = 0, $waterImage = "", $waterText = "", $textFont = 5, $textColor = "#FF0000") {
		$isWaterImage = FALSE;
		$formatMsg = "82";
		// 读取水印文件
		if (! empty ( $waterImage ) && file_exists ( $waterImage )) {
			
			$isWaterImage = TRUE;
			$water_info = getimagesize ( $waterImage );
			$water_w = $water_info [0]; // 取得水印图片的宽
			$water_h = $water_info [1]; // 取得水印图片的高
			switch ($water_info [2]) { // 取得水印图片的格式
				case 1 :
					$water_im = imagecreatefromgif ( $waterImage );
					break;
				case 2 :
					$water_im = imagecreatefromjpeg ( $waterImage );
					break;
				case 3 :
					$water_im = imagecreatefrompng ( $waterImage );
					break;
				default :
					die ( $formatMsg );
			}
		}
		
		// 读取背景图片
		if (! empty ( $groundImage ) && file_exists ( $groundImage )) {
			$ground_info = getimagesize ( $groundImage );
			$ground_w = $ground_info [0]; // 取得背景图片的宽
			$ground_h = $ground_info [1]; // 取得背景图片的高
			switch ($ground_info [2]) { // 取得背景图片的格式
				case 1 :
					$ground_im = imagecreatefromgif ( $groundImage );
					break;
				case 2 :
					$ground_im = imagecreatefromjpeg ( $groundImage );
					break;
				case 3 :
					$ground_im = imagecreatefrompng ( $groundImage );
					break;
				default :
					die ( $formatMsg );
			}
		} else {
			return "61";
		}
		
		// 水印位置
		
		if ($isWaterImage) { // 图片水印
			$w = $water_w;
			$h = $water_h;
		} else { // 文字水印
			$temp = imagettfbbox ( ceil ( $textFont * 5 ), 0, "", $waterText ); // 取得使用 TrueType 字体的文本的范围
			$w = $temp [2] - $temp [6];
			$h = $temp [3] - $temp [7];
			unset ( $temp );
		}
		
		if (($ground_w < $w) || ($ground_h < $h)) {
			return "62";
		}
		
		switch ($waterPos) {
			case 0 : // 随机
				$posX = rand ( 0, ($ground_w - $w) );
				$posY = rand ( 0, ($ground_h - $h) );
				break;
			
			case 1 : // 1为顶端居左
				$posX = 0;
				$posY = 0;
				break;
			
			case 2 : // 2为顶端居中
				$posX = ($ground_w - $w) / 2;
				$posY = 0;
				break;
			
			case 3 : // 3为顶端居右
				$posX = $ground_w - $w;
				$posY = 0;
				break;
			
			case 4 : // 4为中部居左
				$posX = 0;
				$posY = ($ground_h - $h) / 2;
				break;
			
			case 5 : // 5为中部居中
				$posX = ($ground_w - $w) / 2;
				$posY = ($ground_h - $h) / 2;
				break;
			
			case 6 : // 6为中部居右
				$posX = $ground_w - $w;
				$posY = ($ground_h - $h) / 2;
				break;
			
			case 7 : // 7为底端居左
				$posX = 0;
				$posY = $ground_h - $h;
				break;
			
			case 8 : // 8为底端居中
				$posX = ($ground_w - $w) / 2;
				$posY = $ground_h - $h;
				break;
			
			case 9 : // 9为底端居右
				$posX = $ground_w - $w - 0; // -10 是距离右侧10px 可以自己调节
				$posY = $ground_h - $h - 0; // -10 是距离底部10px 可以自己调节
				break;
			
			default : // 随机
				$posX = rand ( 0, ($ground_w - $w) );
				$posY = rand ( 0, ($ground_h - $h) );
				break;
		}
		
		// 设定图像的混色模式
		
		imagealphablending ( $ground_im, true );
		
		if ($isWaterImage) { // 图片水印
			imagecopy ( $ground_im, $water_im, $posX, $posY, 0, 0, $water_w, $water_h ); // 拷贝水印到目标文件
		} else { // 文字水印
			if (! empty ( $textColor ) && (strlen ( $textColor ) == 7)) {
				$R = hexdec ( substr ( $textColor, 1, 2 ) );
				$G = hexdec ( substr ( $textColor, 3, 2 ) );
				$B = hexdec ( substr ( $textColor, 5 ) );
			} else {
				return "63";
			}
			
			imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate ( $ground_im, $R, $G, $B ) );
		}
		
		// 生成水印后的图片
		
		@unlink ( $groundImage );
		
		switch ($ground_info [2]) { // 取得背景图片的格式
			case 1 :
				imagegif ( $ground_im, $groundImage );
				break;
			
			case 2 :
				imagejpeg ( $ground_im, $groundImage );
				break;
			
			case 3 :
				imagepng ( $ground_im, $groundImage );
				break;
			
			default :
				return "60";
		}
		
		// 释放内存
		if (isset ( $water_info ))
			unset ( $water_info );
		if (isset ( $water_im))
			imagedestroy ( $water_im );
		unset ( $ground_info );
		imagedestroy ( $ground_im );
		return "69";
	}
}

