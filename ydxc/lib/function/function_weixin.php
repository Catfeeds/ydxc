<?php 
//POST提交
function weixin_post($url, $data=''){
	$ch = curl_init(); 
	$header = "Accept-Charset: utf-8"; 


/*
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// post数据
curl_setopt($ch, CURLOPT_POST, 1);
// post的变量
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
$output = curl_exec($ch);
curl_close($ch);
*/


	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
	//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
	$tmpInfo = curl_exec($ch); 
	return $tmpInfo;
	//var_dump($tmpInfo);  
	if (curl_errno($ch)) {  
		return false;
	}else{
		// var_dump($tmpInfo);  
		return true;
	}
}

//POST生成微信菜单
function weixin_mekemenu() {
	global $_TCONFIG,$_TGLOBAL;
	
	$ACCESS_TOKEN = weixin_access_token();

/*
	//从类别生成json数据 start
	$data = '{
	 
	 "button":[
		 {	
			  "type":"click",
			  "name":"中国",
			  "key":"get_password"
		  },
		  {
			   "type":"click",
			   "name":"日本人",
			   "key":"lock_acount"
		  },
		  {
			   "type":"click",
			   "name":"33",
			   "key":"unlock_acount"
		  }]
	 }';*/
	 //从类别生成json数据 end 

	//$arymenu['button'] = 	getclasscotesub('', 'weixin_class');
	$arymenu['button'] = 	get_menu($_TGLOBAL['tree_weixin_class'],0);
	//$data = JSON($arymenu);
	
	$data = json_encode($arymenu, JSON_UNESCAPED_UNICODE); 

	$url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token={$ACCESS_TOKEN}"; 
	$return = weixin_post($url, $data);
	$ary = json_decode($return);
	return ($ary);
 }
 
 
/*
* 按次序得到树状数组
* $level 层数
*/
function get_menu($arr, $myid){	
	global $_TCONFIG,$_TGLOBAL;
    foreach ($arr as $key=>$val) {			
		if($val['pid'] == $myid){
			$return[] = array(
						'type'	   => $val['type'],
						'name'     => $val['name'],
						'key'	   => $key,
						'url'	   => $val['jumpto'],
						'sub_button'     => get_menu($arr, $val['id']),
						);
		}
    }
    return $return;
}
 
 
 //获取https的get请求结果  
function getData($c_url)  {  
    $curl = curl_init(); // 启动一个CURL会话  
    curl_setopt($curl, CURLOPT_URL, $c_url); // 要访问的地址  
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查  
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1); // 从证书中检查SSL加密算法是否存在  
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器  
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer  
//    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求  
//    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包  
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
    $tmpInfo = curl_exec($curl); // 执行操作  
    if (curl_errno($curl)) {  
       echo 'Errno'.curl_error($curl);//捕抓异常  
    }  
    curl_close($curl); // 关闭CURL会话  
    return $tmpInfo; // 返回数据  
}  

//POST发送客服消息 只能发送文本信息
//openid 发送的用户微信openid  msg 发送的内容 
function weixin_sendmessage($openid, $msg) {
	global $_TCONFIG;
	
	if (!$openid || !$msg) return;

	$ACCESS_TOKEN = weixin_access_token();

	$data = 	"{
				\"touser\":\"$openid\",
				\"msgtype\":\"text\",
				\"text\":
				{
					 \"content\":\"$msg\"
				}
			}";

	$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$ACCESS_TOKEN}"; 
	$return = weixin_post($url, $data);
	$ary = json_decode($return);
	return ($ary);
}


//将微信坐标转换成百度地图坐标
function convertbaidumap($x, $y) {

	$url = "http://api.map.baidu.com/ag/coord/convert?from=2&to=4&mode=1&x=".$x."&y=".$y;
	$file = file_get_contents($url,500);
	$ar = explode("\"",$file);
	$return['lng'] = base64_decode($ar[5]);
	$return['lat'] = base64_decode($ar[9]);

	return $return;
}

