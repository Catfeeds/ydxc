<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_list_work.php 2009-5-6 15:24:32 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'list'); //权限检查

$mod = 'list';

if (isset($_POST['usage'])) {
	
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	if ($id <= 0) { //添加

		//判断 会员编号 是否存在
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE CustomerID='$_POST[CustomerID]'");
		if ($member=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('你输入的客户ID已经存在，请重新输入！');
		}
		
		$arr = array(
				//'CustomerID'       => 	$_POST['CustomerID'],
				//'Openid'           => 	$_POST['Openid'],
				'CusName'          => 	$_POST['CusName'],
				'CusPhone'         => 	$_POST['CusPhone'],
				'PlateNumber'      => 	$_POST['PlateNumber'],
				'Balance'          => 	$_POST['Balance'],
				'Sex'              => 	$_POST['Sex'],
				'Age'              => 	$_POST['Age'],
				'HomeAddress'      => 	$_POST['HomeAddress'],
				'Status'           => 	$_POST['Status'],
				'LogTime'          => 	$_TGLOBAL['timestamp'],
				'usertype'         => 	$_POST['usertype'],
				'bankcard'         => 	$_POST['bankcard'],
				'zone'             =>   $_POST['a']." ".$_POST['b']." ".$_POST['c'],
				);
		inserttable('members', $arr);
		showmsg('会员添加成功！', 'module.php?ac=member&mod=list');

	} else { //更新

		//判断 会员编号 是否存在
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('members')." WHERE CustomerID='$_POST[CustomerID]' AND id!='$id'");
		if ($member=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('你输入的会员编号已经存在，请重新输入！');
		}	
		
		$arr = array(
				'CustomerID'       => 	$_POST['CustomerID'],
				//'Openid'           => 	$_POST['Openid'],
				'CusName'          => 	$_POST['CusName'],
				'CusPhone'         => 	$_POST['CusPhone'],
				'PlateNumber'      => 	$_POST['PlateNumber'],
				'Balance'          => 	$_POST['Balance'],
				'Sex'              => 	$_POST['Sex'],
				'Age'              => 	$_POST['Age'],
				'HomeAddress'      => 	$_POST['HomeAddress'],
				'Status'           => 	$_POST['Status'],
				//'LogTime'          => 	$_TGLOBAL['timestamp'],
				'usertype'         => 	$_POST['usertype'],
				'bankcard'         => 	$_POST['bankcard'],
				'zone'             =>   $_POST['a']." ".$_POST['b']." ".$_POST['c'],
						);
						
		updatetable('members', $arr, array('id' => $id));
		showmsg('会员修改成功！', 'module.php?ac=member&mod=list');

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
//$username = getusername(); //产生新加会员的会员编号
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('members')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$zone = explode(' ', $zone);
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
<script language="JavaScript" src="js/popcalendar.js"></script>
<script language="JavaScript" src="js/jsAddress.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>会员管理</DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
		<?php if ($id) { ?>
		<?php } ?>
        <tr>
          <td class="caption">客户ID</td>
          <td><input name="CustomerID" type="text" id="CustomerID" value="<?php echo isset($CustomerID) ? $CustomerID : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写会员帐号." disabled />(客户ID不能修改)</td>
          <td class="caption">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td class="caption">会员级别</td>
          <td><?php 
				$usertype = isset($usertype) ? $usertype : '';
				echo GetSelect((array)$_TGLOBAL['member_group'], 'usertype', $usertype, 'name'); ?></td>
          <td class="caption">修改余额</td>
          <td><a href="module.php?ac=member&mod=money_add&CustomerID=<?php echo isset($CustomerID) ? $CustomerID : ''; ?>">点击修改</a></td>
        </tr>
        <tr>
          <td class="caption">姓名</td>
          <td><input name="CusName" type="text" id="CusName" value="<?php echo isset($CusName) ? $CusName : ''; ?>" size="50" maxlength="255"></td>
          <td class="caption">电话</td>
          <td><input name="CusPhone" type="text" id="shopurl2" value="<?php echo isset($CusPhone) ? $CusPhone : '' ; ?>" size="50" maxlength="255"></td>
        </tr>
        <!----<tr>
          <td class="caption">车辆牌照</td>
          <td><input name="PlateNumber" type="text" id="PlateNumber" value="<?php echo $PlateNumber; ?>" size="50" maxlength="255"></td>
          <td class="caption">性别</td>
          <td><input name="Sex" type="text" id="Sex" value="<?php echo $Sex; ?>" size="50" maxlength="255"></td>
        </tr>--->
        <tr>
          <td class="caption">年龄</td>
          <td><input name="Age" type="text" id="Age" value="<?php echo isset($Age) ? $Age :'' ; ?>" size="50" maxlength="255"></td>
          <td class="caption">性别</td>
          <td><?php 
					$Sex = isset($Sex) ? $Sex : '';
					echo GetSelect((array)$_TGLOBAL['setting']['gender'], 'Sex', $Sex); ?></td>
        </tr>
        <tr>
          <td class="caption">地区</td>
          <td><!----<input name="Age" type="text" id="Age" value="<?php echo $zone ? $zone :'' ; ?>" size="50" maxlength="255">---->
			<select id="cmbProvince2" class="addres_select" name="a"  dataType="Require" msg="未选择所在省" ></select>
			<select id="cmbCity2" class="addres_select" name="b"  dataType="Require" msg="未选择所在市" ></select>
			<select id="cmbArea2" class="addres_select" name="c" dataType="Require" msg="未选择所在区" ></select>
			<script type="text/javascript">
				<?php 
					if(!isset($zone)){
						$zone[0] = '';
						$zone[1] = '';
						$zone[2] = '';
					}
				?>
				addressInit('cmbProvince2', 'cmbCity2', 'cmbArea2', '<?php echo $zone[0];?>', '<?php echo $zone[1];?>', '<?php echo $zone[2];?>');
			</script>
		  </td>
          <td class="caption">地址</td>
          <td><input name="HomeAddress" type="text" id="HomeAddress" value="<?php echo isset($HomeAddress) ? $HomeAddress : ''; ?>" size="50" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">头像</td>
          <td><?php echo (isset($img) && $img) ? "<a href=\"$img\">点击查看头像</a>" : '暂无头像'; ?></td>
          <td class="caption">银行卡</td>
          <td><input name="bankcard" type="text" id="bankcard" value="<?php echo isset($bankcard) ? $bankcard : '' ; ?>" size="50" maxlength="255" readonly ></td>
        </tr>
        <tr>
          <td class="caption">账户状态</td>
          <td><?php 
				$Status = isset($Status) ? $Status : '';
				GetRadio((array)$_TGLOBAL['setting']['member_Status'], 'Status', $Status); ?></td>
          <td class="caption">注册时间</td>
          <td><?php echo date("Y-m-d H:i", isset($LogTime) ? $LogTime : $_TGLOBAL['timestamp']); ?></td>
        </tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo isset($id) ? $id : ''; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </form>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
