<?php
/**********************************\
提取指定类别的新闻数据
参数：
type:类型，
	其他：文章列表
	descript：显示图片，详细
	image:显示图片
		height:图片高度
		width:图片宽度
		istext：是否显示标题文字,默认yes，显示
classid：要提取的分类classid
rows:需要提取的行数
order：排序方法，desc或asc ,默认desc
orderfield:需要排序的字段，默认id
len:标题长度
pre:前缀
predate:前缀显示日期
flag:显示推荐
\**********************************/

function smarty_function_getarticle($params,&$Smarty)
{
	global $_TGLOBAL;
	
	@extract($params);
	$where = " WHERE display=1 ";
	$classid  && $where .= " AND class_id LIKE '$classid%' ";
	
	if ($flag) { //处理多值
		$ary_tag = @split(",",$flag);
		foreach($ary_tag AS $val) {
			$where .= " AND FIND_IN_SET('{$val}',flag)>0 ";
		}
	}

	if ($noflag) { //处理多值
		$ary_tag = @split(",",$noflag);
		foreach($ary_tag AS $val) {
			 $where .= " AND NOT FIND_IN_SET('{$val}',flag)>0 ";
		}
	}
	
	!$rows       && $rows       = 10;
	!$start      && $start      = 0;
	!$order      && $order      = " DESC ";
	!$orderfield && $orderfield = "displayorder";
	!$len        && $len        = 60;
	
	//但不为id排序时,在排序后再加上按id排倒序
	$orderfield != "id" && $order .= " , id DESC";

	//当为图片时
	($type == 'img' || $type == 'fcousimg' || $type == 'midimg3' || $type == 'pimg' || $type == 'p2img') &&  $where .= " AND img <> '' ";

	($type == 'descript') &&  $orderfield = 'img';

	$sql = "SELECT id, title, class_id, date, img, content, readno FROM ".tname('news')." $where ORDER BY $orderfield $order limit $start,$rows";
	$query = $_TGLOBAL['db']->query($sql);

	switch($type){

		case "img" : //资讯首页图片
			while ($value = $_TGLOBAL['db']->fetch_array($query)) {
				$value['title'] = htmlspecialchars($value['title']);		
				$title    = getstr($value['title'], $len);
				$img      = getthumbimg($value['img']); //得到图片的缩略图

				$returnStr .= "<div class=\"pic\"> <a href=\"index.php?do=newsshow&id=$value[id]\"><img src=\"$img\" width=\"137\" height=\"132\" /></a> <a href=\"index.php?do=newsshow&id=$value[id]\">$value[title]</a> </div>\n";
			}
			break;        

		case "fcousimg" : //焦点图
				$comma = $pics = $links = $texts = '';
				while ($value = $_TGLOBAL['db']->fetch_array($query)) {			
				   $value['title'] = htmlspecialchars($value['title']);
				   $pics    .= $comma . str_replace('../', '', $value['img']);
				   $links   .= $comma . 'index.php?id='.$value['id'];
				   $texts   .= $comma . $value['title'];
				   $comma    = '|';
				}

				!$width  && $width  = 260;
				!$height && $height = 240;
				$rnd = random(5); //产生随机的，使焦点图ID不相同

				$returnStr .= "<div id=\"flashcontent_$rnd\">\n";
				$returnStr .= "<script type=\"text/javascript\">\n";
				$returnStr .= "var speed = 4000;\n";
				$returnStr .= "var pics='$pics';\n";
				$returnStr .= "var mylinks='$links';\n";
				$returnStr .= "var texts='$texts';\n";		
				$returnStr .= "var sohuFlash2 = new sohuFlash(\"image/focus.swf\",\"flashcontent01\",\"$width\",\"$height\",\"8\",\"#ffffff\");\n";
				$returnStr .= "sohuFlash2.addParam(\"quality\", \"medium\");\n";
				$returnStr .= "sohuFlash2.addParam(\"wmode\", \"opaque\");\n";
				$returnStr .= "sohuFlash2.addVariable(\"speed\",speed);\n";
				$returnStr .= "sohuFlash2.addVariable(\"p\",pics);\n";
				$returnStr .= "sohuFlash2.addVariable(\"l\",mylinks);\n";
				$returnStr .= "sohuFlash2.addVariable(\"icon\",texts);\n";
				$returnStr .= "sohuFlash2.write(\"flashcontent_$rnd\");\n";
				$returnStr .= "</script>\n";
				$returnStr .= "</div>\n";
				break;    

		default:	
			while ($value = $_TGLOBAL['db']->fetch_array($query)) {
				$value['title'] = htmlspecialchars($value['title']);
				$title      = getstr($value['title'], $len);
				$returnStr .= "<p>";
				$returnStr .= ($predate ? '<span>'.date('Y-m-d', $value['date']).'</span>' : '');	
				$returnStr .= $pre ? $pre : '&nbsp;';
				$returnStr .= "<a href=\"index.php?do=newsshow&id=$value[id]\" title=\"$value[title]\">$title</a>\n";
				$returnStr .= "</p>";
			}
			break;
	}
	return $returnStr;
}
?>