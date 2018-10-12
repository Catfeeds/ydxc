<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: function_common.php 2009-4-15 23:32:55 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//SQL ADDSLASHES
function saddslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = saddslashes($val);
		}
	} else {
		$string = addslashes($string);
	}
	return $string;
}


//取消HTML代码
function shtmlspecialchars($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = shtmlspecialchars($val);
		}
	} else {
		$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1',
			str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string));
	}
	return $string;
}

//字符串解密加密
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;	// 随机密钥长度 取值 0-32;
				// 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
				// 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
				// 当此值为 0 时，则不产生随机密钥
	!defined('UC_KEY') && define('UC_KEY', '');
	$key = md5($key ? $key : UC_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

//清空cookie
function clearcookie() {
	global $_TGLOBAL;
	ssetcookie('auth', '', -86400 * 365);
	$_TGLOBAL['ctb_uid'] = 0;
	$_TGLOBAL['ctb_username'] = '';
	$_TGLOBAL['member'] = array();
}

//cookie设置
function ssetcookie($var, $value, $life=0) {
	global $_TGLOBAL, $_CTB, $_SERVER;
	setcookie($_CTB['cookiepre'].$var, $value, $life?($_TGLOBAL['timestamp']+$life):0, $_CTB['cookiepath'], $_CTB['cookiedomain'], $_SERVER['SERVER_PORT']==443?1:0);
}

//数据库连接
function dbconnect() {
	global $_TGLOBAL, $_CTB;
	include_once(S_ROOT.'./lib/class/class_mysql.php');

	if(empty($_TGLOBAL['db'])) {
		$_TGLOBAL['db'] = new db;
		$_TGLOBAL['db']->charset = $_CTB['dbcharset'];
		$_TGLOBAL['db']->connect($_CTB['dbhost'], $_CTB['dbuser'], $_CTB['dbpassword'], $_CTB['dbname'], $_CTB['pconnect']);
	}
}

function sgmdate($dateformat, $timestamp='', $format=0) {
	global $_TCONFIG, $_TGLOBAL;
	if(empty($timestamp)) {
		$timestamp = $_TGLOBAL['timestamp'];
	}
	$result = '';
	if($format) {
		$time = $_TGLOBAL['timestamp'] - $timestamp;
		if($time > 24*3600) {
			$result = gmdate($dateformat, $timestamp + $_TGLOBAL['setting']['timeoffset'] * 3600);
		} elseif ($time > 3600) {
			$result = intval($time/3600).lang('hour').lang('before');
		} elseif ($time > 60) {
			$result = intval($time/60).lang('minute').lang('before');
		} elseif ($time > 0) {
			$result = $time.lang('second').lang('before');
		} else {
			$result = lang('now');
		}
	} else {
		$result = gmdate($dateformat, $timestamp + $_TGLOBAL['setting']['timeoffset'] * 3600);
	}
	return $result;
}

//获取在线IP
function getonlineip($format=0) {
	global $_TGLOBAL;

	if(empty($_TGLOBAL['onlineip'])) {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$onlineip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$onlineip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$onlineip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$onlineip = $_SERVER['REMOTE_ADDR'];
		}
		preg_match("/[\d\.]{7,15}/", $onlineip, $onlineipmatches);
		@$_TGLOBAL['onlineip'] = $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
	}
	
	if($format) {
		$ips = explode('.', $_TGLOBAL['onlineip']);
		for($i=0;$i<3;$i++) {
			$ips[$i] = intval($ips[$i]);
		}
		return sprintf('%03d%03d%03d', $ips[0], $ips[1], $ips[2]);
	} else {
		return $_TGLOBAL['onlineip'];
	}

}

//判断当前用户登录状态
function checkauth() {
	global $_TGLOBAL, $_CTB, $_TCONFIG, $_TCOOKIE, $_SN;

	if(isset($_TCOOKIE['auth'])) {
		@list($password, $uid) = explode("\t", authcode($_TCOOKIE['auth'], 'DECODE'));
		$_TGLOBAL['ctb_uid'] = intval($uid);
		if($_TGLOBAL['ctb_uid']) {
			//删除过期的session
			$_TCONFIG['onlinehold'] = intval($_TCONFIG['onlinehold']);
			if($_TCONFIG['onlinehold'] < 300) $_TCONFIG['onlinehold'] = 300;
			
			//先删除session 在重新生成
			$_TGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE lastactive<'".($_TGLOBAL['timestamp']-$_TCONFIG['onlinehold'])."'");

			$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('session')." WHERE userid='$_TGLOBAL[ctb_uid]' AND password='$password'");
			if($member = $_TGLOBAL['db']->fetch_array($query)) {
				$_TGLOBAL['ctb_username'] = addslashes($member['username']);
				$_TGLOBAL['session'] = $member;

				//添加在线，每次记录用户的操作时间
				$ip = getonlineip(1);
				$setarr['lastactive'] = $_TGLOBAL['timestamp'];
				$setarr['ip'] = $ip;
				$setarr['userid'] = $_TGLOBAL['ctb_uid'];
				$setarr['username'] = $_TGLOBAL['ctb_username'];
				$setarr['password'] = $password;
				inserttable('session', $setarr, 0, true, 1);
			} 
		}
	}

	//!$_TGLOBAL['ctb_nickname'] && nickname_get(); //如果ctb_nickname为空，则重新取得
	if(empty($_TGLOBAL['ctb_uid'])) {
		clearcookie();
	} else {
		$_TGLOBAL['username'] = $member['username'];
	}
}

//获取到表名
function tname($name) {
	global $_CTB;
	return $_CTB['tablepre'].$name;
}



//对话框
function showmessage($msgkey, $url_forward='', $second=1, $values=array()) {
	global $_TGLOBAL, $_CTB, $_TCONFIG, $_TPL, $_SN;
	obclean();
	
	//去掉广告
	$_TGLOBAL['ad'] = array();

	include_once(S_ROOT.'./language/lang_showmessage.php');
	if(isset($_TGLOBAL['msglang'][$msgkey])) {
		$message = lang_replace($_TGLOBAL['msglang'][$msgkey], $values);
	} else {
		$message = $msgkey;
	}
	
	if($url_forward) {
		$message = "<a href=\"$url_forward\">$message</a><script>setTimeout(\"window.location.href ='$url_forward';\", ".($second*1000).");</script>";
	}
	
	echo template('showmessage', get_defined_vars());
	exit();
}



