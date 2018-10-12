<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");

		$local = $_GET['loca'];
		$local_arr = explode(',', $local);
		$local_lat = $local_arr[0];
		$local_lng = $local_arr[1];
		
		$q = "http://api.map.baidu.com/geoconv/v1/?coords=".$local_lng.",".$local_lat."&from=1&to=5&ak=DBd897f58d7a63e585485e3dea011253";
		$result = json_decode(file_get_contents($q));
		
		$local_lng = $result->result[0]->x;
		$local_lat = $result->result[0]->y;

$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 ORDER BY id DESC");
$coaches = array();
$coaches1 = array();
while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	
	$comment = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value['id']);
	
	if(empty($comment)){
		$value['avg'] = '0';
		$value['img'] = substr($value['img'],1);
		$cd_info = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value['sscd']);
		
		$driving_api = 'http://api.map.baidu.com/routematrix/v2/driving?output=json&origins='.$local_lat.','.$local_lng.'&destinations='.$cd_info['lat'].','.$cd_info['lng'].'&ak=DBd897f58d7a63e585485e3dea011253';
		$driving = json_decode(file_get_contents($driving_api), true);
		$d_value = $driving['result'][0]['distance']['value'];
		$distance = round($d_value/1000,1);
		$value['distance']=$distance;

		$value['sscd'] = $cd_info['title'];
		$coaches[]       = $value;
	}
}

		//位置排序
		 $sort = array(
		        'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
		        'field'     => 'distance',       //排序字段  
		 );  
		 $arrSort = array();  
		 foreach($coaches AS $uniqid => $row){  
		     foreach($row AS $key=>$value2){  
		         $arrSort[$key][$uniqid] = $value2;  
		     }  
		 }  
		 if($sort['direction']){  
		     array_multisort($arrSort[$sort['field']], constant($sort['direction']), $coaches);  
		 }

$query1 = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE class_id=3 and display=1 ORDER BY id DESC");
while ($value1 = $_TGLOBAL['db']->fetch_array($query1)) {
	$comment1 = $_TGLOBAL['db']->getrow("select * from ".tname('comment')." where cid=".$value1['id']);
	if(!empty($comment1)){
		$value1['img'] = substr($value1['img'],1);
		$cd_info1 = $_TGLOBAL['db']->getrow("select * from ".tname('news')." where id=".$value1['sscd']);
		
		$driving_api1 = 'http://api.map.baidu.com/routematrix/v2/driving?output=json&origins='.$local_lat.','.$local_lng.'&destinations='.$cd_info1['lat'].','.$cd_info1['lng'].'&ak=DBd897f58d7a63e585485e3dea011253';
		$driving1 = json_decode(file_get_contents($driving_api1), true);
		$d_value1 = $driving1['result'][0]['distance']['value'];
		$distance1 = round($d_value1/1000,1);
		$value1['distance']=$distance1;
		
		
		$value1['sscd'] = $cd_info1['title'];
		
		$total_sort1 = $_TGLOBAL['db']->getrow("select sum(sort1) as sort1 from ".tname('comment')." where cid=".$value1['id']);
		$total_count1 = $_TGLOBAL['db']->getrow("select count(*) as count from ".tname('comment')." where cid=".$value1['id']);
		$avg1 = round($total_sort1['sort1']/$total_count1['count']);
		$value1['avg'] = $avg1;
		$coaches1[] = $value1;
	}
}

		//位置排序
		 $sort1 = array(
		        'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序  
		        'field'     => 'distance',       //排序字段  
		 );  
		 $arrSort1 = array();  
		 foreach($coaches1 AS $uniqid1 => $row1){  
		     foreach($row1 AS $key1=>$value3){  
		         $arrSort1[$key1][$uniqid1] = $value3;  
		     }  
		 }  
		 if($sort1['direction']){  
		     array_multisort($arrSort1[$sort1['field']], constant($sort1['direction']), $coaches1);  
		 }
//追加到教练无评分数组之后
$coaches = array_merge($coaches,$coaches1);
echo json_encode($coaches,JSON_UNESCAPED_UNICODE);
exit;
?>
