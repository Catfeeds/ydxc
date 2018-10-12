<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

$do == 'baoming' && $class_id = 14;

//取出页面左边的分类
$firstchild  = first_child($class_id, $_TGLOBAL['tree_news_class']); //第一个子栏目
$topparent   = get_top($class_id, $_TGLOBAL['tree_news_class']); //顶级栏目id
$parent      = get_parent($class_id, $_TGLOBAL['tree_news_class']); //父级栏目id
//$left        = tree($_TGLOBAL['tree_news_class'],$topparent['id'],1); // 左侧模板 顶级栏目id构建
if($firstchild['id'] == $class_id){ //如果第一个子级就是自己，没有子级 显示父级的栏目下面的
	$left        = get_tree($_TGLOBAL['tree_news_class'],$parent['id'], 1); // 左侧模板 顶级栏目id构建
}else{
	$left        = get_tree($_TGLOBAL['tree_news_class'],$class_id, 1); // 左侧模板 顶级栏目id构建
}
$class_name  = $_TGLOBAL['tree_news_class'][$class_id]; //当前栏目数组
$template    = $class_name['template']; //得到当前栏目的模板

!$class_id && $template = 'news'; //当没有类别时，则为搜索，调用新闻
$curr_class  = get_pos($firstchild['id'], $_TGLOBAL['tree_news_class'], ' > '); //当前位置


if(isset($_POST['sign'])){
	// 执行申请
	$dailiarr = array(				
			'courseid'         => 	$_POST['courseid'],
			'num'              => 	$_POST['num'],
			'name'             => 	$_POST['name'],
			'sex'              => 	$_POST['sex'],
			'card'             => 	$_POST['card'],
			'cardno'           => 	$_POST['cardno'],
			'tel'              => 	$_POST['tel'],
			'mobile'           => 	$_POST['mobile'],
			'area'             => 	$_POST['area'],
			'point'            => 	$_POST['point'],
			'qq'               => 	$_POST['qq'],
			'remark'           => 	$_POST['remark'],
			'date'             => 	$_TGLOBAL['timestamp'],
			'ispay'            => 	$_POST['ispay'],
			'money'            => 	$_POST['money'],
			'paydate'          => 	$_POST['paydate'],
					);
	$id = inserttable('sign', $dailiarr, 1);
	
	//if(iswap() && $class_id==8){
	if(is_weixin()){
		//showmessage('报名提交成功，我们会尽快联系你。', 'index.php?do=fukuan&id='.$id, 0);	
		header("Location: index.php?do=fukuan&courseid=".$_POST['courseid']."&id=".$id);
	}else{
		showmessage('报名提交成功，我们会尽快联系你。', './');	
	}
	
}





$select_sex =  makeselect($_TGLOBAL['setting']['sex'], 'sex','','datatype="Require" msg="请填写性别."', '',  '',  '请选择性别', $optionsvalue='');

echo template('baoming', get_defined_vars());
?>