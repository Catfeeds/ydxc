<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/index.php?do=getwxinfo");
	exit();
}

$id = $_GET['id'];

//更新阅读次数
$_TGLOBAL['db']->query('UPDATE '.tname('news')." SET readno=readno+1 WHERE id='$id'");

$newsshow            = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id='$id'");
//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
$class_id         = $newsshow['class_id'];
$newsshow['name'] = $newsshow['title'];


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








echo template('show', get_defined_vars());
?>