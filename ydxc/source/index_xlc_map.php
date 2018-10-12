<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

//if (empty($_SESSION['openid'])) {
//	header("Location:/ydxc/index.php?do=getwxinfo");
//	exit();
//}

include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';

$wx = new Weixin_class();

$appId = "wx09e39aed7d3c3912";
$timeStamp = intval(time()/10);
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
//$nonceStr = $wx->getRandChar(15);
//$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);

$k = $_REQUEST['k'];  //科目按钮
$id = $_REQUEST['id'];//场地图片
$p = $_REQUEST['p'];	 //查看全部
$tj = $_REQUEST['tj']; //体检按钮
if(!empty($k)){
	
		
		$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=5 and display=1 "."and kemu=".$k);
	
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			//$value['img'] = getthumbimg($value['img']);
			$value['img'] = substr($value['img'],1);
			$newsshow[]       = $value;
		}
		
		$openid = $_SESSION['openid'];
		$wx_user = $_TGLOBAL['db']->getrow("select card_id from ".tname('wx_user')." where openid='$openid'");
		$card_id = $wx_user['card_id'];
		if(!empty($card_id)){
			//更新学员科目状态
			$url = "https://www.122erp.com/Json/Json/GetStudentList/?CGUID=E1D9EEC7-5074-4F57-A990-8A7443B12BF0&sfzmhm=$card_id";
			$data = file_get_contents($url);
			$data = stripslashes($data);
			$data = trim($data,"(");
			$data = trim($data,")");
			$data = trim($data,'"');
			$de_data = json_decode($data,true);
			$km2 = $de_data['Data'][0]['Km2'];  //科目2    2:合格  3:不合格
			$km3 = $de_data['Data'][0]['Km3'];  //科目3    2:合格  3:不合格
			$where = array('openid'=>$openid);
			$updt = array('k2_status'=>$km2,'k3_status'=>$km3);
			updatetable('wx_user',$updt,$where);
			//$km3 = $de_data['Data'][0]['Km3'];  //科目3
		}
		
} else if(!empty($tj)){
		$cd_id = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news_class')." WHERE pid=24 ");
		
		//拼接成(xx,xx,xx,xx);好查询数据库 in 语句
		for($i=0;$i<count($cd_id);$i++){
			if($i==(count($cd_id)-1)){
				$cdid .= $cd_id[$i]['id'];
			} else {
				$cdid .= $cd_id[$i]['id'].",";
			}
		}
		$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id in($cdid) and display=1");
	
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			//$value['img'] = getthumbimg($value['img']);
			$value['img'] = substr($value['img'],1);
			$newsshow[]       = $value;
		}
} else {
	$cd_id = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('news_class')." WHERE pid=24 ");
		
		//拼接成(xx,xx,xx,xx);好查询数据库 in 语句
		for($i=0;$i<count($cd_id);$i++){
			if($i==(count($cd_id)-1)){
				$cdid .= $cd_id[$i]['id'];
			} else {
				$cdid .= $cd_id[$i]['id'].",";
			}
		}
	
	$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id in (5,$cdid) and display=1");
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		//$value['img'] = getthumbimg($value['img']);
		$value['img'] = substr($value['img'],1);
		$newsshow[]       = $value;
	}
}

if(!empty($id)){
	$cd_info  = $_TGLOBAL['db']->getrow("SELECT title,id,lng,lat,class_id FROM ".tname('news')." WHERE id=".$id);
	
	//百度地图根据经纬度获取地址信息
	$address_url = "http://api.map.baidu.com/geocoder/v2/?location=".$cd_info['lat'].",".$cd_info['lng']."&output=json&pois=1&ak=DBd897f58d7a63e585485e3dea011253";
	$address = file_get_contents($address_url);
	$address_arr = json_decode($address, true);
	
		$query1  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 and sscd=".$cd_info['id']);
	
		while ($value1 = $_TGLOBAL['db']->fetch_array($query1)) {
			$value1['img'] = substr($value1['img'],1);
			$coach[]       = $value1;
		}
	
}
echo template('field', get_defined_vars());
?>