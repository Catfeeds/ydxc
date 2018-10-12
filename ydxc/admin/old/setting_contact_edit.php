<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

//include_once(S_ROOT.'./lib/function/function_cache.php');
$supplierid = isset($_GET['supplierid']) ? (int)$_GET['supplierid'] : (isset($_POST['supplierid']) ? (int)$_POST['supplierid'] : 0);


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
				
				'supplierid'       => 	$_POST['supplierid'],
				'contact'          => 	$_POST['contact'],
				'sex'              => 	$_POST['sex'],
				'tel'              => 	$_POST['tel'],
				'mobile'           => 	$_POST['mobile'],
				'qq'               => 	$_POST['qq'],
				'email'            => 	$_POST['email'],
				'office'           => 	$_POST['office'],
				'descript'         => 	$_POST['descript'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],
			
				);
		inserttable('supplier_contact', $grouparr);
		showmsg('供应商添加成功！', 'module.php?ac=setting&mod=contact&supplierid='.$supplierid);

	} else { //更新

		$grouparr = array(
				'supplierid'       => 	$_POST['supplierid'],
				'contact'          => 	$_POST['contact'],
				'sex'              => 	$_POST['sex'],
				'tel'              => 	$_POST['tel'],
				'mobile'           => 	$_POST['mobile'],
				'qq'               => 	$_POST['qq'],
				'email'            => 	$_POST['email'],
				'office'           => 	$_POST['office'],
				'descript'         => 	$_POST['descript'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],

				);
		updatetable('supplier_contact', $grouparr, array('id' => $id));
		showmsg('供应商修改成功！', 'module.php?ac=setting&mod=contact&supplierid='.$supplierid);

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$supplierid){
	showmsg('请选择供应商！', 'module.php?ac=setting&mod=supplier');
}
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('supplier_contact')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$storename = getcount('store', array('id'=>$departmentid), 'name');
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
<script language="JavaScript" src="js/jsAddress.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>供应商管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="22%" class="caption"><span class="font_red">*</span>联系人</td>
            <td width="78%"><input name="contact" type="text" id="contact" value="<?php echo isset($contact) ? $contact : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写联系人."></td>
          </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>性 别</td>
          <td><?php 
				$sex = isset($sex) ? $sex : '' ;
				echo makeselect($_TGLOBAL['setting']['sex'], 'sex', $sex, 'datatype="Require" msg="请选择性别."', '','', '请选择性别') ;?></td>
        </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>手机</td>
          <td><input name="mobile" type="text" id="mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写手机."></td>
        </tr>
        <tr>
          <td class="caption">电话</td>
          <td><input name="tel" type="text" id="tel" value="<?php echo isset($tel) ? $tel : ''; ?>" size="50" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">QQ</td>
          <td><input name="qq" type="text" id="qq" value="<?php echo isset($qq) ? $qq : ''; ?>" size="50" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">邮箱</td>
          <td><input name="email" type="text" id="email" value="<?php echo isset($email) ? $email : ''; ?>" size="50" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">职位</td>
          <td><input name="office" type="text" id="office" value="<?php echo isset($office) ? $office : ''; ?>" size="50" maxlength="255"></td>
        </tr>
		<tr>
			<td class="caption">描述</td>
			<td><textarea name="descript" cols="60" rows="4" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
		</tr>

		<tr>
			<td class="caption">备注</td>
			<td><textarea name="remark" cols="60" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
		</tr>
        <tr>
          <td class="caption">创建人</td>
          <td><input name="createname" type="text" id="createname" value="<?php echo $createname ; ?>" size="50" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td class="caption">所属仓库</td>
          <td><input name="departmentid" type="text" id="departmentid" value="<?php echo $storename ? $storename : '' ; ?>" size="50" maxlength="255" disabled /></td>
        </tr>
		
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="supplierid" type="hidden" id="id" value="<?php echo $supplierid; ?>"><!--供应商编号-->
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="userid" type="hidden" id="id" value="<?php echo $_TGLOBAL['adm_userid']; ?>">
			<input name="usage" type="hidden" id="usage" value="1">
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>