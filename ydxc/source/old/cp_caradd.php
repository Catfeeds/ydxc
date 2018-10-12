<?php
/*
	[CTB] (C) 2007-2009 
	$Id: cp_newreg.php 2012-12-20 16:24:08 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$openid = $_SESSION['member']['openid'];


if($_POST['CarNumber']) {
	//判断
	if(strlen($_POST['CarNumber']) < 9 ){
		showmessage_ajax(array('error' => '请填写正确车牌号！'));
	}
	
	$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('member_car')." WHERE CarNumber='$_POST[CarNumber]'");
	if ($member=$_TGLOBAL['db']->fetch_array($query)) {
		showmessage_ajax(array('error' => '错误：车辆已经存在！'));
	}
	
	$count = getcount('member_car',array('CustomerID' => $userinfo['CustomerID']));
	if($count >= 3){
		showmessage_ajax(array('error' => '你最大只能添加3辆车！', 'jumpto' => 'index.php?do=car'));		
	}else{
		$arr = array(
				'CustomerID'       => 	$userinfo['CustomerID'],
				'CarID'            => 	makecarno(),
				'CarNumber'        => 	$_POST['CarNumber'],
				'BindPay'          => 	1,  //自动付费开启
				);
		inserttable('member_car', $arr);
		
		//添加代金券 绑定车辆代金券id=5   //函数内已经判断这个用户是不是已经得到了代金券
		//insert_usercoupons($openid, 5);
		/*if(!$count){
			$jumpto = 'index.php?do=caradd&op=ok';
		}else{
			$jumpto = 'index.php?do=car';
		}*/
		$jumpto = 'index.php?do=car';
		showmessage_ajax(array('ok' => '车辆添加成功！', 'jumpto' => $jumpto));		
	}

}

if($_GET['op']=='ok'){
	echo template('caradd_ok', get_defined_vars());
	die;
}

echo template('caradd', get_defined_vars());
?>