//判断提交是否正确
function submitcheck($var) {
	if(!empty($_POST[$var]) && $_SERVER['REQUEST_METHOD'] == 'POST') {
		if((empty($_SERVER['HTTP_REFERER']) || preg_replace("/https?:\/\/([^\:\/]+).*/i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("/([^\:]+).*/", "\\1", $_SERVER['HTTP_HOST'])) && $_POST['formhash'] == formhash()) {
			return true;
		} else {
			showmessage('submit_invalid');
		}
	} else {
		return false;
	}
}

//添加数据
function inserttable($tablename, $insertsqlarr, $returnid=0, $replace = false, $silent=0) {
	global $_TGLOBAL;
	$insertkeysql = $insertvaluesql = $comma = '';
	foreach ($insertsqlarr as $insert_key => $insert_value) {
		$insertkeysql .= $comma.'`'.$insert_key.'`';
		$insertvaluesql .= $comma.'\''.$insert_value.'\'';
		$comma = ', ';
	}
	$method = $replace?'REPLACE':'INSERT';
	$_TGLOBAL['db']->query($method.' INTO '.tname($tablename).' ('.$insertkeysql.') VALUES ('.$insertvaluesql.')', $silent?'SILENT':'');
	if($returnid && !$replace) {
		return $_TGLOBAL['db']->insert_id();
	}
}

//更新数据
function updatetable($tablename, $setsqlarr, $wheresqlarr, $silent=0) {
	global $_TGLOBAL;
	$setsql = $comma = '';
	foreach ($setsqlarr as $set_key => $set_value) {
		$setsql .= $comma.'`'.$set_key.'`'.'=\''.$set_value.'\'';
		$comma = ', ';
	}
	$where = $comma = '';
	if(empty($wheresqlarr)) {
		$where = '1';
	} elseif(is_array($wheresqlarr)) {
		foreach ($wheresqlarr as $key => $value) {
			$where .= $comma.'`'.$key.'`'.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	} else {
		$where = $wheresqlarr;
	}
	$_TGLOBAL['db']->query('UPDATE '.tname($tablename).' SET '.$setsql.' WHERE '.$where, $silent?'SILENT':'');
}

//写运行日志
function runlog($file, $log, $halt=0) {
	global $_TGLOBAL, $_SERVER;
	
	$nowurl = $_SERVER['REQUEST_URI']?$_SERVER['REQUEST_URI']:($_SERVER['PHP_SELF']?$_SERVER['PHP_SELF']:$_SERVER['SCRIPT_NAME']);
	$log = sgmdate('Y-m-d H:i:s', $_TGLOBAL['timestamp'])."\t".getonlineip()."\t$_TGLOBAL[ctb_uid]\t{$nowurl}\t".str_replace(array("\r", "\n"), array(' ', ' '), trim($log))."\n";
	$yearmonth = sgmdate('Ym', $_TGLOBAL['timestamp']);
	
	$logdir = S_ROOT.'./data/log/';
	if(!is_dir($logdir)){
		 mkdir($logdir, 0777);
	}
	$logfile = S_ROOT.$logdir.$yearmonth.'_'.$file.'.php';
	if(@filesize($logfile) > 2048000) {
		$dir = opendir($logdir);
		$length = strlen($file);
		$maxid = $id = 0;
		while($entry = readdir($dir)) {
			if(strexists($entry, $yearmonth.'_'.$file)) {
				$id = intval(substr($entry, $length + 8, -4));
				$id > $maxid && $maxid = $id;
			}
		}
		closedir($dir);
		$logfilebak = $logdir.$yearmonth.'_'.$file.'_'.($maxid + 1).'.php';
		@rename($logfile, $logfilebak);
	}
	if($fp = @fopen($logfile, 'a')) {
		@flock($fp, 2);
		fwrite($fp, "<?PHP exit;?>\t".str_replace(array('<?', '?>', "\r", "\n"), '', $log)."\n");
		fclose($fp);
	}
	if($halt) exit();
}

//字符串时间化
function sstrtotime($string) {
	global $_TGLOBAL, $_TCONFIG;
	
	$time = '';
	if($string) {
		$time = strtotime($string);
		if(sgmdate('H:i') != date('H:i')) {
			$time = $time - $_TGLOBAL['setting']['timeoffset'] * 3600;
		}
	}
	return $time;
}

//分页
function multi($num, $perpage, $curpage, $mpurl) {
	global $_TCONFIG;
	
	$_TCONFIG['maxpage'] = 9999;
	$page = 10;
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&' : '?';
	$realpages = 1;

	if(isset($_TCONFIG['maxpage'])) {   //$num > $perpage
		$offset = 2;
		$realpages = @ceil($num / $perpage);
		$pages = $_TCONFIG['maxpage'] && $_TCONFIG['maxpage'] < $realpages ? $_TCONFIG['maxpage'] : $realpages;
		
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}

		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first">1 ...</a>' : '').($curpage > 1 ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev">&lsaquo;&lsaquo;</a>' : '');

		for($i = $from; $i <= $to; $i++) {
			//$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
			$multipage .= $i == $curpage ? '<a href="'.$mpurl.'page='.$curpage.'"  target="_self" class="on">'.$i.'</a>' :
				'<a href="'.$mpurl.'page='.$i.'">'.$i.'</a>';
		}
		$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next">&rsaquo;&rsaquo;</a>' : '').
			($to < $pages ? '<a href="'.$mpurl.'page='.$pages.'" class="last">... '.$realpages.'</a>' : '');
		$multipage = $multipage ? ('共&nbsp;'.$num.'&nbsp;条记录&nbsp;'.$multipage):'';
	}
	
	$maxpage = $realpages;
	return $multipage;
}



//ob
function obclean() {
	global $_CTB;

	ob_end_clean();
	if ($_CTB['gzipcompress'] && function_exists('ob_gzhandler')) {
		ob_start('ob_gzhandler');
	} else {
		ob_start();
	}
}
//模板调用
function template($name, $values=array()) {
	global $_TCONFIG, $_TGLOBAL;

	if(strexists($name,'/') || strexists($name,'.html')) {
		$tpl = $name;
	} else {
		$tpl = "$name.html";
	}

	include_once(S_ROOT.'./lib/smarty/Smarty.class.php');
	if(empty($_TGLOBAL['tpl'])) {
		$_TGLOBAL['tpl'] = new Smarty();
		$_TGLOBAL['tpl']->template_dir		= S_ROOT."template/$_TCONFIG[template]/";
		$_TGLOBAL['tpl']->compile_dir		= S_ROOT."./data/tpl_cache/$_TCONFIG[template]";
		/*$_TGLOBAL['tpl']->confit_dir		= S_ROOT.'./lib/smarty/config/';*/
		$_TGLOBAL['tpl']->cache_dir			= S_ROOT.'./data/cache/';
		$_TGLOBAL['tpl']->caching			= 0;	//开户缓存
		$_TGLOBAL['tpl']->cache_lifetime    = 7200; //缓存时间 2小时 7200
		$_TGLOBAL['tpl']->left_delimiter    = '{/';
		$_TGLOBAL['tpl']->right_delimiter   = '/}';
	}

	$_TGLOBAL['tpl']->assign($values);
	$objfile = $_TGLOBAL['tpl']->fetch($tpl);

	$objfile = str_replace('"images/', "\"template/$_TCONFIG[template]/images/", $objfile); //替换内容中的图片路径为当前模板下的
	$objfile = str_replace('href="style/', "href=\"template/$_TCONFIG[template]/style/", $objfile); //替换css文件为当前模板下的 
	$objfile = str_replace('href="css/', "href=\"template/$_TCONFIG[template]/css/", $objfile); //替换css文件为当前模板下的 
	$objfile = str_replace('href="banner/', "href=\"template/$_TCONFIG[template]/banner/", $objfile); //替换css文件为当前模板下的 
	$objfile = str_replace('src="banner/', "src=\"template/$_TCONFIG[template]/banner/", $objfile); //替换css文件为当前模板下的 
	$objfile = str_replace('src="js/', "src=\"template/$_TCONFIG[template]/js/", $objfile); //替换css文件为当前模板下的 
	//$objfile = str_replace('src="js/', "src=\"js/", $objfile); //替换css文件为当前模板下的 
	

	//替换显示的内容中的路径
	//$objfile = str_replace('../upload/', './upload/', $objfile);
	//$objfile = str_replace('../../../', '', $objfile);
	return $objfile;
}



//获取数目
function getcount($tablename, $wherearr='', $get='COUNT(*)') {
	global $_TGLOBAL;

	if(empty($wherearr)) {
		$wheresql = '1';
	} else {
		if (is_array($wherearr)) { //当为数组时
			$wheresql = $mod = '';
			foreach ($wherearr as $key => $value) {
				$wheresql .= $mod."`$key`='$value'";
				$mod = ' AND ';
			}
		} else {
			$wheresql = $wherearr;
		}
	}
	return $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT $get FROM ".tname($tablename)." WHERE $wheresql LIMIT 1"), 0);
}

//连接字符
function simplode($ids) {
	return "'".implode("','", $ids)."'";
}

//显示进程处理时间
function debuginfo() {
	global $_TGLOBAL, $_CTB, $_TCONFIG;

	if(empty($_TCONFIG['debuginfo'])) {
		$info = '';
	} else {
		$mtime = explode(' ', microtime());
		$totaltime = number_format(($mtime[1] + $mtime[0] - $_TGLOBAL['ctb_starttime']), 6);
		$info = 'Processed in '.$totaltime.' second(s), '.$_TGLOBAL['db']->querynum.' queries'.($_CTB['gzipcompress'] ? ', Gzip enabled' : NULL);
	}
	return $info;
}


//格式化大小函数
function formatsize($size) {
	$prec=3;
	$size = round(abs($size));
	$units = array(0=>" B ", 1=>" KB", 2=>" MB", 3=>" GB", 4=>" TB");
	if ($size==0) return str_repeat(" ", $prec)."0$units[0]";
	$unit = min(4, floor(log($size)/log(2)/10));
	$size = $size * pow(2, -10*$unit);
	$digi = $prec - 1 - floor(log($size)/log(10));
	$size = round($size * pow(10, $digi)) * pow(10, -$digi);
	return $size.$units[$unit];
}

//获取文件内容
function sreadfile($filename) {
	$content = '';
	if(function_exists('file_get_contents')) {
		@$content = file_get_contents($filename);
	} else {
		if(@$fp = fopen($filename, 'r')) {
			@$content = fread($fp, filesize($filename));
			@fclose($fp);
		}
	}
	return $content;
}

//写入文件
function swritefile($filename, $writetext, $openmod='w') {
	if(@$fp = fopen($filename, $openmod)) {
		flock($fp, 2);
		fwrite($fp, $writetext);
		fclose($fp);
		return true;
	} else {
		runlog('error', "File: $filename write error.");
		return false;
	}
}

//产生随机字符
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand((double)microtime() * 1000000) : mt_srand();
	
	$seed = base_convert(md5(print_r($_SERVER, 1).microtime()), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'01234056789') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed[mt_rand(0, $max)];
	}
	return $hash;
}

