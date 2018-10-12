<?php //Ìá½»¶ÌÐÅ
$post_data = array();
$post_data['userid'] = '317';
$post_data['account'] = 'djjx';
$post_data['password'] = 'djjx123';
$post_data['content'] = urlencode('hehe'); //¶ÌÐÅÄÚÈÝÐèÒªÓÃurlencode±àÂëÏÂ
$post_data['mobile'] = '18883966624';
/*$post_data['sendtime'] = '';*/ //²»¶¨Ê±·¢ËÍ£¬ÖµÎª0£¬¶¨Ê±·¢ËÍ£¬ÊäÈë¸ñÊ½YYYYMMDDHHmmssµÄÈÕÆÚÖµ
/*$url='http://¿Í»§¶ËµØÖ·/sms.aspx?action=send';*/
$time = date('YmdHis');
print_r($time);
$post_data['timestamp'] = $time;
$sign = md5($post_data['account'].$post_data['password'].$time);
$post_data['sign'] = $sign;
$url = 'http://dx.qxtsms.cn/v2sms.aspx?action=send';
$o='';
/*foreach ($post_data as $k=>$v)
{
   $o.="$k=".urlencode($v).'&';
}
$post_data=substr($o,0,-1);*/
print_r($post_data);
$ch = curl_init();
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //Èç¹ûÐèÒª½«½á¹ûÖ±½Ó·µ»Øµ½±äÁ¿Àï£¬ÄÇ¼ÓÉÏÕâ¾ä¡£
$result = curl_exec($ch);
print_r($result);
?>