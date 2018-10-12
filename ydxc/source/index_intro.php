<?php
/*
	[CTB] (C) 2007-2009
	$Id: index_intro.php 2011-5-13 15:43:46 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$class_id = $_GET['class_id'];
//!$class_id && die('Access Denied');

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

switch($template) {
	case 'intro': // 单页
		$iscourse = in_array($class_id,array(8,9,10,11,12,));  // 班级介绍
		if($iscourse){ // 班级介绍
			if(iswap() && $class_id==8){
				$courses  = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('course')." ORDER BY id DESC LIMIT 0,4");
				echo template('banji', get_defined_vars());
				die;
			}else{
				$newsshow = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('course')." WHERE  classid='$firstchild[id]' ORDER BY date DESC LIMIT 0,1 ");
			}
		}else{
			$newsshow = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE  class_id='$firstchild[id]' ORDER BY date DESC LIMIT 0,1 ");
			$newsshow['name'] = $newsshow['title'];
		}
		
		if(iswap()){
			if($class_id == 15){
				echo template('lianxifangshi', get_defined_vars());
				die;
			}
			
		}
		echo template($template, get_defined_vars());
		break;
	
	case 'list_pic':
	case 'pic_more':

		$perpage = $template == 'list_pic' ? 12 : 12;
		if(iswap()){$perpage = 5;}
		$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
		$page<1 && $page = 1;
		$start   = ($page-1)*$perpage;
		//检查开始数
		ckstart($start, $perpage);
		$wheresql = "WHERE display=1";

		$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : ( isset($_GET['keywords']) ? $_GET['keywords'] : ''));
		$keywords && $wheresql .= " AND (title LIKE '%$keywords%')";

		$firstchild['id'] && $wheresql .= " AND class_id='$firstchild[id]'";
		if($class_id != 3){
			$orderby = "ORDER BY displayorder DESC, id DESC";
		}else{
			$orderby = "ORDER BY kemu ASC, displayorder DESC, id DESC";
		}

		$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('news')." $wheresql"), 0);
		if($count) {
			$query = $_TGLOBAL['db']->query("SELECT  * FROM ".tname('news')." $wheresql $orderby LIMIT $start,$perpage");
			while ($value = $_TGLOBAL['db']->fetch_array($query)) {
				$value['img'] = getthumbimg($value['img']);
				//$value['summary'] = nl2br($value['summary']);
				$list[]       = $value;
			}
			ajax_list($list); //处理ajax
		}
		
		$multi = multi($count, $perpage, $page, get_current_url());
		echo template($template, get_defined_vars());
		break;
		
	case 'list_news':
		if($firstchild['id'] == $class_id || iswap()){
			$perpage = $template == 'list_pic' ? 12 : 12;
			$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
			$page<1 && $page = 1;
			$start   = ($page-1)*$perpage;
			//检查开始数
			ckstart($start, $perpage);
			$wheresql = "WHERE display=1";

			$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : ( isset($_GET['keywords']) ? $_GET['keywords'] : ''));
			$keywords && $wheresql .= " AND (title LIKE '%$keywords%')";

			
			if(iswap()){
				$allchild = all_child($class_id, $_TGLOBAL['tree_news_class']);

				if($allchild){
					$class_ids = '';
					$exp       = '';
					foreach($allchild as $val){
						$class_ids .= $exp.$val['id'];
						$exp       = ',';
					}					
					$wheresql .= " AND class_id in ($class_ids)";
				}else{
					$firstchild['id'] && $wheresql .= " AND class_id='$firstchild[id]'";
				}
				
			}else{
				$firstchild['id'] && $wheresql .= " AND class_id='$firstchild[id]'";
			}

			$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('news')." $wheresql"), 0);
			if($count) {
				$query = $_TGLOBAL['db']->query("SELECT  title, id, date, class_id FROM ".tname('news')." $wheresql ORDER BY displayorder DESC, id DESC LIMIT $start,$perpage");
				while ($value = $_TGLOBAL['db']->fetch_array($query)) {
					if(iswap()){
						$value['classname'] = $_TGLOBAL['tree_news_class'][$value['class_id']]['name'];
						$value['title']     = mb_substr($value['title'],0,18,'utf-8');						
					}
					$list[]       = $value;
				}
				ajax_list($list); //处理ajax
			}
			
			$multi = multi($count, $perpage, $page, get_current_url());
			echo template($template, get_defined_vars());
			die;
		}
		echo template('news', get_defined_vars());
		break;

	default:
		$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE display=1 AND LEFT(class_id, ".strlen($class_id).")='$class_id' ORDER BY id ASC LIMIT 1");
		$news   = $_TGLOBAL['db']->fetch_array($query);
		//$class_id = $news['class_id'];
		echo template($template, get_defined_vars());
		break;
}

?>