//判断字符串是否存在
function strexists($haystack, $needle) {
	return !(strpos($haystack, $needle) === FALSE);
}

//获取数据
function data_get($var, $isarray=0) {
	global $_TGLOBAL;

	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('data')." WHERE var='$var' LIMIT 1");
	if($value = $_TGLOBAL['db']->fetch_array($query)) {
		return $isarray?$value:$value['datavalue'];
	} else {
		return '';
	}
}

//更新数据
function data_set($var, $datavalue, $clean=0) {
	global $_TGLOBAL;
	
	if($clean) {
		$_TGLOBAL['db']->query("DELETE FROM ".tname('data')." WHERE var='$var'");
	} else {
		if(is_array($datavalue)) $datavalue = serialize(sstripslashes($datavalue));
		$_TGLOBAL['db']->query("REPLACE INTO ".tname('data')." (var, datavalue) VALUES ('$var', '".addslashes($datavalue)."')");
	}
}

//检查站点是否关闭
function checkclose() {
	global $_TGLOBAL, $_TCONFIG;

	//站点关闭
	if(isset($_TCONFIG['close'])) {
		if(empty($_TCONFIG['closereason'])) {
			showmessage('site_temporarily_closed');
		} else {
			showmessage($_TCONFIG['closereason']);
		}
	}

	//IP访问检查
	if((!ipaccess($_TCONFIG['ipaccess']) || ipbanned($_TCONFIG['ipbanned']))) {
		showmessage('ip_is_not_allowed_to_visit');
	}
}

//站点链接
function getsiteurl() {
	global $_CTB;

	if(empty($_CTB['siteurl'])) {
		$uri = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
		return 'http://'.$_SERVER['HTTP_HOST'].substr($uri, 0, strrpos($uri, '/')+1);
	} else {
		return $_CTB['siteurl'];
	}
}

//获取文件名后缀
function fileext($filename) {
	return strtolower(trim(substr(strrchr($filename, '.'), 1)));
}

//去掉slassh
function sstripslashes($string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = sstripslashes($val);
		}
	} else {
		$string = stripslashes($string);
	}
	return $string;
}

//编码转换
function siconv($str, $out_charset, $in_charset='') {
	global $_CTB;
	
	$in_charset = empty($in_charset)?strtoupper($_CTB['charset']):strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);
	if($in_charset != $out_charset) {
		if (function_exists('iconv') && (@$outstr = iconv("$in_charset//IGNORE", "$out_charset//IGNORE", $str))) {
			return $outstr;
		} elseif (function_exists('mb_convert_encoding') && (@$outstr = mb_convert_encoding($str, $out_charset, $in_charset))) {
			return $outstr;
		}
	}
	return $str;//转换失败
}

//用户操作时间间隔检查
function interval_check($type) {
	global $_TGLOBAL, $space;

	$intervalname = $type.'interval';
	$lastname = 'last'.$type;

	$waittime = 0;
	if($interval = checkperm($intervalname)) {
		$lasttime = isset($space[$lastname])?$space[$lastname]:getcount('space', array('uid'=>$_TGLOBAL['ctb_uid']), $lastname);
		$waittime = $interval - ($_TGLOBAL['timestamp'] - $lasttime);
	}
	return $waittime;
}

//处理分页
function smulti($num, $perpage, $curpage, $mpurl, $ajaxdiv='') {
	global $_TCONFIG;
	$page = 5;
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&' : '?';
	$realpages = 1;
	if($num > $perpage) {
		$offset = 2;
		$realpages = @ceil($num / $perpage);
		$pages = $_TCONFIG['maxpage'] && $_TCONFIG['maxpage'] < $realpages ? $_TCONFIG['maxpage'] : $realpages;
		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:;" onclick="commentlist(1);" class="first">1 ...</a>' : '').
			($curpage > 1 ? '<a href="javascript:;" onclick="commentlist('.($curpage - 1).');" class="prev">&lsaquo;&lsaquo;</a>' : '');
		for($i = $from; $i <= $to; $i++) {
			//$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
			$multipage .= $i == $curpage ? '<a href="javascript:;" onclick="commentlist('.$curpage.');"  target="_self" class="on">'.$i.'</a>' :
				'<a href="javascript:;" onclick="commentlist('.$i.');">'.$i.'</a>';
		}
		$multipage .= ($curpage < $pages ? '<a href="javascript:;" onclick="commentlist('.($curpage + 1).');" class="next">&rsaquo;&rsaquo;</a>' : '').
			($to < $pages ? '<a href="javascript:;" onclick="commentlist('.$pages.');" class="last">... '.$realpages.'</a>' : '');
		$multipage = $multipage ? ('<em>共有&nbsp;'.$num.'&nbsp;个</em>'.$multipage):'';
	}
	$maxpage = $realpages;
	return $multipage;
}

