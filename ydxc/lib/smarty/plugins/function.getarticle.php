<?php
/**********************************\
��ȡָ��������������
������
type:���ͣ�
	�����������б�
	descript����ʾͼƬ����ϸ
	image:��ʾͼƬ
		height:ͼƬ�߶�
		width:ͼƬ���
		istext���Ƿ���ʾ��������,Ĭ��yes����ʾ
classid��Ҫ��ȡ�ķ���classid
rows:��Ҫ��ȡ������
order�����򷽷���desc��asc ,Ĭ��desc
orderfield:��Ҫ������ֶΣ�Ĭ��id
len:���ⳤ��
pre:ǰ׺
predate:ǰ׺��ʾ����
flag:��ʾ�Ƽ�
\**********************************/

function smarty_function_getarticle($params,&$Smarty)
{
	global $_TGLOBAL;
	
	@extract($params);
	$where = " WHERE display=1 ";
	$classid  && $where .= " AND class_id LIKE '$classid%' ";
	
	if ($flag) { //�����ֵ
		$ary_tag = @split(",",$flag);
		foreach($ary_tag AS $val) {
			$where .= " AND FIND_IN_SET('{$val}',flag)>0 ";
		}
	}

	if ($noflag) { //�����ֵ
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
	
	//����Ϊid����ʱ,��������ټ��ϰ�id�ŵ���
	$orderfield != "id" && $order .= " , id DESC";

	//��ΪͼƬʱ
	($type == 'img' || $type == 'fcousimg' || $type == 'midimg3' || $type == 'pimg' || $type == 'p2img') &&  $where .= " AND img <> '' ";

	($type == 'descript') &&  $orderfield = 'img';

	$sql = "SELECT id, title, class_id, date, img, content, readno FROM ".tname('news')." $where ORDER BY $orderfield $order limit $start,$rows";
	$query = $_TGLOBAL['db']->query($sql);

	switch($type){

		case "img" : //��Ѷ��ҳͼƬ
			while ($value = $_TGLOBAL['db']->fetch_array($query)) {
				$value['title'] = htmlspecialchars($value['title']);		
				$title    = getstr($value['title'], $len);
				$img      = getthumbimg($value['img']); //�õ�ͼƬ������ͼ

				$returnStr .= "<div class=\"pic\"> <a href=\"index.php?do=newsshow&id=$value[id]\"><img src=\"$img\" width=\"137\" height=\"132\" /></a> <a href=\"index.php?do=newsshow&id=$value[id]\">$value[title]</a> </div>\n";
			}
			break;        

		case "fcousimg" : //����ͼ
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
				$rnd = random(5); //��������ģ�ʹ����ͼID����ͬ

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