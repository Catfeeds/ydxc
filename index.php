<?php

include_once './global.php';
//保存openid
$_SESSION['openid'] = $_REQUEST['openid'];

/*if (!empty($_REQUEST['openid'])) {
	header("Location: /client/index.html"); 
} else {
	header("Location: /client/tip.html"); 
}*/


define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);//网站根目录
include_once ROOT_PATH . '/system/system.php';
include_once ROOT_PATH . '/l_db/drive/mysql.class.php';
include_once ROOT_PATH . '/l_db/config/database.php';
$db = DB::getDBClass();

$db->where(array('id'=>rand(300000,400000)));
var_dump($db->select('user'));
/*
for($i=0; $i <= 100000; $i++) {
	$name = time();
	$db->add('user', array('name'=>$name, 'ps'=>1000));
	echo $name ." 添加成功！<br/>";
}*/

//phpinfo();
$redis = new redis();//实例化redis类
    $redis -> connect('127.0.0.1',6379);//redis连接，这里127.0.0.1是本地服务器，因为该php文件和所连的redis数据库同在一台主机上，6379是redis的默认端口，可以省略
    $redis -> set('name','lsgogroup');//设置缓存值
    $redis -> get('name');//获取缓存值
    $reids -> setex('name',3600,'lsgogroup');//设置缓存值得有效时间为1小时
    $redis -> del('name');//手动删除缓存
?>
