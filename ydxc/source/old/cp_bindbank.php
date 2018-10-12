<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_bindbank.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header('Content-Type: text/html; charset=utf-8');

//绑定银行卡
if($_POST){
	
    $qian    = array(" ","　","\t","\n","\r");
	$hou     = array("","","","","");
    $card_no = str_replace($qian,$hou,$_POST['card_no']);  //去除所有空格
	$pattern = '/^\d{8,}$/';
	if(!preg_match ($pattern, $card_no)){
		echo "<script>
				alert('请不要输入字符串');
				window.setTimeout(\"location.href = 'index.php?do=bindbank'\", 10);
			</script>";
		die;
	}

	$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET bankcard='$card_no' WHERE CustomerID='$userinfo[CustomerID]'");
	//showmessage('绑定银行卡成功！', 'index.php?do=index');
	header("Location:index.php?do=bindbank&op=ok");
	die;
}






if($op == 'ok'){  //绑定成功页面
	echo template('bindbank_ok', get_defined_vars());
	die;
}

if($op == 'jie'){  //解绑成功页面
	$_TGLOBAL['db']->query('UPDATE '.tname('members')." SET bankcard='' WHERE CustomerID='$userinfo[CustomerID]'");
	echo template('bindbank_jie', get_defined_vars());
	die;
}

if($userinfo['bankcard']){	//已经绑定显示绑定信息
	$bankcard = get_star($userinfo['bankcard'], 4, 4);
	//$bankcard = "*** **** **** ".substr($userinfo['bankcard'], -4);
	echo template('bindbank_2', get_defined_vars());
}else{
	// 没有绑定 显示要求绑定页面
	echo template('bindbank', get_defined_vars());
}





?>