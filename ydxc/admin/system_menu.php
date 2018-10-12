<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user.php 2009-8-5 15:07:40 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
checkpermission(); //权限检查
include_once(S_ROOT.'./lib/function/function_cache.php');
loadcache('menu'        ,'id', '', 'orderlist', 1); // 加载缓存树状菜单
/*把 menu.inc.php 的数组存到数据库中*/
/*
foreach($_TGLOBAL['menu']['main'] as $key=>$val){
	$arr1 = array(
			'mod'   => $key,
			'name'  => $val,
		);
	inserttable('menu', $arr1);
	foreach($_TGLOBAL['menu'][$key] as $k=>$v){
		$arr2 = array(
				'mod'   => $key,
				'ac'    => $k,
				'name'  => $v,
				'is_hidden'  => $v ? 1 :'',
			);
		inserttable('menu', $arr2);
	}
}
*/
		 
if (isset ($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	//如果有子级这不能删除
	$count = $_TGLOBAL['db']->getcount('menu', "pid IN($aryid) AND id NOT IN($aryid)");
	if($count){
		showmsg('<font color="red">菜单下面有子菜单，不能删除！</font>', $_TGLOBAL['refer']);
	}else{
		$_TGLOBAL['db']->query("DELETE FROM ".tname('menu')." WHERE id IN($aryid)");
		makecache('menu','id', '', 'orderlist'); // 后台菜单缓存
		makecache('menu','id', '', 'orderlist', 1); // 后台菜单缓存
		
		//删除权限 中的这个菜单
		$_TGLOBAL['db']->query("DELETE FROM ".tname('admin_role_priv')." WHERE menu_id IN($aryid)");
		makecache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限
		showmsg('删除菜单成功！', $_TGLOBAL['refer']);		
	}

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
    <DIV class=header><a href="module.php?ac=system&mod=menu_work" class="MustFill">添加菜单</a></DIV>
    <form  method="post" name="FormEdit">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
			<td class="caption"><div align="center">菜单</div></td>
            <td class="caption"><div align="center">模型</div></td>
            <td class="caption"><div align="center">操作</div></td>
            <td class="caption"><div align="center">顺序</div></td>
            <td class="caption"><div align="center">显示</div></td>
            <td class="caption"><div align="center">修改</div></td>
          </tr>
<?php

//排序方式
foreach($_TGLOBAL['tree_menu'] as $key=>$val){
	$html = '';
	if($val['sort']){
		$html = '&nbsp;&nbsp;'.$val['html'];
	}
?>
	<tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $val['id'];?>"></td>
			<td align="left"><?php echo $html.$val['name'] ; ?></td>
            <td align="center"><?php echo $val['mod']; ?></td>
            <td align="center"><?php echo $val['ac']; ?></td>
            <td align="center"><?php echo $val['orderlist'] ? $val['orderlist'] : ''; ?></td>
            <td align="center"><?php echo $val['is_hidden']==1 ? '隐藏' : '显示'; ?></td>
            <td align="center"><a href="module.php?ac=system&mod=menu_work&id=<?php echo $val['id']; ?>">修改</a></td>
          </tr>	
	
<?php
}
?>
        </tbody>
      </table>
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
      <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form></DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>