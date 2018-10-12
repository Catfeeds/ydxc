<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'group'); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');

$mod = 'group';

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
				'name'             => 	$_POST['name'],
				'remark'           => 	$_POST['remark'],
				);
		inserttable('member_group', $grouparr);
		member_group_cache();
		showmsg('会员级别添加成功！', 'module.php?ac=member&mod=group');

	} else { //更新

		$grouparr = array(
				'name'             => 	$_POST['name'],
				'remark'           => 	$_POST['remark'],	
				);
		updatetable('member_group', $grouparr, array('id' => $id));
		member_group_cache();
		showmsg('会员级别修改成功！', 'module.php?ac=member&mod=group');

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('member_group')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
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
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>会员级别管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="22%" class="caption">级别名称</td>
            <td width="78%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写级别名称名称."></td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td><textarea name="remark" cols="38" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>