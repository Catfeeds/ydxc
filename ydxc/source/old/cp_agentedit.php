<?php
/*
	[CTB] (C) 2007-2009 
	$Id: cp_agentedit.php 2011-10-13 23:50:50 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$id = @(int)$_GET['id'];
!$id && die('Access Denied');

//只有全国总代 以上的级别，才有修改权限
//$userinfo['usertype'] > 3 && showmessage('错误：权限不足 ，不能修改会员资料！');

if(submitcheck('btnsubmit')) {

		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE cardno='$_POST[cardno]' AND uid!='$id'");
		if ($member=$_TGLOBAL['db']->fetch_array($query)) {
			showmessage('你输入的经销商身份证号码已经存在，请重新输入！');
		}

		$arr = array(	
				'name'             => 	$_POST['name'],
				'phone'            => 	$_POST['phone'],
				'cardno'           => 	$_POST['cardno'],
				'zone_id'          => 	$_POST['a']."/".$_POST['b']."/".$_POST['c'],
				'address'          => 	$_POST['address'],
				'qq'               => 	$_POST['qq'],
				'weibo'            => 	$_POST['weibo'],
				'remark'           => 	$_POST['remark']
						);
		$password = trim($_POST['password']);
		if ($password) {
			$password = md5($password);
			$arr['password'] = $password;
		}

	$img_url = '';
	//上传logo
	include_once('./source/function_image.php');
	if ($_FILES['img']['name']) {
		$aryreturn = pic_save($_FILES['img']);
		if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
			$img_url = $aryreturn['new_name'];
			$arr['receipts'] = $img_url;
		} else {
			showmessage($aryreturn);
		}
	}
	
	updatetable('members', $arr, array('uid' => $id));
	showmessage('资料修改成功', 'index.php?do=agent');

} else {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE uid='$id'");

	$self_weixin = $userinfo['weixin']; //得到当前己登录用户的微信
	$userinfo = $_TGLOBAL['db']->fetch_array($query);

	//登录系统，前台不能看见非直接其下级的准确微信号，（可以用中间省略的方式  1***1这样来显示）
	//如果用户的推荐微个不是当前登录自己的
	if ($userinfo['recomm_id'] != $self_weixin) {
		$userinfo['weixin'] = get_name_star($userinfo['weixin']);
	}


	$zone = @explode('/',$userinfo['zone_id']);
	$formhash = formhash();
}

$top_name = '我的代理';
echo template('cp_profile', get_defined_vars());
?>