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

$data = $_POST['data'];

$name = $data['uname'];
$phone = $data['phone'];
$tjz_id = (int)$data['tjz_id'];

$org = $_TGLOBAL['db']->getrow("SELECT class_id from ".tname('news')." WHERE id=".$tjz_id);

/**
 * 体检支付成功后调用
 */
function get_tj_code(){
	$code_info = $_TGLOBAL['db']->getall("SELECT id,tj_code_new from ".tname('tj_code_info')." WHERE is_use=1 and belong_to=".$org['class_id']." limit 0,1");
	$code_id = $code_info['id'];
	$is_use = array('is_use'=>2);
	$where = array('id'=>$code_id);
	updatetable('tj_code_info', $is_use ,$where);
}

$info = array(
			'name' 			=> 	$name,
			'phone' 			=>	$phone,
			'organization'	=>	$org['class_id'],
			'station'		=>  $tjz_id,
			'inputtime' 		=>	time()
		);
		
		inserttable('check', $info);
		
		$is_insert = mysql_affected_rows();//获取插入条数
		if($is_insert>0){
			echo template('physical_pay_success', get_defined_vars());
		} else if($is_insert==0){
			echo template('physical_pay_fail', get_defined_vars());
		}


//$newsshow['content'] = str_replace('鼎吉驾校', "<a href='http://www.dingjijiaxiao.com/'>鼎吉驾校</a>", $newsshow['content']);
?>