//ip访问允许
function ipaccess($ipaccess) {
	return empty($ipaccess)?true:preg_match("/^(".str_replace(array("\r\n", ' '), array('|', ''), preg_quote($ipaccess, '/')).")/", getonlineip());
}



//ip访问禁止
function ipbanned($ipbanned) {
	return empty($ipbanned)?false:preg_match("/^(".str_replace(array("\r\n", ' '), array('|', ''), preg_quote($ipbanned, '/')).")/", getonlineip());

}

//检查start 最多显示多少页
function ckstart($start, $perpage) {
	global $_TCONFIG;
	if(isset($_TCONFIG['maxpage'])){
		$maxstart = $perpage*intval($_TCONFIG['maxpage']);
		if($start < 0 || ($maxstart > 0 && $start >= $maxstart)) {
			showmessage('length_is_not_within_the_scope_of');
		}		
	}

}

//检查是否登录
function checklogin() {
	global $_TGLOBAL, $_TCONFIG;
	
	if(empty($_TGLOBAL['ctb_uid'])) {
		ssetcookie('_refer', rawurlencode($_SERVER['REQUEST_URI']));
		showmessage('to_login', 'do.php?ac='.$_TCONFIG['login_action']);
	}
}

//获得前台语言
function lang($key, $vars=array()) {
	global $_TGLOBAL;
	include_once(S_ROOT.'./language/lang_source.php');
	
	if(isset($_TGLOBAL['sourcelang'][$key])) {
		$result = lang_replace($_TGLOBAL['sourcelang'][$key], $vars);
	} else {
		$result = $key;
	}
	return $result;
}

//获得后台语言
function cplang($key, $vars=array()) {
	global $_TGLOBAL;
	include_once(S_ROOT.'./language/lang_cp.php');
	
	if(isset($_TGLOBAL['cplang'][$key])) {
		$result = lang_replace($_TGLOBAL['cplang'][$key], $vars);
	} else {
		$result = $key;
	}
	return $result;
}


//语言替换
function lang_replace($text, $vars) {
	if($vars) {
		foreach ($vars as $k => $v) {
			$rk = $k + 1;
			$text = str_replace('\\'.$rk, $v, $text);
		}
	}
	return $text;
}

//截取链接
function sub_url($url, $length) {
	if(strlen($url) > $length) {
		$url = str_replace(array('%3A', '%2F'), array(':', '/'), rawurlencode($url));
		$url = substr($url, 0, intval($length * 0.5)).' ... '.substr($url, - intval($length * 0.3));
	}
	return $url;
}

//取数组中的随机个
function sarray_rand($arr, $num) {
	$r_values = array();
	if($arr && count($arr) > $num) {
		if($num > 1) {
			$r_keys = array_rand($arr, $num);
			foreach ($r_keys as $key) {
				$r_values[$key] = $arr[$key];
			}
		} else {
			$r_key = array_rand($arr, 1);
			$r_values[$r_key] = $arr[$r_key];
		}
	} else {
		$r_values = $arr;
	}
	return $r_values;
}

//产生form防伪码
function formhash() {
	global $_TGLOBAL, $_TCONFIG;
	
	if(empty($_TGLOBAL['formhash'])) {
		$hashadd = defined('IN_ADMINCP') ? 'Only For copytaobao AdminCP' : '';
		$_TGLOBAL['formhash'] = substr(md5(substr($_TGLOBAL['timestamp'], 0, -7).'|'.$_TGLOBAL['ctb_uid'].'|'.md5($_TCONFIG['sitekey']).'|'.$hashadd), 8, 8);
	}
	return $_TGLOBAL['formhash'];
}

//检查邮箱是否有效
function isemail($email) {
	return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
}

//获取目录
function sreaddir($dir, $extarr=array()) {
	$dirs = array();
	if($dh = opendir($dir)) {
		while (($file = readdir($dh)) !== false) {
			if(!empty($extarr) && is_array($extarr)) {
				if(in_array(strtolower(fileext($file)), $extarr)) {
					$dirs[] = $file;
				}
			} else if($file != '.' && $file != '..') {
				$dirs[] = $file;
			}
		}
		closedir($dh);
	}
	return $dirs;
}

//添加session
function insertsession($setarr) {
	global $_TGLOBAL, $_TCONFIG;
	$_TCONFIG['onlinehold'] = intval($_TCONFIG['onlinehold']);
	if($_TCONFIG['onlinehold'] < 300) $_TCONFIG['onlinehold'] = 300;
	$_TGLOBAL['db']->query("DELETE FROM ".tname('session')." WHERE userid='$setarr[userid]' OR lastactive<'".($_TGLOBAL['timestamp']-$_TCONFIG['onlinehold'])."'");
	//添加在线
	$ip = getonlineip(1);
	$setarr['lastactive'] = $_TGLOBAL['timestamp'];
	$setarr['ip'] = $ip;
	inserttable('session', $setarr, 0, true, 1);
}

//获取上传路径
function getfilepath($fileext, $mkdir=false) {
	global $_TGLOBAL, $_CTB;
	$filepath = "{$_TGLOBAL['ctb_uid']}_{$_TGLOBAL['timestamp']}".random(4).".$fileext";
	$name1 = gmdate('Ym');
	$name2 = gmdate('j');
	if($mkdir) {
		$newfilename = $_CTB['attachdir'].'./'.$name1;
		if(!is_dir($newfilename)) {
			if(!@mkdir($newfilename)) {
				runlog('error', "DIR: $newfilename can not make");
				return $filepath;
			}
		}
		$newfilename .= '/'.$name2;
		if(!is_dir($newfilename)) {
			if(!@mkdir($newfilename)) {
				runlog('error', "DIR: $newfilename can not make");
				return $name1.'/'.$filepath;
			}
		}
	}
	return $name1.'/'.$name2.'/'.$filepath;
}

//得到类别的多级名称
function getclasscotename($tclass, $class_id) {
	global $_TGLOBAL;
	
	$len = strlen($class_id) ;
	$cid = substr($class_id, 0 , $len);
	if (isset($_TGLOBAL[$tclass][$cid])) {
		if ($len > 0 ){
			$return = getclasscotename($tclass, substr($class_id, 0, $len - 3)) . $_TGLOBAL[$tclass][$cid]['name'] . "->";
		}
	}
	return @$return;
}


