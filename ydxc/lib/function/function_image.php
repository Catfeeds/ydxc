<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: function_image.php 2009-4-21 12:16:43 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//上传图片
function pic_save($FILE, $makethumb=1) {
	global $_TGLOBAL, $_TCONFIG, $_CTB;

	//允许上传类型
	$allowpictype = array('jpg','gif','png', 'swf');

	//检查
	$FILE['size'] = intval($FILE['size']);
	if(empty($FILE['size']) || empty($FILE['tmp_name']) || !empty($FILE['error'])) {
		return cplang('lack_of_access_to_upload_file_size');
	}

	//判断后缀
	$fileext = fileext($FILE['name']);
	if(!in_array($fileext, $allowpictype)) {
		return cplang('only_allows_upload_file_types');
	}

	//获取目录
	if(!$filepath = getfilepath($fileext, true)) {
		return cplang('unable_to_create_upload_directory_server');
	}

	//本地上传
	$new_name = $_CTB['attachdir'].'./'.$filepath;
	$tmp_name = $FILE['tmp_name'];
	if(@copy($tmp_name, $new_name)) {
		file_exists($tmp_name) && unlink($tmp_name);
	} elseif((function_exists('move_uploaded_file') && @move_uploaded_file($tmp_name, $new_name))) {
	} elseif(@rename($tmp_name, $new_name)) {
	} else {
		return cplang('mobile_picture_temporary_failure');
	}
	
	//检查是否图片
	if(function_exists('getimagesize') && !@getimagesize($new_name)) {
		file_exists($new_name) && unlink($new_name);
		return cplang('only_allows_upload_file_types');
	}

	//缩略图
	if ($makethumb) {
		include_once(S_ROOT.'./lib/function/function_image.php');
		$thumbpath = makethumb($new_name);
		$thumb = empty($thumbpath)?0:1;
	}

	//是否压缩
	//获取上传后图片大小
	if(@$newfilesize = filesize($new_name)) {
		$FILE['size'] = $newfilesize;
	}

	//水印
	if($_TCONFIG['allowwatermark']) {
		makewatermark($new_name);
	}

	//进行ftp上传
	if($_TCONFIG['allowftp']) {
		include_once(S_ROOT.'./lib/function/function_ftp.php');
		if(ftpupload($new_name, $filepath)) {
			$pic_remote = 1;
			$album_picflag = 2;
		} else {
			file_exists($new_name) && unlink($new_name);
			file_exists($new_name.'.thumb.jpg') && unlink($new_name.'.thumb.jpg');
			runlog('ftp', 'Ftp Upload '.$new_name.' failed.');
			return cplang('ftp_upload_file_size');
		}
	} else {
		$pic_remote = 0;
		$album_picflag = 1;
	}

	return array('new_name' => $new_name); //返回数组,则上传成功
}



