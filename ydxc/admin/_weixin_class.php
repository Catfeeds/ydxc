<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: weixin_class.php 2009-6-14 17:54:52 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');
loadcache('weixin_class'  ,'id', '', 'id',1); 

if(isset ($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query("DELETE FROM ".tname('weixin_class')." WHERE id IN($aryid)");
	weixin_class_cache();
	showmsg('删除类别成功！');
}

//对微信生成菜单
if (isset($_POST['btnmake'])) {
	$return = weixin_mekemenu();
die;
	showmsg('生成栏目成功！返回信息：'.$return->errmsg);
}


//排序方式
$field    = isset($_GET['field']) ? $_GET['field'] : 'display';
$order    = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '' ;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>TOUR V1.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 97%">
  <DIV class=header><a href="module.php?ac=weixin&mod=class_work&class_id=<?php echo $class_id; ?>" class="MustFill">添加新的类别</a> <?php echo getclasscotename('weixin_class', $class_id); ?></DIV>
  <form  method="post" name="FormEdit">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("类别名称", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("类型", "type", $field, $order); ?></div></td>
          <td class="caption"><div align="center">管理子类</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("转向网址", "jumpto", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("显示顺序", "display", $field, $order); ?></div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
        <?php
	$where = " WHERE 1";
	/*if ($class_id) {
		$len = strlen($class_id);
		$where .= " AND LEFT(class_id, $len) = '$class_id' AND  LENGTH(class_id) = ($len + 3)";
	} else {
		$where .= " AND LENGTH(class_id) = 3";
	}*/
	if($class_id){
		$where .= " AND pid = '$class_id' ";
	}
	
	$sql = "SELECT * FROM ".tname('weixin_class')." $where ORDER BY $field $order";
	$query = $_TGLOBAL['db']->query($sql);
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td><?php echo $value['name']; ?></td>
          <td align="center"><?php echo $_TGLOBAL['setting']['weixin_type'][$value['type']]; ?></td>
          <td align="center"><a href="module.php?ac=weixin&mod=class&class_id=<?php echo $value['id']; ?>">管理子类别</a></td>
          <td align="center"><?php echo $value['jumpto'] ? sub_url($value['jumpto'], 100) : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['display'] ? $value['display'] : '-'; ?></td>
          <td align="center"><a href="module.php?ac=weixin&mod=class_work&id=<?php echo $value['id']; ?>&class_id=<?php echo $class_id; ?>">修改</a></td>
        </tr>
        <?php } ?>
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
