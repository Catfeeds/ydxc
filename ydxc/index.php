<?php




//通用文件
header("Content-Type: text/html; charset=UTF-8");
include_once('./common.php');


//允许的方法
$dos = array('index', 'intro', 'newshow',
			 'daili', 'baoming', 
			 'shipin', 'jiaxiao', 'xieyi', 'xuzhi', 'huodong', 'yuyue', 'fukuan','tousu',
			 'coach_details','enlist','enlist_details','coach_list','enlist_order','xlc_map',
			 'center','go','physical','source','tj_code_apply','partner','comment','pay','new_detail','getwxinfo',
			 'myewm','comment_submit','advise','update_order_status',"update_tjorder_status","my_order","my_news",
			 'physical_pay_success','physical_pay_fail','enlist_pay_success','enlist_pay_fail',"my_tj_code",
			 'xlc_map_ajax','coach_confirm','my_setting','setting_submit','coach_change','k2_msg','pxxy','test_pay',
			 'dc_sign','dc_captain','dc_tijian','dc_tjcheck','dc_coach','dc_cd','dc_tjz','dc_kemu3','coach_list_ajax','good_coach_ajax'
			 );

$do = (empty($_GET['do']) || !in_array($_GET['do'], $dos)) ? 'index' : $_GET['do'];
$op = empty($_GET['op']) ? '' : $_GET['op'];

//是否关闭站点
checkclose();

/*
foreach($_TGLOBAL['tree_news_class'] as $key=>$val){
	if($val['pid']==0){
		echo $val['name'];
		foreach($_TGLOBAL['tree_news_class'] as $k=>$v){
			if($v['pid']==$val['id']){
				echo $v['name'];
			}
		}
		
	}
}*/
//var_dump($_TGLOBAL['tree_news_class']);
//var_dump(tree($_TGLOBAL['tree_news_class'],0,1));

//焦点图
if(iswap()){
	$bannreflag = 2;
}else{
	$bannreflag = 1;
}
$query = $_TGLOBAL['db']->query("SELECT img, link FROM ".tname('banner')." WHERE flag=$bannreflag ORDER BY id DESC LIMIT 0,10");
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	//$value['img'] = getthumbimg($value['img']);
	$value['img'] = substr($value['img'],1);
	$banners[]       = $value;
}
include_once(S_ROOT.'./source/index_'.$do.'.php');

