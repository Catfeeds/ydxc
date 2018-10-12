<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: function_admin.php 2009-5-3 22:32:58 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-type: text/html; charset=utf-8");

//网站后台所用对话框
function showmsg($msgkey, $url_forward='', $second=1, $values=array(), $parent=0) {
	global $_TGLOBAL, $_CTB, $_TCONFIG, $_TPL, $_SN;
	
	obclean();
	
	//去掉广告
	$_TGLOBAL['ad'] = array();

	include_once(S_ROOT.'./language/lang_showmessage.php');
	if(isset($_TGLOBAL['msglang'][$msgkey])) {
		$message = lang_replace($_TGLOBAL['msglang'][$msgkey], $values);
	} else {
		$message = lang_replace($msgkey, $values);
	}
	
	if($url_forward) {
		$message = "<a href=\"$url_forward\" ".($parent ? 'target="_parent"' : '').">$message</a><script>setTimeout(\"".($parent ? 'parent' : 'window').".location.href ='$url_forward';\", ".($second*1000).");</script>";
	}
	
	echo template('showmessage_admin', get_defined_vars());
	exit();
}


//* 功能：用数组中的元素生成下拉框
/*  此函数已经修改成 makeselect
* $Ary 需要操作的数组
* $SelectName 下拉选择框 name id 
* $val 应该选择的那个的值
* $ele_name  如果是二维数组，则需要展示的key
* $events    附加属性 如：datatype="Require" msg="请选择优惠券种类."
* $ele_value 如果是二位数组，则option的值的key
*/
function GetSelect($Ary,$SelectName,$val,$ele_name='',$events='', $optionsname='请选择...', $optionsvalue='', $ele_value='') {

	echo "<select name=\"" . $SelectName . "\" id=\"" . $SelectName . "\" $events>\n";
	echo "<option value=\"$optionsvalue\">$optionsname</option>\n";
	reset($Ary);
	while(list($Line,$Value)=each($Ary)) {					if ($ele_value){			$Lines = $Value[$ele_value];		}else{			$Lines = $Line;		}		
		if ($ele_name) $Value = $Value[$ele_name];
		if ($Value == '') continue;
	    echo "<option value=\"".$Lines."\"";
		if ($Lines == $val && $val != "") echo " selected";		
		echo ">" . $Value . "</option>\n";
	}	
	echo "</select>\n";
}

//* 功能：用数组中的元素生成单选框
function GetRadio($Ary,$SelectName,$val,$ele_name='',$events='') {

	reset($Ary);
	while(list($Line,$Value)=each($Ary)) {
		if ($ele_name) $Value = $Value[$ele_name];
		echo '<input type="radio" name="'.$SelectName.'" id="'.$SelectName.$Line.'" value="'.$Line.'" ';
		if ($Line == $val && $val != "") echo " checked";
		echo '/>';
		echo '<label for="'.$SelectName.$Line.'">'.$Value.'</label>';
	}
}

//* 功能：用数组中的元素生成复选框
function GetCheckbox($Ary,$SelectName,$val,$ele_name='',$events='') {

	reset($Ary);
	while(list($Line,$Value)=each($Ary)) {
		if ($ele_name) $Value = $Value[$ele_name];
		echo '<input type="checkbox" name="'.$SelectName.'[]" id="'.$SelectName.$Line.'" value="'.$Line.'" ';
		//if ($Line == $val ) echo " checked"; //&& $val != ""
		
		if ((array)$val) {
			$aryzoneid = explode(',', $val);
			echo in_array($Line, $aryzoneid) ? ' checked' : '';
		}

		echo '/>';
		echo '<label for="'.$SelectName.$Line.'">'.$Value.'</label>';
	}
}

