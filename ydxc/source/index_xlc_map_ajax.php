<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

if (empty($_SESSION['openid'])) {
	header("Location:/ydxc/index.php?do=getwxinfo"); 
	exit();
}


include_once $_SERVER['DOCUMENT_ROOT'] . '/l_wx/weixin.php';	
$wx = new Weixin_class();

$appId = "wx09e39aed7d3c3912";
$timeStamp = intval(time()/10);
$url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
$nonceStr = $wx->getRandChar(15);
$signature = $wx->get_js_signature($nonceStr, $timeStamp, $url);

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
		
} else if(!empty($tj)){
		$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=25 ");
	
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			//$value['img'] = getthumbimg($value['img']);
			$value['img'] = substr($value['img'],1);
			$newsshow[]       = $value;
		}
} else {
	
	$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id in (5,25)");
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		//$value['img'] = getthumbimg($value['img']);
		$value['img'] = substr($value['img'],1);
		$newsshow[]       = $value;
	}
}

if(!empty($id)){
	$cd_info  = $_TGLOBAL['db']->getrow("SELECT title,id,lng,lat,class_id,cd_address FROM ".tname('news')." WHERE id=".$id);
		
		$local = $_GET['loca'];
		$local_arr = explode(',', $local);
		$local_lat = $local_arr[0];
		$local_lng = $local_arr[1];
		
		$q = "http://api.map.baidu.com/geoconv/v1/?coords=".$local_lng.",".$local_lat."&from=1&to=5&ak=DBd897f58d7a63e585485e3dea011253";
		$result = json_decode(file_get_contents($q));
		
		$local_lng = $result->result[0]->x;
		$local_lat = $result->result[0]->y;
	//百度地图根据经纬度获取地址信息
//	$address_url = "http://api.map.baidu.com/geocoder/v2/?location=".$cd_info['lat'].",".$cd_info['lng']."&output=json&pois=1&ak=DBd897f58d7a63e585485e3dea011253";
//	$address = file_get_contents($address_url);
//	$address_arr = json_decode($address, true);
	
		$query1  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 and sscd=".$cd_info['id']);
		$coach = array();
		$coach1 = array();
		
		while ($value1 = $_TGLOBAL['db']->fetch_array($query1)) {
				$comment = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value1['id']);
				if(empty($comment)){
					$value1['avg'] = 0;
					$driving_api = 'http://api.map.baidu.com/routematrix/v2/driving?output=json&origins='.$local_lat.','.$local_lng.'&destinations='.$cd_info['lat'].','.$cd_info['lng'].'&ak=DBd897f58d7a63e585485e3dea011253';
					$driving = json_decode(file_get_contents($driving_api), true);
					$d_value = $driving['result'][0]['distance']['value'];
					$distance = round($d_value/1000,1);
					$value1['distance']=$distance;
					$value1['img'] = substr($value1['img'],1);
					$coach[]       = $value1;
				}
		}
		
		//位置排序
		 $sort = array(
		        'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
		        'field'     => 'distance',       //排序字段  
		 );  
		 $arrSort = array();  
		 foreach($coach AS $uniqid => $row){  
		     foreach($row AS $key=>$value2){  
		         $arrSort[$key][$uniqid] = $value2;  
		     }  
		 }  
		 if($sort['direction']){  
		     array_multisort($arrSort[$sort['field']], constant($sort['direction']), $coach);  
		 }
		 
		 $query2  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 and sscd=".$cd_info['id']);
		 while ($value2 = $_TGLOBAL['db']->fetch_array($query2)) {
				$comment1 = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value2['id']);
				if(!empty($comment1)){
					$driving_api2 = 'http://api.map.baidu.com/routematrix/v2/driving?output=json&origins='.$local_lat.','.$local_lng.'&destinations='.$cd_info['lat'].','.$cd_info['lng'].'&ak=DBd897f58d7a63e585485e3dea011253';
					$driving2 = json_decode(file_get_contents($driving_api2), true);
					$d_value2 = $driving2['result'][0]['distance']['value'];
					$distance2 = round($d_value2/1000,1);
					$value2['distance']=$distance2;
					$value2['img'] = substr($value2['img'],1);
					$total_sort1 = $_TGLOBAL['db']->getrow("select sum(sort1) as sort1 from ".tname('comment')." where cid=".$value2['id']);
					$total_count1 = $_TGLOBAL['db']->getrow("select count(*) as count from ".tname('comment')." where cid=".$value2['id']);
					$avg1 = round($total_sort1['sort1']/$total_count1['count']);
					$value2['avg'] = $avg1;
					$coach1[]       = $value2;
				}
		}
		
				//位置排序
		 $sort1 = array(
		        'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
		        'field'     => 'distance',       //排序字段  
		 );  
		 $arrSort1 = array();  
		 foreach($coach1 AS $uniqid1 => $row1){  
		     foreach($row1 AS $key1=>$value3){  
		         $arrSort1[$key1][$uniqid1] = $value3;  
		     }  
		 }  
		 if($sort1['direction']){  
		     array_multisort($arrSort1[$sort1['field']], constant($sort1['direction']), $coach1);  
		 }
		 $coach = array_merge($coach,$coach1);
}


echo template('xlc_map_ajax', get_defined_vars());
?>