//得到参数，但不得到page参数，因为page参数每次会变化
//调用方式 get_current_url()
function get_current_url($except = array('page')) {
    if($_SERVER['QUERY_STRING'] == '') {
        return $_SERVER['PHP_SELF'];
    } else {
        if(!$except) $except = array();
        // 合并get和post参数，去掉“$except”中排除的变量
        $query  = '';
		$query_param = array_merge($_GET, $_POST);
        foreach($query_param as $k => $v) {
			/*if (eregi('搜索|查询|font|img', $v) || eregi('dowhat|type_mode|new', $k)) { //搜索按钮不会传递
				continue;
			}*/
			$exist = false;
            foreach($except as $vv) {
                if($k==$vv) {
                    $exist = true;
                    break;
                }
            }
            if(!$exist) {
				if (trim($v) != '') { //当值为不空时，作为传递
					$v = rawurlencode($v); //汉字编码
					$query .= ($query == '')?"$k={$v}":"&$k={$v}";
				}
            }
        }
    }
    return $_SERVER['PHP_SELF'] . '?' . $query;
}

//得到图片的缩略图，如果缩略图不存在，则返回原图
function getthumbimg($file, $path='../') {
	if ($file) {
		$path && $file = str_replace($path, '', $file);
		$thumb        = $file.'.thumb.'.fileext($file);
		file_exists(S_ROOT . $thumb) && $file = $thumb;
	} else {
		$file = 'image/no_pic.gif';
	}
	return $file;
}

//检查评论是否有屏敝的关键字
function checkbadwords($content) {
	global $_TCONFIG;
	if (!$_TCONFIG['prohibition']) return ;
	$ary = @split(",", $_TCONFIG['prohibition']);
	//foreach($ary AS $val) {
		$content = str_replace($ary, '***', $content);
	//}
	return $content;
}

//替换数组中的值为另外的
function arrary_replace($search, $replace, $string) {
	if(is_array($string)) {
		foreach($string as $key => $val) {
			$string[$key] = arrary_replace($search, $replace, $val);
		}
	} else {
		$string = str_replace($search, $replace, $string);
	}
	return $string;
}

//显示剩余时间
function lefttime($spectime) {
	global $_TGLOBAL;
	 $gmt = date('O')/100;       //GMT时区
	 $nowtime = $_TGLOBAL['timestamp'];
	 $difftime = $nowtime - $spectime;	// - $gmt*3600 处理时区
	 if ($difftime > 0) {                       //时间是将来时
	  $temp     = getdate($difftime);
	  $mysecond = $temp["seconds"];
	  $myminute = $temp["minutes"];
	  $myhour   = $temp["hours"] - 8; 
	  $myday    = $temp["yday"];
	  $myyear   = $temp["year"] - 1970;
	if ($myhour < 0) {
		$myday  = $myday - 1;
		$myhour = 60 + $myhour;
	}
	if ($myminute) $return = $myminute."分前";
	if ($myhour>0) $return = $myhour."小时前";
	if ($myday>0)  $return = $myday."天前";
	if ($myyear>0) $return = $myyear."年";
	 } else {
		$return .= "己经结束";
	 }
	return $return;
}

//* 功能：返回数组中选中的元素
function GetCheckElement($Ary, $val, $ele_name='') {
	$resutn = '';
	while(list($Line,$Value)=each($Ary)) {
		if ($ele_name) $Value = $Value[$ele_name];
		if ($val) {
			$aryzoneid = @split(',', $val);
			$return .= in_array($Line, $aryzoneid) ? ($Value. ' ') : '';
		}
	}
	return $return ? $return : $val;
}

//计算两日期的相差天数
function leftdays($startdate, $enddate) {
	$startdate = strtotime($startdate);
	$enddate   = strtotime($enddate);
	$days = round(($enddate-$startdate)/3600/24) ;
	return $days;
}

//以下两个文件为admin/other_ghost.php文件使用
//从链接的详细页中取出图片
function getimgoflink($content) {
	preg_match_all('/<[\s]*img.*?src=[\'|"|\s]*(.+?|\ )[\'|"|\s|>]/is', $content, $matches);
	for($j=0; $j < count($matches[1]); $j++) {
		$aryimg[] = $matches[1][$j];		
	}
	return $aryimg; //$matches[1][$j][0] //返回第一个匹配的图
}

//递归列出目录下所有文件
function listdir($start_dir=".") { 
	$files = array(); 
	if (is_dir($start_dir)) { 
		$fh = opendir($start_dir); 
		while (($file = readdir($fh)) !== false) { 
			if (strcmp($file, '.')==0 || strcmp($file, '..')==0) continue; 
			$filepath = $start_dir . '/' . $file; 
			if ( is_dir($filepath) ) 
				$files = array_merge($files, listdir($filepath)); 
			else 
				array_push($files, $filepath); 
		} 
		closedir($fh); 
	} else { 
	$files = false; 
	} 
	return $files; 
}

//得到新闻类别的二级子类别
function getclasscotesub($class_id='', $tclass='news_class') {
	global $_TGLOBAL;
//	if (!$class_id) return ;
	$len = strlen($class_id);
	$class_id = substr($class_id, 0, $len);
	$return = array();
	foreach($_TGLOBAL[$tclass] AS $key => $value) {
		if (strlen($key) == $len+3 && substr($key, 0, $len) == $class_id) {
			$return[] = array(
						'type'	   => $value['type'],
						'name'     => $value['name'],
						'key'	   => $key,
						'url'	   => $value['jumpto'],
						'sub_button'     => getclasscotesub($key, $tclass),
						);
		var_dump($return);
		}
	}
	
	//ksort($return);
	return $return;
}


//得到多级下拉框 论坛类别
function getclassselect($tclass='news_class', $class_id='', $event='', $selclass='') {
	global $_TGLOBAL;
	if (!$class_id) { //当第一次循环时，排序数组
		$return = "<select name=\"class_id\" id=\"class_id\" $event>\n";
		$return .= "<option value=\"\" selected=\"selected\">请选择类别</option>\n";
	}
	foreach(is_array($_TGLOBAL[$tclass]) ? $_TGLOBAL[$tclass] : array() AS $key => $value) {
		if (strlen($key) != strlen($class_id)+3) continue; //当不为当前长度加3时，进行下一个循环
		if (substr($key, 0, strlen($class_id)) == $class_id) { //判断当前的编码前几个是不是当前循环的
			$exits_sub = getclassselect($tclass, $key, $event, $selclass);;
			if ($exits_sub) {
				//$return .= "<option style=\"BACKGROUND-COLOR:#EEEEEE;\" value=\"\"";
				$pre .= strlen($class_id) ? '├' : '';
				for($i=0; $i < strlen($class_id) / 3; $i++) {
					$pre .= '─';
				}
				//$return .= "<optgroup label=\"".$pre.$value['name']."\"></optgroup>";
				$return .= "<option value=\"$key\"";
				$key == $selclass && $return .= ' selected="selected"';
				$return .= ">";
				$return .= $pre.$value['name']."</option>\n";
			} else {
				$return .= "<option value=\"$key\"";
				$key == $selclass && $return .= ' selected="selected"';
				$return .= ">";
				$return .= strlen($class_id) ? '├' : '';
				for($i=0; $i < strlen($class_id) / 3; $i++) {
					$return .= '─';
				}
				$return .= $value['name']."</option>\n";
			}
			$return .= $exits_sub;
		}
	}
	if (!$class_id) { //当第一次循环时，
		$return .= "</select>\n";
	}
	return $return;
}

 
/**************************************************************
 *
 *	将数组转换为JSON字符串（兼容中文）
 *	@param	array	$array		要转换的数组
 *	@return string		转换得到的json字符串
 *	@access public
 *
 *************************************************************/
