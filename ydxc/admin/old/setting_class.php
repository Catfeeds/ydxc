<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: class.php 2009-6-14 17:54:52 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');
			 
if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	
	// 判断有没有子类
    $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('class')." WHERE pid IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        showmsg('存在子分类，不能直接删除，请先删除子分类！', $_TGLOBAL['refer']);
    } 
	
	// 判断物资名录中有没有这样的
    $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('name')." WHERE classid IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        showmsg('物资名录中使用的分类不能接删除！', $_TGLOBAL['refer']);
    } 
	
	// 删除分类 删除分类属性名称 删除分类配件名称
	$_TGLOBAL['db']->query("DELETE FROM ".tname('class_attr')." WHERE classid IN($aryid)");
	$_TGLOBAL['db']->query("DELETE FROM ".tname('class_parts')." WHERE classid IN($aryid)");
	$_TGLOBAL['db']->query("DELETE FROM ".tname('class')." WHERE id IN($aryid)");
	
	
	makecache('class','id', '', 'orderlist',1); //缓存
	showmsg('删除物资类别成功！', $_TGLOBAL['refer']);
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'display';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
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
  <DIV class=header><a href="module.php?ac=setting&mod=class_add" class="MustFill">添加新的物资类别</a> <?php echo getclasscotename('news_class', $class_id); ?></DIV>
  <form  method="post" name="FormEdit">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center">物资类别名称</div></td>
          <!--<td class="caption"><div align="center">条形码编号</div></td>
          <td class="caption"><div align="center">父级物资类别</div></td>-->
          <!--<td class="caption"><div align="center">显示顺序</div></td>
          <td class="caption"><div align="center">是否显示</div></td>
          <td class="caption"><div align="center">显示方式</div></td>-->
          <td class="caption"><div align="center">创建人</div></td>
          <td class="caption"><div align="center">创建时间</div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
        <?php
foreach($_TGLOBAL['tree_class'] as $key=>$value){
	$html = '';
	if($value['sort']){
		$html = '&nbsp;&nbsp;'.$value['html'];
	}
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="left"><?php echo $html.$value['name']; ?></td>
          <!--<td align="center"><?php echo $value['barcode']; ?></td>-->
		  <td align="center"><?php echo $value['createname']; ?></td>
		  <td align="center"><?php echo date("Y-m-d H:i" ,$value['date']); ?></td>
          <!--<td align="center"><?php echo $value['is_hidden']==1 ? '隐藏' : '显示'; ?></td>
          <td align="center"><?php echo $value['orderlist'] ? $value['orderlist'] : '-'; ?></td>
          <td align="center"><?php echo $value['template'] ? $_TGLOBAL['setting']['class_template'][$value['template']] : '&nbsp;'; ?></td>-->
          <td align="center">

				<?php if(!first_child($value['id'], $_TGLOBAL['tree_class'])): ?>
					<a href="module.php?ac=setting&mod=class_attr&classid=<?php echo $value['id']; ?>">属性</a>
					&nbsp;
					<a href="module.php?ac=setting&mod=class_parts&classid=<?php echo $value['id']; ?>">配件</a>
					&nbsp;
				<?php endif; ?>
				
				<a href="module.php?ac=setting&mod=class_edit&id=<?php echo $value['id']; ?>">修改</a>
		  </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
    <label for="checkbox">全选</label>
    &nbsp;&nbsp;
    <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
  </form>
  
  <BR>
  <u>帮助</u><span class="p14">： </span>
  <ul>
    <li>如果某个分类下面存在子分类则不能被删除。</li>
    <li>如果某个分类在物资名录中有使用则不能被删除。</li>
    <li>删除某个分类，则会删除这个分类对应的属性名称和配件名称，请谨慎操作。</li>
  </ul>
  
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
