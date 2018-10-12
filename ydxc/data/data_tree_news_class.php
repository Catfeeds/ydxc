<?php
!defined('IN_CTB') && die('Access Denied');
$_TGLOBAL['tree_news_class']=Array
	(
	1 => Array
		(
		'id' => '1',
		'name' => '关于我们',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	2 => Array
		(
		'id' => '2',
		'name' => '公司简介',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '1',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	3 => Array
		(
		'id' => '3',
		'name' => '教练信息',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_pic',
		'pid' => '1',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	19 => Array
		(
		'id' => '19',
		'name' => '新闻中心',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_news',
		'pid' => '1',
		'is_hidden' => '1',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	20 => Array
		(
		'id' => '20',
		'name' => '行业动态',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_news',
		'pid' => '19',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '2',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	21 => Array
		(
		'id' => '21',
		'name' => '最新公告',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_news',
		'pid' => '19',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '2',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	23 => Array
		(
		'id' => '23',
		'name' => '媒体报道',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_news',
		'pid' => '19',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '2',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	22 => Array
		(
		'id' => '22',
		'name' => '代理中心',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => 'index.php?do=daili',
		'template' => '',
		'pid' => '1',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	4 => Array
		(
		'id' => '4',
		'name' => '场地实景',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_pic',
		'pid' => '0',
		'is_hidden' => '1',
		'isnew' => '0',
		'sort' => '0'
		),
	5 => Array
		(
		'id' => '5',
		'name' => '场地信息',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'list_pic',
		'pid' => '4',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	28 => Array
		(
		'id' => '28',
		'name' => '培训协议',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	8 => Array
		(
		'id' => '8',
		'name' => '班级类型',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '0'
		),
	9 => Array
		(
		'id' => '9',
		'name' => '品质班',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '8',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	11 => Array
		(
		'id' => '11',
		'name' => '实惠班',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '8',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	27 => Array
		(
		'id' => '27',
		'name' => '包过班',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '8',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	42 => Array
		(
		'id' => '42',
		'name' => '计时底价班',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '8',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	13 => Array
		(
		'id' => '13',
		'name' => '我要报名',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	14 => Array
		(
		'id' => '14',
		'name' => '我要报名',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => 'index.php?do=baoming',
		'template' => 'intro',
		'pid' => '13',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	15 => Array
		(
		'id' => '15',
		'name' => '联系我们',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '13',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	16 => Array
		(
		'id' => '16',
		'name' => '学员中心',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	17 => Array
		(
		'id' => '17',
		'name' => '模拟中心',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => 'intro',
		'pid' => '16',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	24 => Array
		(
		'id' => '24',
		'name' => '体检机构',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	25 => Array
		(
		'id' => '25',
		'name' => '红十字协会',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '24',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	26 => Array
		(
		'id' => '26',
		'name' => '建设医院',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '24',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	29 => Array
		(
		'id' => '29',
		'name' => '陈家桥医院',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '24',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	30 => Array
		(
		'id' => '30',
		'name' => '红十字北碚',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '24',
		'is_hidden' => '0',
		'isnew' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	37 => Array
		(
		'id' => '37',
		'name' => '管理员分类',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '0',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '0'
		),
	38 => Array
		(
		'id' => '38',
		'name' => '合伙人申请管理员',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '37',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	39 => Array
		(
		'id' => '39',
		'name' => '体检码管理员',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '37',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	40 => Array
		(
		'id' => '40',
		'name' => '更换教练管理员',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '37',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	41 => Array
		(
		'id' => '41',
		'name' => '投诉建议管理员',
		'class_id' => '',
		'orderlist' => '0',
		'jumpto' => '',
		'template' => '',
		'pid' => '37',
		'is_hidden' => '0',
		'isnew' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		)
	)
?>