function JSON($array) {
	//arrayRecursive($array, 'urlencode', true);
	array_walk_recursive($array, 'urlencode'); //, true
	$json = json_encode($array);
	return urldecode($json);
}

//从链接的详细页中取出图片
function getimg4content($content) {
	preg_match_all('/<[\s]*img.*?src=[\'|"|\s]*(.+?|\ )[\'|"|\s|>]/is', $content, $matches);
	for($j=0; $j < count($matches[1]); $j++) {
		$aryimg[] = $matches[1][$j];		
	}
	return $aryimg; //$matches[1][$j][0] //返回第一个匹配的图
}


//导出excel文件
function makeexcel($filename, $title, $data) {
	global $_TGLOBAL;

	if (!is_array($title) || !is_array($data)) return;

	require_once(S_ROOT . 'lib/PHPExcel/PHPExcel.php');
	$objPHPExcel = new PHPExcel();
	$objPHPExcel->getProperties()->setCreator("Jerry")
	->setLastModifiedBy("Jerry")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("www.51shop.org");
	$objActSheet = $objPHPExcel->setActiveSheetIndex(0);

	//设置默认属性
	$objPHPExcel->getDefaultStyle()->getFont()->setName( 'Arial');
	$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);

	//生态表头、设置表头对齐
	$objPHPExcel->getActiveSheet()->setCellValue('A1', '序号');
	$objActSheet->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	$cellname = array();
	$key = 0;
	foreach($title AS $val) {
		//生成单元格，从大写B开始
		$cell = chr(66+$key);
		$cellname[$key] = $cell;

		$width = strlen($val)+5;
		//$objActSheet->getColumnDimension($cell)->setAutoSize(true);
		$objActSheet->getColumnDimension($cell)->setWidth($width);
		//$objActSheet->getColumnDimension('B')->setAutoSize(true);  
		//$objActSheet->getColumnDimension('D')->setWidth(12);  
		$objPHPExcel->getActiveSheet()->setCellValue($cell.'1', $val);
		$objActSheet->getStyle($cell.'1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$key++;
	}

	//导出数据
	$i = 2;
	foreach($data AS $key => $value) {		
		$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $key+1);
		$objActSheet->getStyle('A'.$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		//导出数组里的每个元素
		$k = 0;
		foreach($value AS  $v) {
			$objPHPExcel->getActiveSheet()->setCellValue($cellname[$k].$i, "\t".$v);
			$objActSheet->getStyle($cellname[$k].$i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$objActSheet ->getStyle($cellname[$k].$i)->getAlignment()->setWrapText(true); //自动换行
			$k++;
		}
		$i++;		 
	}
	$objPHPExcel->getActiveSheet()->setTitle($filename);
	ob_end_clean();//清除缓冲区,避免乱码
	header("Content-type: text/html;charset=utf-8;");
	header('Content-Type: application/vnd.ms-excel;charset=utf-8;');
	header('Content-Disposition: attachment;filename='.$filename. ' '. date('Y-m-d', $_TGLOBAL['timestamp']).".xls");
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	
	exit;
	return ;
}

//用php从身份证中提取生日,包括15位和18位身份证
function getIDCardInfo($IDCard){
	$result['error']=0;//0：未知错误，1：身份证格式错误，2：无错误
	$result['flag']='';//0标示成年，1标示未成年
	$result['tdate']='';//生日，格式如：2012-11-15
	if(!eregi("^[1-9]([0-9a-zA-Z]{17}|[0-9a-zA-Z]{14})$",$IDCard)){
		$result['error']=1;
		return $result;
	}else{
		if(strlen($IDCard)==18){
			$tyear=intval(substr($IDCard,6,4));
			$tmonth=intval(substr($IDCard,10,2));
			$tday=intval(substr($IDCard,12,2));
			if($tyear>date("Y")||$tyear<(date("Y")-100)){
				$flag=0;
			}elseif($tmonth<0||$tmonth>12){
				$flag=0;
			}elseif($tday<0||$tday>31){
				$flag=0;
			}else{
				$tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
				if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>18*365*24*60*60){
					$flag=0;
				}else{
					$flag=1;
				}
			}
		}elseif(strlen($IDCard)==15){
			$tyear=intval("19".substr($IDCard,6,2));
			$tmonth=intval(substr($IDCard,8,2));
			$tday=intval(substr($IDCard,10,2));
			if($tyear>date("Y")||$tyear<(date("Y")-100)){
				$flag=0;
			}elseif($tmonth<0||$tmonth>12){
				$flag=0;
			}elseif($tday<0||$tday>31){
				$flag=0;
			}else{
				$tdate=$tyear."-".$tmonth."-".$tday." 00:00:00";
				if((time()-mktime(0,0,0,$tmonth,$tday,$tyear))>18*365*24*60*60){
					$flag=0;
				}else{
					$flag=1;
				}
			}
		}
	}
	$result['error']=2;//0：未知错误，1：身份证格式错误，2：无错误
	$result['isAdult']=$flag;//0标示成年，1标示未成年
	$result['birthday']=$tdate;//生日日期
	$result['montyday']=$tmonth."-".$tday." 00:00:00"; //年月
	return $result;
}

//设置用户信息
function setuserinfo($field, $value, $uid=0) {
	global $_TGLOBAL;
	
	!$uid && $uid = $_TGLOBAL['ctb_uid']; //参数不存在时，则取当前登录用户
	if (!$uid) return;
	$_TGLOBAL['db']->query("UPDATE ".tname('members')." SET $field = $field + $value WHERE id='$uid'");
}

/********************* 更新用户余额
本函数，用以将所有添加余额记录和更新用户创客余额的地方
传递参数为数组，数组中传递各值
			$ary('uid' => 用户id
				 'op' =>  操作类别，//参看common.php
				 'money' => 需要更新的值
				 'cur_money' => 操作当商户当前值
				 'remark' => 备注
				 )
*********************/
function add_member_money($ary) {
	global $_TGLOBAL;

	if (!$ary['uid'] || !$ary['op'] || !$ary['money']) return false;

	//添加到用户记录表
	$arr = array(
		'userid'           => 	$ary['uid'],
		'op'               => 	$ary['op'],
		'money'         => 	$ary['money'],
		'cur_money'     => 	$ary['money'] + $ary['cur_money'],
		'date'             => 	$_TGLOBAL['timestamp'],
		'remark'           => 	$ary['remark'],
		);
	$id = inserttable('member_money', $arr, 1);
	
	//更新用户的当前预存款
	setuserinfo('Balance', $ary['money'], $ary['uid']);
    return $id;
}

/* 对话框 ajax
参数数组  ok => 成功的提示
          error => 错误的提示
		  jumpto => 跳转地址
		  values => 替换的值
*/
function showmessage_ajax($ary) {
	global $_TGLOBAL;
	
	obclean();
	$msgkey = $ary['ok'] ? $ary['ok'] : $ary['error'];
	$values = $ary['values'];

	include_once(S_ROOT.'./language/lang_showmessage.php');
	if(isset($_TGLOBAL['msglang'][$msgkey])) {
		$message = lang_replace($_TGLOBAL['msglang'][$msgkey], $values);
	} else {
		$message = $msgkey;
	}

	$return['ok'] =  $ary['ok'] ? $message : '';
	$return['error'] = $ary['error'] ? $message : '';
	$return['jumpto'] = $ary['jumpto'];
	$return['id'] = $ary['id'];
	echo json_encode($return);
	exit();
}

