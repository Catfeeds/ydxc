<?php
!defined('IN_CTB') && die('Access Denied');
$_TGLOBAL['tree_menu']=Array
	(
	1 => Array
		(
		'id' => '1',
		'pid' => '0',
		'mod' => 'system',
		'ac' => '',
		'name' => '系统管理',
		'is_hidden' => '0',
		'orderlist' => '10',
		'sort' => '0'
		),
	2 => Array
		(
		'id' => '2',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'admin',
		'name' => '管理首页',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	3 => Array
		(
		'id' => '3',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'setting',
		'name' => '系统设置',
		'is_hidden' => '0',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	5 => Array
		(
		'id' => '5',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'menu',
		'name' => '菜单管理',
		'is_hidden' => '0',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	6 => Array
		(
		'id' => '6',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'menu_work',
		'name' => '菜单添加/修改',
		'is_hidden' => '1',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	7 => Array
		(
		'id' => '7',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'password',
		'name' => '修改密码',
		'is_hidden' => '0',
		'orderlist' => '5',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	8 => Array
		(
		'id' => '8',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'role',
		'name' => '角色管理',
		'is_hidden' => '0',
		'orderlist' => '6',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	9 => Array
		(
		'id' => '9',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'role_work',
		'name' => '角色添加/修改',
		'is_hidden' => '1',
		'orderlist' => '7',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	10 => Array
		(
		'id' => '10',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'user',
		'name' => '系统管理员',
		'is_hidden' => '0',
		'orderlist' => '8',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	11 => Array
		(
		'id' => '11',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'user_work',
		'name' => '管理员添加/修改',
		'is_hidden' => '1',
		'orderlist' => '9',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	12 => Array
		(
		'id' => '12',
		'pid' => '1',
		'mod' => 'system',
		'ac' => 'logout',
		'name' => '退出系统',
		'is_hidden' => '1',
		'orderlist' => '10',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	13 => Array
		(
		'id' => '13',
		'pid' => '0',
		'mod' => 'member',
		'ac' => '',
		'name' => '会员管理',
		'is_hidden' => '1',
		'orderlist' => '20',
		'sort' => '0'
		),
	14 => Array
		(
		'id' => '14',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'list',
		'name' => '会员列表',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	16 => Array
		(
		'id' => '16',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'list_work',
		'name' => '会员添加/修改',
		'is_hidden' => '0',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	17 => Array
		(
		'id' => '17',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'group',
		'name' => '会员级别',
		'is_hidden' => '0',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	18 => Array
		(
		'id' => '18',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'group_add',
		'name' => '会员级别添加/修改',
		'is_hidden' => '1',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	19 => Array
		(
		'id' => '19',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'import',
		'name' => '批量导入',
		'is_hidden' => '0',
		'orderlist' => '5',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	20 => Array
		(
		'id' => '20',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'wxuser',
		'name' => '微信关注用户',
		'is_hidden' => '0',
		'orderlist' => '6',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	21 => Array
		(
		'id' => '21',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'money',
		'name' => '余额明细',
		'is_hidden' => '0',
		'orderlist' => '7',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	22 => Array
		(
		'id' => '22',
		'pid' => '13',
		'mod' => 'member',
		'ac' => 'money_add',
		'name' => '会员余额修改',
		'is_hidden' => '1',
		'orderlist' => '8',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	27 => Array
		(
		'id' => '27',
		'pid' => '0',
		'mod' => 'news',
		'ac' => '',
		'name' => '新闻管理',
		'is_hidden' => '0',
		'orderlist' => '30',
		'sort' => '0'
		),
	28 => Array
		(
		'id' => '28',
		'pid' => '27',
		'mod' => 'news',
		'ac' => 'li',
		'name' => '新闻管理',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	29 => Array
		(
		'id' => '29',
		'pid' => '27',
		'mod' => 'news',
		'ac' => 'add',
		'name' => '添加新闻',
		'is_hidden' => '0',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	30 => Array
		(
		'id' => '30',
		'pid' => '27',
		'mod' => 'news',
		'ac' => 'class',
		'name' => '栏目类别',
		'is_hidden' => '0',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	31 => Array
		(
		'id' => '31',
		'pid' => '27',
		'mod' => 'news',
		'ac' => 'class_work',
		'name' => '文章类别添加/修改',
		'is_hidden' => '1',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	88 => Array
		(
		'id' => '88',
		'pid' => '0',
		'mod' => 'daili',
		'ac' => '',
		'name' => '建议与投诉',
		'is_hidden' => '0',
		'orderlist' => '50',
		'sort' => '0'
		),
//	89 => Array
//		(
//		'id' => '89',
//		'pid' => '88',
//		'mod' => 'daili',
//		'ac' => 'init',
//		'name' => '代理信息',
//		'is_hidden' => '0',
//		'orderlist' => '0',
//		'sort' => '1',
//		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
//		),
	90 => Array
		(
		'id' => '90',
		'pid' => '88',
		'mod' => 'daili',
		'ac' => 'edit',
		'name' => '代理详情',
		'is_hidden' => '1',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	92 => Array
		(
		'id' => '92',
		'pid' => '88',
		'mod' => 'daili',
		'ac' => 'tousu',
		'name' => '投诉建议',
		'is_hidden' => '0',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	83 => Array
		(
		'id' => '83',
		'pid' => '0',
		'mod' => 'course',
		'ac' => '',
		'name' => '驾校班级',
		'is_hidden' => '0',
		'orderlist' => '50',
		'sort' => '0'
		),
	87 => Array
		(
		'id' => '87',
		'pid' => '83',
		'mod' => 'course',
		'ac' => 'sign',
		'name' => '报名信息',
		'is_hidden' => '0',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	86 => Array
		(
		'id' => '86',
		'pid' => '83',
		'mod' => 'course',
		'ac' => 'init_edit',
		'name' => '修改班级',
		'is_hidden' => '1',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	85 => Array
		(
		'id' => '85',
		'pid' => '83',
		'mod' => 'course',
		'ac' => 'init_add',
		'name' => '添加班级',
		'is_hidden' => '1',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	91 => Array
		(
		'id' => '91',
		'pid' => '83',
		'mod' => 'course',
		'ac' => 'sign_edit',
		'name' => '报名信息',
		'is_hidden' => '1',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	84 => Array
		(
		'id' => '84',
		'pid' => '83',
		'mod' => 'course',
		'ac' => 'init',
		'name' => '班级信息',
		'is_hidden' => '0',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	79 => Array
		(
		'id' => '79',
		'pid' => '0',
		'mod' => 'message',
		'ac' => '',
		'name' => '信息管理',
		'is_hidden' => '1',
		'orderlist' => '50',
		'sort' => '0'
		),
	80 => Array
		(
		'id' => '80',
		'pid' => '79',
		'mod' => 'message',
		'ac' => 'li',
		'name' => '信息管理',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	55 => Array
		(
		'id' => '55',
		'pid' => '0',
		'mod' => 'weixin',
		'ac' => '',
		'name' => '公众号管理',
		'is_hidden' => '0',
		'orderlist' => '90',
		'sort' => '0'
		),
	56 => Array
		(
		'id' => '56',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'text',
		'name' => '文本回复',
		'is_hidden' => '1',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	57 => Array
		(
		'id' => '57',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'text_add',
		'name' => '文本回复添加/修改',
		'is_hidden' => '1',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	58 => Array
		(
		'id' => '58',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'image',
		'name' => '图片回复',
		'is_hidden' => '1',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	59 => Array
		(
		'id' => '59',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'image_add',
		'name' => '图片回复添加修改',
		'is_hidden' => '1',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	60 => Array
		(
		'id' => '60',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'voice',
		'name' => '语音回复',
		'is_hidden' => '1',
		'orderlist' => '5',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	61 => Array
		(
		'id' => '61',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'voice_add',
		'name' => '语音回复添加/修改',
		'is_hidden' => '1',
		'orderlist' => '6',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	62 => Array
		(
		'id' => '62',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'news',
		'name' => '图文回复',
		'is_hidden' => '1',
		'orderlist' => '7',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	63 => Array
		(
		'id' => '63',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'news_add',
		'name' => '添加新图文',
		'is_hidden' => '1',
		'orderlist' => '8',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	64 => Array
		(
		'id' => '64',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'class',
		'name' => '自定义菜单',
		'is_hidden' => '0',
		'orderlist' => '9',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	65 => Array
		(
		'id' => '65',
		'pid' => '55',
		'mod' => 'weixin',
		'ac' => 'class_work',
		'name' => '微信菜单添加/修改',
		'is_hidden' => '1',
		'orderlist' => '10',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	73 => Array
		(
		'id' => '73',
		'pid' => '0',
		'mod' => 'db',
		'ac' => '',
		'name' => '数据库管理',
		'is_hidden' => '0',
		'orderlist' => '100',
		'sort' => '0'
		),
	74 => Array
		(
		'id' => '74',
		'pid' => '73',
		'mod' => 'db',
		'ac' => 'bak',
		'name' => '数据库备份',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	75 => Array
		(
		'id' => '75',
		'pid' => '73',
		'mod' => 'db',
		'ac' => 'store',
		'name' => '数据库恢复',
		'is_hidden' => '0',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	76 => Array
		(
		'id' => '76',
		'pid' => '73',
		'mod' => 'db',
		'ac' => 'optimize',
		'name' => '数据库优化',
		'is_hidden' => '0',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	77 => Array
		(
		'id' => '77',
		'pid' => '73',
		'mod' => 'db',
		'ac' => 'update',
		'name' => '数据库升级',
		'is_hidden' => '0',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	78 => Array
		(
		'id' => '78',
		'pid' => '73',
		'mod' => 'db',
		'ac' => 'test',
		'name' => '数据库测试',
		'is_hidden' => '0',
		'orderlist' => '5',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	66 => Array
		(
		'id' => '66',
		'pid' => '0',
		'mod' => 'other',
		'ac' => '',
		'name' => '其他管理',
		'is_hidden' => '0',
		'orderlist' => '110',
		'sort' => '0'
		),
	82 => Array
		(
		'id' => '82',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'banner_add',
		'name' => '添加/修改焦点图',
		'is_hidden' => '1',
		'orderlist' => '0',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	81 => Array
		(
		'id' => '81',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'banner',
		'name' => '焦点图管理',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	67 => Array
		(
		'id' => '67',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'crons',
		'name' => '计划任务',
		'is_hidden' => '0',
		'orderlist' => '1',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	68 => Array
		(
		'id' => '68',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'link',
		'name' => '友情链接',
		'is_hidden' => '0',
		'orderlist' => '2',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	69 => Array
		(
		'id' => '69',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'crons_work',
		'name' => '计划任务添加/修改',
		'is_hidden' => '1',
		'orderlist' => '3',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	70 => Array
		(
		'id' => '70',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'adminlog',
		'name' => '管理员日志',
		'is_hidden' => '0',
		'orderlist' => '4',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	71 => Array
		(
		'id' => '71',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'syslog',
		'name' => '系统日志',
		'is_hidden' => '0',
		'orderlist' => '5',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		),
	72 => Array
		(
		'id' => '72',
		'pid' => '66',
		'mod' => 'other',
		'ac' => 'cache',
		'name' => '更新缓存',
		'is_hidden' => '0',
		'orderlist' => '6',
		'sort' => '1',
		'html' => '&nbsp;&nbsp;&nbsp;&nbsp;|---'
		)
	)
?>