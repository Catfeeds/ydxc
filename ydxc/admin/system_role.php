<?php
/*
	[CTB] (C) 2007-2009 
	$Id: system_role.php 2010-1-12 15:11:51 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');
			 
if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query("DELETE FROM ".tname('admin_role')." WHERE id IN($aryid)");
	//admin_role_cache();
	makecache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限
	makecache('admin_role_priv','role_id', 'menu_id',1); // 后台管理员权限
	showmsg('删除系统角色成功！', $_TGLOBAL['refer']);
}

$class_id = isset($_POST['class_id']) ? $_POST['class_id'] : (isset($_GET['class_id']) ? $_GET['class_id'] : '');
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
    <DIV class=header><a href="module.php?ac=system&mod=role_work" class="MustFill">添加系统角色</a></DIV>
    <form  method="post" name="FormEdit">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center">角色名称</div></td>
            <td class="caption"><div align="center">备注</div></td>
            <td class="caption"><div align="center">修改</div></td>
          </tr>
<?php
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('admin_role')), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('admin_role')." ORDER BY id DESC LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onmouseover="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onmouseout="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onclick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td><?php echo $value['name']; ?></td>
            <td><?php echo $value['remark']; ?></td>
            <td align="center"><a href="module.php?ac=system&mod=role_work&id=<?php echo $value['id']; ?>">修改</a></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
      <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div></DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>