//处理ajax显示
function ajax_list($list) {	
	if (!isset($_GET['ajax'])) return ;

	$return['list'] = $list;
	echo json_encode($return);
	exit;
}

//短信内容
function sms_send($ary_phone, $content, $email_tempalte='', $other=array()) {
	global $_TGLOBAL;

	//当有模板时，调用模板的内容
	if ($email_tempalte) {
		//取出模板的相关内容
		$query 	  = $_TGLOBAL['db']->query("SELECT content FROM ".tname('template')." WHERE name='$email_tempalte'");
		$template = $_TGLOBAL['db']->fetch_array($query);

		$content = $template['content'];

		//替换标题里各元素的值
		foreach($other AS $kk => $val) {
			$content = str_replace('$'.$kk, $val, $content);
		}
	}

//echo ($content);exit;

	if (mb_strlen($content, 'UTF-8') < 1) {
		return true;
	}

	$content .= '【人人优泊】'; //加上签名

	include_once(S_ROOT.'./lib/function/function_transport.php');
	//接口帐号
	$user = 'LKSDK0005413'; 
	$pass = 'zh9527@';
	
	$old_content = $content;
	$content = siconv($content, 'gbk', 'utf-8');
	//$content = urlEncode($content);

	if (!is_array($ary_phone)) {
		$ary_phone = array($ary_phone);
	}

	//一次发送多个号码
	$newphone = implode(',', $ary_phone);
	$apiget = "CorpID={$user}&Pwd={$pass}&Mobile={$newphone}&Content={$content}&Cell=&SendTime=";
	$t		= new transport;
	$body	= $t->request('http://mb345.com:999/ws/BatchSend2.aspx', $apiget);
	$res = $body['body'];


	//if (trim(strval($res)) > '1')

	foreach($ary_phone AS $phone) {
		$phone= trim($phone);

		if(null==$phone) continue;
		if(strlen($phone)<>11){    
			continue;     
		}  
	
		//写进短信日志			
		$logerr = array(
				'mobile'         => 	$phone,
				'message'        => 	$old_content,
				'date'           => 	$_TGLOBAL['timestamp'],
				'flag'			 =>		$res,
					);
		//inserttable('smslog', $logerr);	
	}

	return true;
}



/*
//字符串前后加显示，中间*号
* 1345****855
* 适用于手机号码、身份证、银行卡等号码的隐藏
* $before_length 星星前面的数字个数
* $after_length  星星后面的数字个数
*/
function get_star($str, $before_length = 0, $after_length = 0) {
	$str_length    = strlen($str);
	$star_length   = ((int)($str_length / 4)) * 2 ;  //星星个数(为了构建偶数个星星，所以先除4在乘2)
	!$before_length && $before_length = (int)(($str_length - $star_length ) / 2);  //前面字符串个数
	!$after_length && $after_length  = $str_length - $star_length - $before_length  ;  
	
	$return_str    = substr($str, 0, $before_length);
	$before_length >=4 && $return_str    .= ' ';  //前面加空格
	for($i=1; $i <= $star_length; $i++) {
		$return_str .= '*';
		
		//如果星星个数>6 并且 输入星星个数为一半的时候加空格
		if($star_length > 6 && $i == (int)($star_length/2) ){
			$return_str .= ' ';
		}
	}
	$before_length >=4 && $return_str    .= ' ';  //后面加空格
	$return_str .= substr($str, $star_length + $before_length -1, $after_length);
	
	return $return_str;
}

/*
* $countsql  查询个数分sql语句 用于分页
* $selectsql 要查询的内容sql语句
* $perpage   每页数量
* $page      开始页数
*/
function getpagelog($countsql, $selectsql, $perpage=10, $page=1){
	global $_TGLOBAL;
	$page<1 && $page = 1;
	$start   = ($page-1)*$perpage;
	//检查开始数
	//ckstart($start, $perpage);
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query($countsql), 0);
	if($count) {
		$list = $_TGLOBAL['db']->getall($selectsql." LIMIT $start,$perpage");
	}
	$multi = multi($count, $perpage, $page, get_current_url());
	//返回值
	$return['multi'] = $multi;
	$return['list'] = $list;
	return $return;
}

//汉字转ASCII 
function encode($c){  
    $len = strlen($c);  
    $a = 0;  
    while ($a < $len){  
        $ud = 0;  
        if (ord($c{$a}) >=0 && ord($c{$a})<=127){  
            $ud = ord($c{$a});  
            $a += 1;  
        }else if (ord($c{$a}) >=192 && ord($c{$a})<=223){  
            $ud = (ord($c{$a})-192)*64 + (ord($c{$a+1})-128);  
            $a += 2;  
        }else if (ord($c{$a}) >=224 && ord($c{$a})<=239){  
            $ud = (ord($c{$a})-224)*4096 + (ord($c{$a+1})-128)*64 + (ord($c{$a+2})-128);  
            $a += 3;  
        }else if (ord($c{$a}) >=240 && ord($c{$a})<=247){  
            $ud = (ord($c{$a})-240)*262144 + (ord($c{$a+1})-128)*4096 + (ord($c{$a+2})-128)*64 + (ord($c{$a+3})-128);  
            $a += 4;  
        }else if (ord($c{$a}) >=248 && ord($c{$a})<=251){  
            $ud = (ord($c{$a})-248)*16777216 + (ord($c{$a+1})-128)*262144 + (ord($c{$a+2})-128)*4096 + (ord($c{$a+3})-128)*64 + (ord($c{$a+4})-128);  
            $a += 5;  
        }else if (ord($c{$a}) >=252 && ord($c{$a})<=253){  
            $ud = (ord($c{$a})-252)*1073741824 + (ord($c{$a+1})-128)*16777216 + (ord($c{$a+2})-128)*262144 + (ord($c{$a+3})-128)*4096 + (ord($c{$a+4})-128)*64 + (ord($c{$a+5})-128);  
            $a += 6;  
        }else if (ord($c{$a}) >=254 && ord($c{$a})<=255){ //error  
            $ud = false;  
        }  
        $scill .= "&#$ud;";  
    }  
    return $scill;  
}  
  
 /*
* 在某个数据表里面生成不重复的编号
* $tablename 数据表 表名
* $fieldname 字段名
* $length    生成编号的长度 年份+月份+日期 + 随机长度
* $char      生成字符串类型
			0:纯数字 默认
			1、小写
			2、大写
*/
function makeno($tablename ,$fieldname ,$length=8, $pre='') {
	global $_TGLOBAL;
	// random(长度,是否纯数字=0);
	//echo strtoupper(random(4)); //大写 含数字
	//echo strtolower(random(4)); //小写 含数字
	/* if($char == 1){
		$no = strtolower(random(8 + $length ));
	}elseif($char == 2){
		$no = strtoupper(random(8 + $length ));
	}else{
		$no = date('Ymd', $_TGLOBAL['timestamp']).random($length, 1);
	} */
	$no = $pre.random($length, 1); //纯数字
	$is_exist = $_TGLOBAL['db']->getrow('SELECT NULL FROM '.tname($tablename) . " WHERE $fieldname ='$no'");
	//如果存在继续执行这个函数
	
	$is_exist &&	makeno($tablename ,$fieldname ,$length, $pre);
	
	return $no;
}

