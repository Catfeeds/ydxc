<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

//include_once(S_ROOT.'./lib/function/function_cache.php');



if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
			'name'             => 	$_POST['name'],
			'descript'         => 	$_POST['descript'],
			'zone'             => 	$_POST['a'].'/'.$_POST['b'].'/'.$_POST['c'],
			'address'          => 	$_POST['address'],
			'contact'          => 	$_POST['contact'],
			'mobile'           => 	$_POST['mobile'],
			'tel'              => 	$_POST['tel'],
			'fax'              => 	$_POST['fax'],
			'remark'           => 	$_POST['remark'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
			
				);
		inserttable('supplier', $grouparr);
		makecache('supplier','id', '', 'id'); //缓存
		showmsg('供应商添加成功！', 'module.php?ac=setting&mod=supplier');

	} else { //更新

		$grouparr = array(
			'name'             => 	$_POST['name'],
			'descript'         => 	$_POST['descript'],
			'zone'             => 	$_POST['a'].'/'.$_POST['b'].'/'.$_POST['c'],
			'address'          => 	$_POST['address'],
			'contact'          => 	$_POST['contact'],
			'mobile'           => 	$_POST['mobile'],
			'tel'              => 	$_POST['tel'],
			'fax'              => 	$_POST['fax'],
			'remark'           => 	$_POST['remark'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				);
		updatetable('supplier', $grouparr, array('id' => $id));
		makecache('supplier','id', '', 'id'); //缓存
		showmsg('供应商修改成功！', 'module.php?ac=setting&mod=supplier');

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('supplier')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$zone = explode('/', $zone);
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
            <td width="22%" class="caption"><span class="font_red">*</span>供应商名称</td>
            <td width="78%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写供应商名称."></td>
          </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>负责人</td>
          <td><input name="contact" type="text" id="contact" value="<?php echo isset($contact) ? $contact : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写供应商负责人."></td>
        </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>手机</td>
          <td><input name="mobile" type="text" id="mobile" value="<?php echo isset($mobile) ? $mobile : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写供应商手机."></td>
        </tr>
        <tr>
          <td class="caption">公司电话</td>
          <td><input name="tel" type="text" id="tel" value="<?php echo isset($tel) ? $tel : ''; ?>" size="50" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">传真</td>
          <td><input name="fax" type="text" id="fax" value="<?php echo isset($fax) ? $fax : ''; ?>" size="50" maxlength="255"></td>
        </tr>
          <tr>
            <td class="caption">描述</td>
            <td><textarea name="descript" cols="38" rows="4" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
          </tr>
        <tr>
          <td class="caption">地区</td>
          <td>
			<select id="cmbProvince2" class="addres_select" name="a"  dataType="Require" msg="未选择所在省" ></select>
			<select id="cmbCity2" class="addres_select" name="b"  dataType="Require" msg="未选择所在市" ></select>
			<select id="cmbArea2" class="addres_select" name="c" dataType="Require" msg="未选择所在区" ></select>
			<script type="text/javascript">
				<?php 
					if(!isset($zone)){
						$zone[0] = '西藏';
						$zone[1] = '';
						$zone[2] = '';
					}
				?>
				addressInit('cmbProvince2', 'cmbCity2', 'cmbArea2', '<?php echo $zone[0];?>', '<?php echo $zone[1];?>', '<?php echo $zone[2];?>');
			</script>
		  </td>
        </tr>
        <tr>
          <td class="caption">地址</td>
          <td><input name="address" type="text" id="address" value="<?php echo isset($address) ? $address : ''; ?>" size="120" maxlength="255"></td>
        </tr>

          <tr>
            <td class="caption">备注</td>
            <td><textarea name="remark" cols="38" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
          </tr>
        <tr>
          <td class="caption">创建人</td>
          <td><input name="createname" type="text" id="createname" value="<?php echo $_TGLOBAL['adm_name'] ; ?>" size="50" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td class="caption">所属仓库</td>
          <td><input name="departmentid" type="text" id="departmentid" value="<?php echo $_TGLOBAL['adm_storename'] ? $_TGLOBAL['adm_storename'] : '' ; ?>" size="50" maxlength="255" disabled /></td>
        </tr>
		
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
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