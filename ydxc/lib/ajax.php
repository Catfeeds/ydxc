<?php
/*
	[CTB] (C) 2007-2009
	$Id: xml.php 2010-1-12 16:35:11 jerry $
*/

//通用文件
include_once('../common.php');
include_once(S_ROOT . './source/function_xml.php');

//允许的方法
$dos = array('news', 'comment', 'commentlist', 'zone_list', 'job_class', 'chkusername');

$do = (empty($_GET['ac']) || !in_array($_GET['ac'], $dos)) ? '' : $_GET['ac'];
$op = empty($_GET['op']) ? '' : $_GET['op'];
$class_id = $_GET['class_id'];

!$do && die('Access Denied');

switch($do) {


	case 'comment':
		//登录判断
		if(empty($_TGLOBAL['ctb_uid'])) {
			echo siconv('Error：你必须登录后，才能进行此操作','utf-8','gbk');
			exit;
		}

		if ($return = checkbadwords(siconv($_POST['content'],'gbk','utf-8'))) {
			echo siconv('Error：'.cplang('post_content_bad', array($return)),'utf-8','gbk');
			exit;
		}

		//添加评论
		$commentarr = array(
				'class_name'       => 	siconv($_POST['class_name'],'gbk','utf-8'),
				'itemid'           => 	$_POST['itemid'],
				'title'            => 	siconv($_POST['title'],'gbk','utf-8'),
				'content'          => 	strip_tags(siconv($_POST['content'],'gbk','utf-8')),
				'posttime'         => 	$_TGLOBAL['timestamp'],
				'userid'           => 	$_TGLOBAL['ctb_uid'],
				'username'         => 	siconv($_TGLOBAL['ctb_username'],'gbk','utf-8'),
				'visible'          => 	1,
				'ipaddress'        => 	getonlineip(),
				'notify'           => 	$_POST['notify'],
				'email'            => 	$_POST['email']
				);
		inserttable('comment', $commentarr);		
		echo @(int)getcount('comment', array('class_name'=>$_POST['class_name'], 'itemid'=>$_POST['itemid'], 'visible'=>1));
		break;

	case 'commentlist': //音乐详细页面右边的评论
		$id = @(int)$_GET['itemid'];
		$perpage = 4;
		$page    = empty($_GET['page']) ? 0 : intval($_GET['page']);
		$page<1 && $page = 1;
		$start   = ($page-1)*$perpage;
		//检查开始数
		ckstart($start, $perpage);
		$class_name = siconv($_GET['class_name'],'gbk','utf-8');
		$wheresql = "WHERE visible=1 AND class_name='$class_name' AND itemid='$id'";
		$count    = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('comment')." $wheresql"), 0);
		$return   = '';
		if($count) {
			$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('comment')." $wheresql ORDER BY id DESC LIMIT $start,$perpage");
			while ($value = $_TGLOBAL['db']->fetch_array($query)) {
				$value['posttime'] = date("Y-m-d H:i", $value['posttime']);
				!$value['username'] && $value['username'] = '匿名';
				$value['username'] = $value['username'];
				$value['content']  = nl2br($value['content']);

				$return .= "<DIV class=decmt-box>\n";
				$return .= "<DIV class=decmt-title>\n";
				$return .= "<SPAN class=username>· $value[username] 网友</SPAN> <SPAN class=date>$value[posttime]</SPAN> <SPAN>发表</SPAN> </DIV>\n";
				$return .= "<DIV class=decmt-act></DIV>\n";
				$return .= "<DIV class=decmt-content>\n";
				$return .= "<DIV class=new>$value[content]</DIV></DIV></DIV>\n";

			}
		}
		$_TGLOBAL['inajax'] = 1; //显示ajax分页
		$multi = smulti($count, $perpage, $page, get_current_url());
		!$return && $return = '<li>暂无评论</li>';
		$return .= "<div class=\"page\">$multi</div>\n";
		echo escape($return);
		break;

	case 'zone_list':
		//显示地区多级联动
		$last_class_id = $_GET['last_class_id']; //一级类别
		$class_id = $_GET['class_id'];
		if (!$last_class_id) break;
		$str = '<select name="work_areas" id="work_areas" ';
		$op == 'getcity' && $str .= ' onchange = "getcity();"';
		$str .= 'class="sel">'."\n";	
		$str .= "<option value=\"\">".escape('请选择')."</option>\n";
		$len = strlen($last_class_id);
		foreach($_TGLOBAL['class_zone'] AS $class_key => $class) {
			if (substr($class_key, 0, $len) == $last_class_id && strlen($class_key) != $len) {

				$class['name'] = escape($class['name']);
				$str .= "<option value=\"$class_key\"";
				$class_id == $class_key && $str .= ' selected="selected"';
				$str .=">$class[name]</option>\n";
			}
		}
		$str .= '</select>'."\n";
		echo $str;
		break;

	case 'job_class':
		//职位类别
		$last_class_id = $_GET['last_class_id']; //一级类别
		if (!$last_class_id) break;
		$str = '<select name="class_id" id="class_id" class="sel">'."\n";
		$str .= "<option value=\"\">".escape('类别不限')."</option>\n";
		$len = strlen($last_class_id);
		foreach($_TGLOBAL['job_class'] AS $class_key => $class) {
			if (substr($class_key, 0, $len) == $last_class_id && strlen($class_key) != $len) {

				$class['name'] = escape($class['name']);
				$str .= "<option value=\"$class_key\"";
				$class_id == $class_key && $str .= ' selected="selected"';
				$str .=">$class[name]</option>\n";
			}
		}
		$str .= '</select>'."\n";
		echo $str;
		break;

	case 'chkusername': //检验用户名
		$username   = $_GET['username'] ? $_GET['username'] : $_GET['username'];
		$username   = siconv($username,'gbk','utf-8');
		//判断此username是否已经注册
		$query = $_TGLOBAL['db']->query('SELECT NULL FROM '.tname('members') . " WHERE username ='$username'");
		if ($_TGLOBAL['db']->fetch_array($query)) {
			echo 0;
		} else {
			echo 1;
		}
		break;
		
		
}

?>