//更新编号


/*
* $pid 数组中的父级id
* $level 为类的第几集
* $html  前面的替换
* 每个数组都有个id
* 顶级pid默认为0
*
* 返回 按树状排列的数组
* sort 本级别
* html 前面需要的
*   可以用来显示栏目，传入的栏目有没有隐藏
*/
/*function tree($list,$pid=0,$level=0,$html='|---', $tree = array()){
    static $i = 0;
	if(!is_array($list)){
		 return $list;
	}
    foreach($list as $k=>$v){
        if(!is_array($v)) continue;
		if($v['pid'] == $pid){
            $v['sort'] = $level;
			if($level){
				$v['html'] =str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$level) .$html; 
			}
			//$v['html'] =str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$i) .$html; 
            $tree[$k] = $v;
            $tree = tree($list,$v['id'], $level+1, $html, $tree);
        } 
		
    }
	$i++;
    return $tree;
}*/

function tree($list,$pid=0,$level=0,$html='|---'){
    static $tree = array();
	if(!is_array($list)){
		 return $list;
	}
    foreach($list as $k=>$v){
        if(!is_array($v)) continue;
		if($v['pid'] == $pid){
            $v['sort'] = $level;
			if($level){
				$v['html'] =str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$level) .$html; 
			}
			//$v['html'] =str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;',$i) .$html; 
            //$tree[$k] = $v;
            $tree[$k] = $v;
            $tree = tree($list,$v['id'], $level+1, $html);
        } 
		
    }
    return $tree;
}

/**
* 得到当前位置数组 用于面包屑
* @param int
* @return array
*/
/*
function get_pos($myid, &$arr){
	static $str = '';
	if(!isset($arr[$myid])) return false;
	
	$str = $arr[$myid]['name'].$str;
	if($arr[$myid]['pid']){
		$pid = $arr[$myid]['pid'];
		$str = '->'.$str ;
		$str = get_pos($pid, $arr);
	}
	echo $str;
	//return $str;
}*/

function get_pos($myid, $arr, $der='->'){
	//static $str = '';
	if(!isset($arr[$myid])) return false;
	
	$str = $arr[$myid]['name'];
	if($arr[$myid]['pid']){
		$pid = $arr[$myid]['pid'];
		//$str = '->'.$str ;
		$return = get_pos($pid, $arr);
		$str = $return.$der.$str ;
	}
	return $str;
}

/*
* 按次序得到树状数组
* $level 层数
*/
function get_tree($arr, $myid, $level=999){	
	global $_TCONFIG,$_TGLOBAL;
    static $tree = array(); 
    foreach ($arr as $key=>$val) {			
		if($val['pid'] == $myid){
			$tree[$key] = $val;
			if($level > 1){
				$tree = get_tree($arr,$val['id'], $level-1);
			}
		}
    }
    return $tree;
}

/*
* 得到栏目的第一个子集
* 
*/
function first_child($myid, $arr){
    foreach($arr as $k=>$v){
        if($v['pid'] == $myid){
			return $v;
        }
    }
	//如果上面没有返回  则返回自己
	return $arr[$myid];
	//return false;
}

/*
* 得到栏目的第一个子集
* 
*/
function all_child($myid, $arr){
    foreach($arr as $k=>$v){
        if($v['pid'] == $myid){
			$return[] = $v;
        }
    }
	//如果上面没有返回  则返回
	if(isset($return)){
		return $return;
	}else{
		return false;
	}
}


/*
* 得到栏目的上一级
* 
*/
function get_parent($myid, $arr){
	$pid = $arr[$myid]['pid'];
	if($pid){ //如果自己是顶级栏目则返回自己
		$return = $arr[$pid];
	}else{
		$return = $arr[$myid];
	}
	return $return;
}

/**
* 得到数组 一级栏目
* @param int
* @return array
*/
function get_top($myid, $arr){
	if(!isset($arr[$myid])) return false;
	
	$pid = $arr[$myid]['pid'];
	if($pid){ //如果自己是顶级栏目则返回自己
		$return = get_top($pid, $arr);
	}else{
		$return = $arr[$myid];
	}
	return $return;
}

// 得到所有子级 孙子级
// 见 tree 


/*
* $Ary 需要操作的数组
* $SelectName 下拉选择框 name、id 
* $val 应该选择的那个的值
*
* $events   附加属性 如：datatype="Require" msg="请选择优惠券种类."
*
* $ele_value 如果是二位数组，则option的值的key
* $ele_name 如果是二维数组，则需要展示的key
*
* $optionsname='请选择...'
* $optionsvalue=''
* $istree  是不是树状
*/
function makeselect($Ary,$SelectName,$val,$events='',$ele_name='', $ele_value='', $optionsname='请选择...', $optionsvalue='', $istree='' ) {
	
	$str ='';
	$str .= "<select name=\"" . $SelectName . "\" id=\"" . $SelectName . "\" $events>\n";
	$str .= "<option value=\"$optionsvalue\">$optionsname</option>\n";
	reset($Ary);
	while(list($Line,$Value)=each($Ary)) {	
	
		// 组成 下拉框的 option value
		if ($ele_value){ //如果是二位数组
			$Lines = $Value[$ele_value];
		}else{
			$Lines = $Line;
		}
		
		// 组成 下拉框的 option 显示值
		if ($ele_name){ //如果是二位数组
			$Values = $Value[$ele_name];
		}else{
			$Values = $Value;
		}
		
		// 判断是不是树状
		if ($istree){ //如果是二位数组
			$html = isset($Value['html']) ? $Value['html'] : '';
				
		}else{
			$html = '';
		}
		
		if ($Values == '') continue;
		
	    $str .=  "<option value=\"".$Lines."\"";
		if ($Lines == $val && $val != "") {
			$str .=  " selected";
		}		
		$str .=  ">" .$html.$Values . "</option>\n";
	}	
	$str .=  "</select>\n"; 
	return $str;
}


// 
function iswap(){ 
	if(strpos(strtoupper($_SERVER['HTTP_ACCEPT']),"VND.WAP.WML") > 0){ // 检查浏览器是否接受 WML. 
		return true; 
	} elseif(preg_match('/(blackberry|configuration\/cldc|hp |hp-|htc |htc_|htc-|iemobile|kindle|midp|mmp|motorola|mobile|nokia|opera mini|opera |Googlebot-Mobile|YahooSeeker\/M1A1-R2D2|android|iphone|ipod|mobi|palm|palmos|pocket|portalmmm|ppc;|smartphone|sonyericsson|sqh|spv|symbian|treo|up.browser|up.link|vodafone|windows ce|xda |xda_)/i', $_SERVER['HTTP_USER_AGENT'])){ //检查USER_AGENT 
		return true;        
	} 
	else{ 
		return false;   
	  } 
}

function is_weixin()
{ 
    if ( strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false ) {
        return true;
    }  
        return false;
}