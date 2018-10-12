<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: xml.php 2010-1-12 16:35:11 jerry $
*/

//通用文件
include_once('../common.php');
//include_once(S_ROOT . './lib/function/function_xml.php');

//允许的方法
$dos = array( 
			'supplied', //供应商供应物资
			'init', //物资初始化
			
			);

$do = (empty($_GET['ac']) || !in_array($_GET['ac'], $dos)) ? '' : $_GET['ac'];


if (isset($_POST['ac'])) {
	$do = (empty($_POST['ac']) || !in_array($_POST['ac'], $dos)) ? '' : $_POST['ac'];
}


$op = empty($_GET['op']) ? '' : $_GET['op'];
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '' ;

!$do && die('Access Denied');

switch($do) {
	case 'supplied': //供应商供应物资
		$classid = $_GET['classid']; //
		$brandid = $_GET['brandid']; //
		$supplierid = isset($_GET['supplierid']) ? $_GET['supplierid'] : 0; //
		$nameid = isset($_GET['nameid']) ? $_GET['nameid'] : 0; //
		
		$where = 'WHERE 1=1 ';
		$classid && $where .= "AND classid='$classid'";
		$brandid && $where .= "AND brandid='$brandid'";
		//$supplierid && $where .= "AND supplierid='$supplierid'";
		
		$sql = "SELECT * FROM ".tname('name')." $where ORDER BY id DESC";
		$goods_list = $_TGLOBAL['db']->getall($sql);
		
		$str = '<select name="nameid" id="nameid" datatype="Require" msg="请选择物资名称." >'."\n";
		$str .= "<option value=\"\">--请选择--</option>\n";
		foreach($goods_list as $key=>$val){
			if($val['id'] == $nameid){
				$selected = 'selected' ;
			}else{
				$selected = '' ;
			}
			$str .= "<option value=\"$val[id]\" $selected >".$val['name']."</option>\n";
		}
		$str .= '</select>'."\n";
		echo $str;
		break;

	case 'init': //供应商供应物资
		$classid = $_GET['classid']; //
		$brandid = $_GET['brandid']; //
		//$supplierid = isset($_GET['supplierid']) ? $_GET['supplierid'] : 0; //
		$nameid = isset($_GET['nameid']) ? $_GET['nameid'] : 0; //
		
		$where = 'WHERE 1=1 ';
		$classid && $where .= "AND classid='$classid'";
		$brandid && $where .= "AND brandid='$brandid'";
		//$supplierid && $where .= "AND supplierid='$supplierid'";
		
		$sql = "SELECT * FROM ".tname('name')." $where ORDER BY id DESC";
		$goods_list = $_TGLOBAL['db']->getall($sql);
		
		$str = '<select name="nameid" id="nameid" datatype="Require" msg="请选择物资名称." >'."\n";
		$str .= "<option value=\"\">--请选择--</option>\n";
		foreach($goods_list as $key=>$val){
			if($val['id'] == $nameid){
				$selected = 'selected' ;
			}else{
				$selected = '' ;
			}
			$str .= "<option value=\"$val[no]\" $selected >".$val['name']."</option>\n";
		}
		$str .= '</select>'."\n";
		echo $str;
		break;

}


?>