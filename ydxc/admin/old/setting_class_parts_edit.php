<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状

//include_once(S_ROOT.'./lib/function/function_cache.php');
$classid = isset($_GET['classid']) ? (int)$_GET['classid'] : (isset($_POST['classid']) ? (int)$_POST['classid'] : 0);


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
				'classid'          => 	$_POST['classid'],
				'name'             => 	$_POST['name'],
				'descript'         => 	$_POST['descript'],
				'values'           => 	$_POST['values'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],
			
				);
		inserttable('class_parts', $grouparr);
		//showmsg('物资配件添加成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资配件添加成功！', 'module.php?ac=setting&mod=class_parts&classid='.$classid);

	} else { //更新

		$grouparr = array(
				'classid'          => 	$_POST['classid'],
				'name'             => 	$_POST['name'],
				'descript'         => 	$_POST['descript'],
				'values'           => 	$_POST['values'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],

				);
		updatetable('class_parts', $grouparr, array('id' => $id));
		//showmsg('物资配件修改成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资配件修改成功！', 'module.php?ac=setting&mod=class_parts&classid='.$classid);

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if(!$classid){
	showmsg('请选择物资配件！', 'module.php?ac=setting&mod=class_detail');
}
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('class_parts')." WHERE id='$id'");
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
    <DIV class=header>物资配件管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="22%" class="caption">类别名称</td>
            <td width="78%"> <?php echo get_pos($classid, $_TGLOBAL['tree_class']) ; ?></td>
          </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>配件名称</td>
          <td><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写手机."></td>
        </tr>
		<!--<tr>
			<td class="caption">可选值</td>
			<td><textarea name="values" cols="60" rows="4" id="values"><?php echo isset($values) ? $values : ''; ?></textarea></td>
		</tr>-->

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
            <input name="classid" type="hidden" id="id" value="<?php echo $classid; ?>"><!--物资配件编号-->
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