//生成缩略图
function makethumb($srcfile) {
	global $_TGLOBAL;

	//判断文件是否存在
	if (!file_exists($srcfile)) {
		return '';
	}
	$dstfile = $srcfile.'.thumb.jpg';
	
	include_once(S_ROOT.'./data/data_setting.php');

	//缩略图大小
	$tow = intval($_TGLOBAL['setting']['thumbwidth']);
	$toh = intval($_TGLOBAL['setting']['thumbheight']);
	if($tow < 80) $tow = 120;
	if($toh < 60) $toh = 90;

	$make_max = 0;
	$maxtow = intval($_TGLOBAL['setting']['maxthumbwidth']);
	$maxtoh = intval($_TGLOBAL['setting']['maxthumbheight']);
	if($maxtow >= 300 && $maxtoh >= 300) {
		$make_max = 1;
	}
	
	//获取图片信息
	$im = '';
	if($data = getimagesize($srcfile)) {
		if($data[2] == 1) {
			$make_max = 0;//gif不处理
			if(function_exists("imagecreatefromgif")) {
				$im = imagecreatefromgif($srcfile);
			}
		} elseif($data[2] == 2) {
			if(function_exists("imagecreatefromjpeg")) {
				$im = imagecreatefromjpeg($srcfile);
			}
		} elseif($data[2] == 3) {
			if(function_exists("imagecreatefrompng")) {
				$im = imagecreatefrompng($srcfile);
			}
		}
	}
	if(!$im) return '';
	
	$srcw = imagesx($im);
	$srch = imagesy($im);
	
	$towh = $tow/$toh;
	$srcwh = $srcw/$srch;
	if($towh <= $srcwh){
		$ftow = $tow;
		$ftoh = $ftow*($srch/$srcw);
		
		$fmaxtow = $maxtow;
		$fmaxtoh = $fmaxtow*($srch/$srcw);
	} else {
		$ftoh = $toh;
		$ftow = $ftoh*($srcw/$srch);
		
		$fmaxtoh = $maxtoh;
		$fmaxtow = $fmaxtoh*($srcw/$srch);
	}
	if($srcw <= $maxtow && $srch <= $maxtoh) {
		$make_max = 0;//不处理
	}
	if($srcw > $tow || $srch > $toh) {
		if(function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$ni = imagecreatetruecolor($ftow, $ftoh)) {
			imagecopyresampled($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
			//大图片
			if($make_max && @$maxni = imagecreatetruecolor($fmaxtow, $fmaxtoh)) {
				imagecopyresampled($maxni, $im, 0, 0, 0, 0, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} elseif(function_exists("imagecreate") && function_exists("imagecopyresized") && @$ni = imagecreate($ftow, $ftoh)) {
			imagecopyresized($ni, $im, 0, 0, 0, 0, $ftow, $ftoh, $srcw, $srch);
			//大图片
			if($make_max && @$maxni = imagecreate($fmaxtow, $fmaxtoh)) {
				imagecopyresized($maxni, $im, 0, 0, 0, 0, $fmaxtow, $fmaxtoh, $srcw, $srch);
			}
		} else {
			return '';
		}
		if(function_exists('imagejpeg')) {
			imagejpeg($ni, $dstfile);
			//大图片
			if($make_max) {
				imagejpeg($maxni, $srcfile);
			}
		} elseif(function_exists('imagepng')) {
			imagepng($ni, $dstfile);
			//大图片
			if($make_max) {
				imagepng($maxni, $srcfile);
			}
		}
		imagedestroy($ni);
		if($make_max) {
			imagedestroy($maxni);
		}
	}
	imagedestroy($im);

	if(!file_exists($dstfile)) {
		return '';
	} else {
		return $dstfile;
	}
}

//图片水印
function makewatermark($srcfile) {
	global $_TGLOBAL;
	
	include_once(S_ROOT.'./data/data_setting.php');
	
	//水印图片
	$watermarkfile = empty($_TGLOBAL['setting']['watermarkfile'])?S_ROOT.'./image/watermark.png':$_TGLOBAL['setting']['watermarkfile'];
    if(!file_exists($watermarkfile) || !$water_info = getimagesize($watermarkfile)) {
    	return '';
    }
    $water_w = $water_info[0];
    $water_h = $water_info[1];
    $water_im = '';
    switch($water_info[2]) {
        case 1:@$water_im = imagecreatefromgif($watermarkfile);break;
        case 2:@$water_im = imagecreatefromjpeg($watermarkfile);break;
        case 3:@$water_im = imagecreatefrompng($watermarkfile);break;
        default:break;
    }
	if(empty($water_im)) {
		return '';
	}

    //原图
    if(!file_exists($srcfile) || !$src_info = getimagesize($srcfile)) {
    	return '';
    }
    $src_w = $src_info[0];
    $src_h = $src_info[1];
    $src_im = '';
    switch($src_info[2]) {
        case 1:
        	//判断是否为动画
        	$fp = fopen($srcfile, 'rb');
			$filecontent = fread($fp, filesize($srcfile));
			fclose($fp);
			if(strpos($filecontent, 'NETSCAPE2.0') === FALSE) {//动画图不加水印
        		@$src_im = imagecreatefromgif($srcfile);
			}
        	break;
        case 2:@$src_im = imagecreatefromjpeg($srcfile);break;
        case 3:@$src_im = imagecreatefrompng($srcfile);break;
        default:break;
    }
    if(empty($src_im)) {
    	return '';
    }
    
    //加水印的图片的长度或宽度比水印小150px
    if(($src_w < $water_w + 150) || ($src_h < $water_h + 150)) {
    	return '';
    }
	
    //位置
	switch($_TGLOBAL['setting']['watermarkpos']) {
		case 1://顶端居左
			$posx = 0;
			$posy = 0;
			break;
		case 2://顶端居右
			$posx = $src_w - $water_w;
			$posy = 0;
			break;
		case 3://底端居左
			$posx = 0;
			$posy = $src_h - $water_h;
			break;
		case 4://底端居右
			$posx = $src_w - $water_w;
			$posy = $src_h - $water_h;
			break;
		default://随机
			$posx = mt_rand(0, ($src_w - $water_w));
			$posy = mt_rand(0, ($src_h - $water_h));
			break;
	}

    //设定图像的混色模式
	@imagealphablending($src_im, true);
	//拷贝水印到目标文件
	@imagecopy($src_im, $water_im, $posx, $posy, 0, 0, $water_w, $water_h);
    switch($src_info[2]) {
        case 1:@imagegif($src_im, $srcfile);break;
        case 2:@imagejpeg($src_im, $srcfile);break;
        case 3:@imagepng($src_im, $srcfile);break;
        default:return '';
    }
	@imagedestroy($water_im);
	@imagedestroy($src_im);
}

//抓取远程图片
function upload_http_img($src_name) {
	global $_CTB;	

	//设置系统超长时间 
	set_time_limit(0);

	/*//允许上传类型
	$allowpictype = array('jpg','gif','png', 'swf');
	//判断后缀
	$fileext = fileext($src_name);
	if(!in_array($fileext, $allowpictype)) {
		return cplang('only_allows_upload_file_types');
	}*/
	$fileext = 'jpg';

	//获取目录
	if(!$filepath = getfilepath($fileext, true)) {
		return cplang('unable_to_create_upload_directory_server');
	}

	$new_name = $_CTB['attachdir'].''.$filepath;

	if(function_exists('curl_init')) {

		/******** 采用 curl　的get方式得到图片，处理防图片盗链的网址  *********/
		//$v = base64_decode($src_name);
		$v = $src_name;
		$ch = curl_init($src_name);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
		$output = curl_exec($ch);
		curl_close($ch);
	/*
		$fh = fopen($new_name, 'wb');
		fwrite($fh, $output);
		fclose($fh);

		ob_start(); 
		readfile($src_name); 
		$output = ob_get_contents(); 
		ob_end_clean();
		
		$output = @file_get_contents($src_name);
	*/
		swritefile($new_name, $output);
	} else {
		copy($src_name, $new_name);
	}

	return array('new_name' => $new_name);//返回图片的文件名
}


//上传附件
function pic_attach($FILE) {
	global $_TGLOBAL, $_TCONFIG, $_CTB;

	//允许上传类型
	$bannedtype = array('php','asp','aspx');

	//检查
	$FILE['size'] = intval($FILE['size']);
	if(empty($FILE['size']) || empty($FILE['tmp_name']) || !empty($FILE['error'])) {
		return cplang('lack_of_access_to_upload_file_size');
	}

	//判断后缀
	$fileext = fileext($FILE['name']);
	if(in_array($fileext, $bannedtype)) {
		return cplang("'php','asp','aspx'，此种文件不允许上传");
	}

	//获取目录
	if(!$filepath = getfilepath($fileext, true)) {
		return cplang('unable_to_create_upload_directory_server');
	}

	//本地上传
	$new_name = $_CTB['attachdir'].'./'.$filepath;
	$tmp_name = $FILE['tmp_name'];
	if(@copy($tmp_name, $new_name)) {
		file_exists($tmp_name) && unlink($tmp_name);
	} elseif((function_exists('move_uploaded_file') && @move_uploaded_file($tmp_name, $new_name))) {
	} elseif(@rename($tmp_name, $new_name)) {
	} else {
		return cplang('mobile_picture_temporary_failure');
	}
	
	//进行ftp上传
	if($_TCONFIG['allowftp']) {
		include_once(S_ROOT.'./lib/function/function_ftp.php');
		if(ftpupload($new_name, $filepath)) {
			$pic_remote = 1;
			$album_picflag = 2;
		} else {
			file_exists($new_name) && unlink($new_name);
			runlog('ftp', 'Ftp Upload '.$new_name.' failed.');
			return cplang('ftp_upload_file_size');
		}
	} else {
		$pic_remote = 0;
		$album_picflag = 1;
	}

	return array('new_name' => $new_name); //返回数组,则上传成功
}

//上传语音
function voice_save($FILE, $albumid=0, $title=0) {
	global $_TGLOBAL, $_TCONFIG, $_CTB;

	//允许上传类型
	$allowpictype = array('mp3','wav','avi', 'mid', 'amr');

	//检查
	$FILE['size'] = intval($FILE['size']);
	if(empty($FILE['size']) || empty($FILE['tmp_name']) || !empty($FILE['error'])) {
		return cplang('lack_of_access_to_upload_file_size');
	}

	//判断后缀
	$fileext = fileext($FILE['name']);
	if(!in_array($fileext, $allowpictype)) {
		return cplang('only_allows_upload_file_types');
	}

	//获取目录
	if(!$filepath = getfilepath($fileext, true)) {
		return cplang('unable_to_create_upload_directory_server');
	}

	//本地上传
	$new_name = $_CTB['attachdir'].'./'.$filepath;
	$tmp_name = $FILE['tmp_name'];
	if(@copy($tmp_name, $new_name)) {
		file_exists($tmp_name) && unlink($tmp_name);
	} elseif((function_exists('move_uploaded_file') && @move_uploaded_file($tmp_name, $new_name))) {
	} elseif(@rename($tmp_name, $new_name)) {
	} else {
		return cplang('mobile_picture_temporary_failure');
	}
	

	//进行ftp上传
	if($_TCONFIG['allowftp']) {
		include_once(S_ROOT.'./lib/function/function_ftp.php');
		if(ftpupload($new_name, $filepath)) {
			$pic_remote = 1;
			$album_picflag = 2;
		} else {
			file_exists($new_name) && unlink($new_name);
			file_exists($new_name.'.thumb.jpg') && unlink($new_name.'.thumb.jpg');
			runlog('ftp', 'Ftp Upload '.$new_name.' failed.');
			return cplang('ftp_upload_file_size');
		}
	} else {
		$pic_remote = 0;
		$album_picflag = 1;
	}

	return array('new_name' => $new_name); //返回数组,则上传成功
}
?>