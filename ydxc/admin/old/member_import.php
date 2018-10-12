<?php
/*
	[CTB] (C) 2007-2009 zwon.net
	$Id: member_import.php 2012-7-4 9:03:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['usage'])) {

	$msg = '';
	$message = sreadfile($_FILES['upfile']['tmp_name']);
	$arylist = explode("\n", (string)$message);

	foreach($arylist AS $val) {
		if (!$val) continue;

		//会员编号,密码,会员等级(数字表示级别),推荐人,姓名,电话号码,生日,地址,QQ号
		//test,123,3,aa1,王友兴,13898765432,2016-3-6,青羊区,西安中路62号,13434143
		$ary = explode(',', (string)$val);
		//$username = trim($ary[0]);
		//if (!$username) continue;
		
		$Openid      = trim($ary[0]);
		$CusName     = trim($ary[1]);
		$CusPhone    = trim($ary[2]);
		$PlateNumber = trim($ary[3]);
		$Balance     = trim($ary[4]);
		$Sex         = trim($ary[5]);
		$Age         = trim($ary[6]);
		$zone        = trim($ary[7]);
		$HomeAddress = trim($ary[8]);
		$Status      = trim($ary[9]);
		$bankcard    = trim($ary[10]);

		$msg = '';

		//判断用户编号
		/* $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE username = '$username'");
		if($info = $_TGLOBAL['db']->fetch_array($query)) {
			$msg .= "<font color=red>错误：会员编号 $username 已经存在存在！</font><BR>";
		} */

		//判断 上级微信号 是否存在
		/* if ($recomm_id) {
			$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE username='$recomm_id'");
			if (!$member=$_TGLOBAL['db']->fetch_array($query)) {
				$msg .= "<font color=red>错误：推荐人 $recomm_id 不存在！</font><BR>";
			}
		} */

		if (!$msg) {

			$arr = array(
					//'username'         => 	$username,
					//'password'         => 	md5($password),
					//'usertype'         => 	$usertype,				
					//'lastvisit'        => 	0,
					//'lastip'           => 	'',
					//'lastactive'       => 	0,
					//'times'            => 	0,
					//'regip'            => 	getonlineip(),
					//'regdate'          => 	$_TGLOBAL['timestamp'],
					//'nums'             => 	0,
					//'order_nums'       => 	0,
					//'recomm_id'        => 	$recomm_id,
					//'name'             => 	$name,
					//'phone'            => 	$phone,
					//'company'          => 	$company,
					//'qq'               => 	$qq,
					//'email'            => 	$email,
					//'address'          => 	$address,
					//'img'              => 	$img,
					//'birthday'         => 	$birthday,
					//'remark'           => 	$remark
					
					
					'CustomerID'       => 	makecustomrno(),
					'Openid'           => 	$Openid,
					'CusName'          => 	$CusName,
					'CusPhone'         => 	$CusPhone,
					'PlateNumber'      => 	$PlateNumber,
					'Balance'          => 	$Balance,
					'Sex'              => 	$Sex,
					'Age'              => 	$Age,
					'zone'             => 	$zone,
					'HomeAddress'      => 	$HomeAddress,
					'Status'           => 	$Status,
					'LogTime'          => 	$_TGLOBAL['timestamp'],
					'usertype'         => 	$usertype,
					'bankcard'         => 	$bankcard,
					'img'              => 	$img,
					
					
					);
			inserttable('members', $arr);
			$msg .= "<font color=blue>成功：会员编号 $username 建立成功 </font><BR>";
		}
	}

	showmsg($msg);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>批量导入</DIV>
    <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="cccccc" bgcolor="#FFFFFF" class="list_table">
        <tbody>
          <tr>
            <td width="16%" class="caption">文件</td>
            <td width="84%"><input name="upfile" type="file" id="upfile" size="40"></td>
          </tr>
          <!---<tr>
            <td class="caption">&nbsp;</td>
            <td>上传的文件格式为：<br>
              会员编号,密码,会员等级(数字表示级别),推荐人,姓名,电话号码,生日,地址,QQ号<br>
            test,123,3,wyx726,王友兴,13898765432,2016-3-6,青羊区,西安中路62号,13434143<br></td>
          </tr>--->
          <tr>
            <td class="caption">&nbsp;</td>
            <td>上传的文件格式为：<br>
              微信ID,姓名,电话,车辆牌照,余额,性别,年龄,区域,住址,账户状态,用户级别,银行卡卡号<br>
				test,王友兴,13898765432,川A88888,0,1,39,四川省成都成华区,西安中路62号,1,62213434143<br></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="批量导入会员信息">
              <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>