//将微信坐标转换成百度坐标后，再调用百度接口，计算出当前位置距离商户的位置即所需时间
//采用最短距离、步行 &tactics=12&mode=walking 不用此，用默认的
//接口参考：http://developer.baidu.com/map/route-matrix-api.htm
function getmapdistance($self_x, $self_y, $x, $y) {

	$url = "http://api.map.baidu.com/direction/v1/routematrix?output=json&origins={$y},{$x}&destinations={$self_y},{$self_x}&ak=UFZcT8yRjdjZBPubGXlE2lvW";
	$file = file_get_contents($url,500);
	$ary = json_decode($file, true);

	$return['distance'] = $ary['result']['elements'][0]['distance']['text']; //距离
	$return['duration'] = $ary['result']['elements'][0]['duration']['text']; //时间

	return $return;
}

//计算自己当前位置距离此的距离和用时
function getmydistance($lng, $lat) {
	global $_TGLOBAL;

	//得到当前用户自己的经、纬度
	$openid = $_SESSION['userinfo']['openid']; //得到用户的ID
	$query = $_TGLOBAL['db']->query("SELECT lng, lat FROM ".tname('owner') . " WHERE weixin_id ='$openid'");
	$info  = $_TGLOBAL['db']->fetch_array($query);
	if (!$info) {
		return ;
	}
	$return = convertbaidumap($info['lng'], $info['lat']);
	$self_x = $return['x'];
	$self_y = $return['y'];

	//生成距离
	if ($info['lng'] && $info['lat'] && $lng && $lat) {
		$return = getmapdistance($info['lng'], $info['lat'], $lng, $lat);
		return $return;
	} else {
		return ;
	}
}



//根据 上级微信号 生成用户编号
function getusercode($weixin) {
	global $_TGLOBAL;

	if ($weixin) {
		$code1 = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT code FROM ".tname('members')." WHERE weixin='$weixin'"), 0);
	}
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT MAX(code) FROM ".tname('members')." WHERE code LIKE '".$code1."_____'"), 0);
	
	//生成新的编码
	$code2 = substr($count, -5, 5);
	$code = $code1 . substr($code2 + 1 + 100000, -5, 5);

	return $code;
}


//得到access_token
function weixin_access_token() {
	global $_TCONFIG;
	$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$_TCONFIG[weixin_AppId]&secret=$_TCONFIG[weixin_AppSecret]";
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$result = curl_exec($ch); 

	$ary = json_decode($result);
	return $ary->access_token;
}



//根据微信号，重新生成用户编码
function makedownuser_all() {
	global $_TGLOBAL;
	$query = $_TGLOBAL['db']->query("SELECT *
								FROM ".tname('members')."
								WHERE recomm_id = '' AND weixin != ''
								ORDER BY uid ASC");
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		makedownuser($value['weixin']);
	}
}

/*

1. 将上级微信非空的用户的code字段清空
? 2. 查询出code为空的用户，按uid asc
3. 查询上级微信为空的顶部的用户，然后再查询上级微信号为此用户的所有用户，循环生成新的code
4. 页面可重复刷新几次，实现将所有用户重新生成编码

*/
function makedownuser($weixin) {
	global $_TGLOBAL;

	if (!$weixin) return;

	//取出当前用户的上级微信号，依次循环，直至找到上级微信为空的顶部用户，
	$qq = $_TGLOBAL['db']->query("SELECT *
								FROM ".tname('members')."
								WHERE recomm_id = '$weixin'
								ORDER BY uid ASC");
	$user = array();
	while ($vv = $_TGLOBAL['db']->fetch_array($qq)) {
		$user[] = $vv;
	}

	foreach($user AS $vv) {
		$newcode = getusercode($weixin);
		//echo "<BR> <BR>uid=".$vv['uid']. ' username='. $vv['username'].' weixin='. $vv['weixin'];
		//echo ' UPDATE '.tname('members')." SET code='$newcode' WHERE uid='$vv[uid]'";
		$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET code='$newcode' WHERE uid='$vv[uid]'");

		$count  = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('members')." WHERE recomm_id = '$vv[weixin]'"), 0);
		//echo " SELECT COUNT(*) FROM ".tname('members')." WHERE recomm_id = '$vv[weixin]'";
		if ($count > 0) {
			makedownuser($vv['weixin']);
		}

	}
}

