<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: cp_index.php 2010-6-21 23:18:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$openid = $_SESSION['member']['openid'];

//��ȡ�������
require_once "source/jssdk.php";
$jssdk = new JSSDK($_TCONFIG['weixin_AppId'], $_TCONFIG['weixin_AppSecret']);
$signPackage = $jssdk->GetSignPackage();

//������ȡ����ȯ
/* if($_GET['op']=='share_coupon'){
	//������Ϣ ��ô���ȯ $profile['CustomerID']  ������Ϣ����ȯid��6
	$is_ok = insert_usercoupons($openid, 6);
	if($is_ok){
		showmessage_ajax(array('ok' => '����ɹ�,��ɹ���ȡ����ȯ��', 'jumpto' => './'));
	}else{
		showmessage_ajax(array('error' => '���Ѿ���ȡ����ȯ��', 'jumpto' => './'));
	}
	die;
} */

//���û�������ȡ����ȯ
if($_GET['op']=='new'){
	//��ȡ������Ϣ
	$member = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE id='$_GET[id]' ");
	//���ѻ�ô���ȯ
	$is_ok = insert_usercoupons($member['Openid'], 6);
	//��ȡ�Ż�ȯ��Ϣ
	$coupon = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('coupons')." WHERE id=7 ");
	echo template('share_new', get_defined_vars());
	die;
}


if($_POST){
	//�ж� �û��ֻ��ǲ��Ǵ���
	$username    = $_POST['username'];
	$PromotionID = $_POST['PromotionID'];
	$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE CusPhone='$username'");
	if ($member=$_TGLOBAL['db']->fetch_array($query)) {
		//showmessage_ajax(array('error' => '�����ֻ������Ѵ��ڣ�'));
		$ok = 0;
	}else{
		$CustomerID = makecustomrno();
		$arr = array(
				'CustomerID'       => $CustomerID	,
				//'Openid'           => 	$_SESSION['member']['openid'], //Ϊ�������ٴε�¼��ʱ����Ҫ�����¼ҳ�棬���Բ���openidд�����ݿ⣬��ʱ��Ȣ������Ա��Ϣ��������¼ҳ��
				'CusName'          => 	$_SESSION['member']['nickname'],
				'CusPhone'         => 	$username,
				'PlateNumber'      => 	'',
				'Balance'          => 	0,
				'Sex'              => 	$_SESSION['member']['sex'],
				'Age'              => 	0,
				'zone'             => 	$_SESSION['member']['province'].$_SESSION['userinfo']['city'],
				'HomeAddress'      => 	'',
				'Status'           => 	1,
				'LogTime'          => 	$_TGLOBAL['timestamp'],
				'usertype'         => 	1,
				'img'			   => $_SESSION['member']['headimgurl'],
				);
		$id = inserttable('members', $arr, 1);
		//������Ϣ ��ô���ȯ $profile['CustomerID']  �Ż�ȯע����Ϣ����ȯid��7
		$is_ok = insert_usercoupons($openid, 7, $PromotionID, $CustomerID);
		
		
		
		
		$ok    = 1;
	}
	
	echo template('share_ok', get_defined_vars());
	die;
}

	
echo template('share', get_defined_vars());
?>