<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user.php 2009-8-5 15:07:40 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
checkpermission(); //权限检查
include_once(S_ROOT.'./lib/function/function_cache.php');
loadcache('weixin_class'        ,'id', '', 'id', 1); // 加载缓存树状菜单

		 
if (isset ($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	//如果有子级这不能删除
	$count = $_TGLOBAL['db']->getcount('weixin_class', "pid IN($aryid) AND id NOT IN($aryid)");
	if($count){
		showmsg('<font color="red">菜单下面有子菜单，不能删除！</font>', $_TGLOBAL['refer']);
	}else{
		$_TGLOBAL['db']->query("DELETE FROM ".tname('weixin_class')." WHERE id IN($aryid)");
		makecache('weixin_class','id', '', 'id', 1); // 后台菜单缓存
		makecache('weixin_class','id', '', 'id'); // 后台菜单缓存
		
		showmsg('删除微信菜单成功！', $_TGLOBAL['refer']);		
	}

}

//对微信生成菜单
if (isset($_POST['btnmake'])) {
	$return = weixin_mekemenu();
	showmsg('生成栏目成功！返回信息：'.$return->errmsg);
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
    <DIV class=header><a href="module.php?ac=weixin&mod=class_work" class="MustFill">添加菜单</a></DIV>
    <form  method="post" name="FormEdit">
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
			<td class="caption"><div align="center">菜单</div></td>
            <td class="caption"><div align="center">父级</div></td>
            <td class="caption" width="30%"><div align="center">转跳</div></td>
            <td class="caption"><div align="center">类型</div></td>
            <td class="caption"><div align="center">修改</div></td>
          </tr>
<?php

//排序方式
foreach($_TGLOBAL['tree_weixin_class'] as $key=>$val){
	$html = '';
	if($val['sort']){
		$html = '&nbsp;&nbsp;'.$val['html'];
	}
?>
	<tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $val['id'];?>"></td>
			<td align="left"><?php echo $html.$val['name'] ; ?></td>
            <td align="center"><?php echo $val['pid'] ? $val['pid'] : '-'; ?></td>
            <td align="center"><?php echo $val['jumpto'] ? $val['jumpto'] : '-'; ?></td>
            <td align="center"><?php echo $val['type'] ? $val['type'] : '-'; ?></td>
            <td align="center"><a href="module.php?ac=weixin&mod=class_work&id=<?php echo $val['id']; ?>">修改</a></td>
          </tr>	
	
<?php
}
?>
        </tbody>
      </table>
    <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
    <label for="checkbox">全选</label>
    &nbsp;&nbsp;
    <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
  <input name="btnmake" type="submit" class="button" id="btnmake" value="生成栏目" onClick="return confirm('您是否真的要生成栏目？')">
    </form>
	<div class="font_red"><strong>注意：</strong>自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。</div>
	
	</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>