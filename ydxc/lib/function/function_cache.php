<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: function_cache.php 2009-4-15 23:32:55 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//更新配置文件
function config_cache($updatedata=true) {
	global $_TGLOBAL, $_TCONFIG;

	$_TCONFIG = array();
	$_TCONFIG['template'] = 'default'; //默认，在后台缓存时需要用到
	$query = $_TGLOBAL['db']->query('SELECT * FROM '.tname('config'));
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		if($value['var'] == 'privacy') {  //序列化存放变量
			$value['datavalue'] = empty($value['datavalue'])?array():unserialize($value['datavalue']);
		}
		$_TCONFIG[$value['var']] = $value['datavalue'];
	}
	cache_write('config', '_TCONFIG', $_TCONFIG);

	if($updatedata) {
		$setting = data_get('setting');
		$_TGLOBAL['setting'] = empty($setting)?array():unserialize($setting);

		//取得计划任务的运行时间
		$nextrun = getcount('crons', "available>'0' AND nextrun>'0' ORDER BY nextrun", 'nextrun');
		$_TGLOBAL['setting']['cronnextrun'] = $nextrun;

		cache_write('setting', "_TGLOBAL['setting']", $_TGLOBAL['setting']);

		$mail = data_get('mail');
		$_TGLOBAL['mail'] = empty($mail)?array():unserialize($mail);
		cache_write('mail', "_TGLOBAL['mail']", $_TGLOBAL['mail']);

		$spam = data_get('spam');
		$_TGLOBAL['spam'] = empty($spam)?array():unserialize($spam);
		cache_write('spam', "_TGLOBAL['spam']", $_TGLOBAL['spam']);
	}
}

//更新公众号类别
function weixin_class_cache() {
	global $_TGLOBAL;

	$_TGLOBAL['weixin_class'] = array();
	$query = $_TGLOBAL['db']->query('SELECT * FROM '.tname('weixin_class')." ORDER BY display DESC, id ASC");
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$_TGLOBAL['weixin_class'][$value['class_id']] = $value;
	}
	cache_write('weixin_class', "_TGLOBAL['weixin_class']", $_TGLOBAL['weixin_class']);
}

//更新模板文件
function tpl_cache() {
	$dir = S_ROOT.'./data/tpl_cache';
	$files = sreaddir($dir);
	foreach ($files as $file) {
		file_exists($dir.'/'.$file) && unlink($dir.'/'.$file);
	}
}

//递归清空目录
function deltreedir($dir) {
	$files = sreaddir($dir);
	foreach ($files as $file) {
		if(is_dir("$dir/$file")) {
			deltreedir("$dir/$file");
		} else {
			file_exists("$dir/$file") && unlink("$dir/$file");
		}
	}
}

/*
* 生成树状数组缓存
* $name 数据表名 与生成数组名一样
*/
function treecache($name, $arr) {
	global $_TGLOBAL;

	cache_write($name, "_TGLOBAL['$name']", $arr);
}

/*
* 读取树状数组缓存文件 如果不存在则重新生成
* $name 数据表名 与生成数组名一样
*/
function loadtree($name, $arr) {
	global $_TGLOBAL;

	$cachefile = S_ROOT . './data/data_' . $name . '.php';
	file_exists($cachefile) && $arraydata = include $cachefile;
	if (!$arraydata) {
		treecache($name, $arr);
		file_exists($cachefile) && $arraydata = include $cachefile;
	}
	
	return $arraydata;
}


/*
* 生成缓存文件
* $name 数据表名 与生成数组名一样

* $tree 是否生成为树状缓存
*/
function makecache($name, $fieldname='', $multi='', $order='', $tree=0) {
	global $_TGLOBAL;

	$_TGLOBAL[$name] = array();
	$orderby = '';
	$order && $orderby = ' ORDER BY '.$order.' ASC ';
	
	$sql = 'SELECT * FROM '.tname($name).$orderby;
	$list = $_TGLOBAL['db']->getall($sql, $fieldname, $multi);
	
	if($tree){
		if($multi){
			foreach($list as $key=>$val){
				$list[$key] = tree($val);
			}
		}else{
			$list = tree($list);
		}
		$name = 'tree_'.$name;	
	}
	cache_write($name, "_TGLOBAL['$name']", $list);
}


/*
* 读取缓存文件 如果不存在则重新生成
* $name 数据表名 与生成数组名一样

* $tree 是否加载为树状缓存
*/
function loadcache($name, $fieldname='', $multi='', $order='', $tree=0) {
	global $_TGLOBAL;
	
	if($tree){
		$cachefile = S_ROOT . './data/data_tree_' . $name . '.php';
	}else{
		$cachefile = S_ROOT . './data/data_' . $name . '.php';
	}
	file_exists($cachefile) && $arraydata = include $cachefile;
	if (!isset($arraydata)) {
		makecache($name, $fieldname, $multi, $order, $tree);
		file_exists($cachefile) && $arraydata = include $cachefile;
	}
	
	return $arraydata;
}


/*
* 缓存树 后台菜单、前台栏目
* 
*/

/*
* 讲数组 整理成带换行的数组字符串
*/
//数组转换成字串
function arrayeval($array, $level = 0) {
	$space = '';
	for($i = 0; $i <= $level; $i++) {
		$space .= "\t";
	}
	$evaluate = "Array\n$space(\n";
	$comma = $space;
	foreach($array as $key => $val) {
		$key = is_string($key) ? '\''.addcslashes($key, '\'\\').'\'' : $key;
		//$val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		//$val = !is_array($val) && (!is_numeric($val) || strlen($val) > 12) ? '\''.addcslashes($val, '\'\\').'\'' : $val;
		!is_array($val) && $val = '\''.$val.'\'';
		if(is_array($val)) {
			$evaluate .= "$comma$key => ".arrayeval($val, $level + 1);
		} else {
			$evaluate .= "$comma$key => $val";
		}
		$comma = ",\n$space";
	}
	$evaluate .= "\n$space)";
	return $evaluate;
}

/*
* $name 文件名与路径 data_config.php
* $var  文件中 数组名称
* $values 文件中数组的值
*/
//写入缓存
function cache_write($name, $var, $values) {
	$cachefile = S_ROOT . './data/data_' . $name . '.php';
	$cachetext = "<?php\r\n".
		"!defined('IN_CTB') && die('Access Denied');\r\n".
		'$'.$var.'=' . arrayeval($values).
		"\r\n?>";
	if(!swritefile($cachefile, $cachetext)) {
		exit("File: $cachefile write error.");
	}
}

