<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user.php 2009-8-5 15:07:40 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
		 
if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	$where = '';
	$_CTB['founder'] && $where = " AND userid NOT IN ($_CTB[founder])";
	$_TGLOBAL['db']->query("DELETE FROM ".tname('admin')." WHERE userid IN($aryid) $where");
	showmsg('删除管理员成功！', $_TGLOBAL['refer']);
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'userid';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
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
    <DIV class=header><a href="module.php?ac=system&mod=user_work" class="MustFill">添加新的管理员</a></DIV>
    <form  method="post" name="FormEdit">
      关键词搜索
        <input name="keywords" type="text" id="keywords" size="30" value="<?php echo $keywords; ?>">
        <input name="button" type="submit" id="button" value="查询">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("管理员帐号", "username", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("管理员姓名", "name", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("所属仓库", "name", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("用户角色", "role_id", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("最后在线", "logintime", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("登录次数", "times", $field, $order); ?></div></td>
            <td class="caption"><div align="center">修改</div></td>
          </tr>
<?php
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);	
	$where = " WHERE 1";
	$keywords && $where .= " AND (nickname LIKE '%$keywords%' OR username LIKE '%$keywords%')";
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('admin').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('admin')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['userid'];?>"></td>
            <td align="center"><?php echo $value['username']; ?></td>
            <!--<td align="center"><?php echo $value['name'] ? $value['name'] : '' ; ?></td>
            <td align="center"><?php echo $value['storename'] ? $value['storename'] : '' ; ?></td>-->
            <td align="center"><?php echo $_TGLOBAL['admin_role'][$value['role_id']]['name']; ?></td>
            <td align="center"><?php echo $value['logintime'] > 0 ? date('Y-m-d H:i', $value['logintime']) : '&nbsp;'; ?></td>
            <td align="center"><?php echo $value['times']; ?></td>
            <td align="center"><a href="module.php?ac=system&mod=user_work&id=<?php echo $value['userid']; ?>">修改</a></td>
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