//* 功能：生成排序的字段
function GetOrder($name,$f_name,$field,$order) {
	@$tmp = get_current_url(array('field', 'order'));
	$tmp2 = '' ;
	if ($order == "" || $order == "DESC") { //如果排序等于空
		$tmp .= "&field=$f_name&order=ASC"; //则按升序排序
		if ($order != "" && $f_name == $field) $tmp2 = "↓";
	} else {
		$tmp .= "&field=$f_name&order=DESC"; //如果不为空，则按降序排
		if ($f_name == $field) $tmp2 = "↑";
	}
	//加上其他搜索的字段
	/*$GLOBALS['keywords'] && $tmp .= '&keywords=' . $GLOBALS['keywords'];
	$GLOBALS['page'] && $tmp .= '&page=' . $GLOBALS['page'];
	$GLOBALS['date_start'] && $tmp .= '&date_start=' . $GLOBALS['date_start'];
	$GLOBALS['date_end'] && $tmp .= '&date_end=' . $GLOBALS['date_end'];
	$GLOBALS['class_id'] && $tmp .= '"&class_id=' . $GLOBALS['class_id'];
*/
	$link = "<a href=\"".$tmp."\">$name</a>" . $tmp2; //如果不为空，则按降序排

	return $link;
}

//* 功能：解析sql语句
function splitsql($sql){
	$sql = str_replace("\r", "\n", $sql);
	$ret = array();
	$num = 0;
	$queriesarray = explode(";\n", trim($sql));
	unSET($sql);
	foreach($queriesarray AS $query) {
		$queries = explode("\n", trim($query));
		foreach($queries AS $query) {
			$ret[$num] .= $query[0] == "#" ? NULL : $query;
		}
		$num++;
	}
	return($ret);
}

//管理员权限检查
function checkpermission($ac='', $mod='') {
	global $_TGLOBAL;

	!$ac  && $ac  = isset($_GET['ac']) ? $_GET['ac'] : '' ;
	!$mod && $mod = isset($_GET['mod']) ? $_GET['mod'] : '';

	if($_TGLOBAL['adm_role_id'] == 1){
		return true; // 超级管理员
	}
	$roles = $_TGLOBAL['admin_role_priv'][$_TGLOBAL['adm_role_id']]; // 权限集合
	foreach ($roles as $key=>$val){
		if ($val['ac'] == $mod && $val['mod'] == $ac ){
			$return = 1;
			break;
		}
	}
	
	if($return){
		return true;
	}else{
		showmsg('对不起，您没有权限访问该页面');
	}
}



//记录管理员日志
function adminlogs() {
	global $_TGLOBAL;
	$uri = $_SERVER['REQUEST_URI'] ? $_SERVER['REQUEST_URI'] : ($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']);
	$adminlogarr = array(
		'username'         => 	$_TGLOBAL['adm_username'],
		'ip'               => 	getonlineip(),
		'date'             => 	$_TGLOBAL['timestamp'],
		'url'              => 	$uri
		);
	inserttable('adminlog', $adminlogarr);
	return ;
}

//得到多级下拉框 地区信息
function getclasszoneselect($class_id='', $event='', $tclass='class_zone', $name='zone_id') {
	global $_TGLOBAL;
	$class_id = substr($class_id, 0, 3);
	$return = "<select name=\"$name\" id=\"$name\" $event>\n";
	$return .= "<option value=\"\" selected=\"selected\">--请选择--</option>\n";
	foreach($_TGLOBAL[$tclass] AS $key => $value) {
		if (strlen($key) != 3) continue;
		
		$return .= "<option value=\"$key\"";
		$key == $class_id && $return .= ' selected="selected"';
		$return .= ">$value[name]</option>\n";
		/*
		foreach($_TGLOBAL['class_zone'] AS $kk => $vv) {
			if (substr($kk, 0, 3) == $key && strlen($kk) != 3) {
				
				$return .= "<option value=\"$kk\"";
				$kk == $class_id && $return .= ' selected="selected"';
				$return .= ">├─$vv[name]</option>\n";
			}
		}*/
	}
	$return .= "</select>\n";
	return $return;
}


