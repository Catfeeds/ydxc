<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: crib.php 2009-6-14 17:54:52 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查
loadcache('crib'  ,'storeid', 'id', 'orderlist', 1);   // 加载缓存树状栏目
loadcache('store'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目
$tree_store = $_TGLOBAL['tree_store']; 

include_once(S_ROOT.'./lib/function/function_cache.php');
			 
if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	
	//判断垛位有没有物资的存在
    $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('product_store')." WHERE cribid IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        showmsg('该垛位存在物资，不能删除！', $_TGLOBAL['refer']);
    } 
	
	// 删除储存的二维码
    $query = $_TGLOBAL['db']->query("SELECT barcode FROM ".tname('crib')." WHERE id IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        $_TGLOBAL['db']->query("DELETE FROM ".tname('barcode')." WHERE barcode = '$value[barcode]' AND itype=2 ");
    } 
	
	// 删除垛位
	$_TGLOBAL['db']->query("DELETE FROM ".tname('crib')." WHERE id IN($aryid)");
	makecache('crib','storeid', 'id', 'orderlist',1); //缓存
	showmsg('删除垛位成功！', $_TGLOBAL['refer']);
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'display';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : '';
$storeid  = trim(isset($_POST['storeid']) ? $_POST['storeid'] : (isset($_GET['storeid']) ? $_GET['storeid'] : '' ));


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
  <DIV class=header><a href="module.php?ac=setting&mod=crib_add&storeid=<?php echo $storeid; ?>" class="MustFill">添加新的垛位</a> </DIV>
  <form  method="post" name="FormEdit">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
	
    &nbsp;
    请选择仓库：
    &nbsp;
	<?php 
		$tree['storeid'] = isset($tree['storeid']) ? $tree['storeid'] : 0 ;
		echo makeselect((array)$_TGLOBAL['tree_store'],'storeid', $storeid,'datatype="Require" msg="请选择所属仓库."','name', 'id','请选择仓库', '', 1) ;?>
	&nbsp;
    <input name="button" type="submit" id="button" value="查询" class="button">
	
	
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center">所属仓库</div></td>
          <td class="caption"><div align="center">垛位名称</div></td>
          <td class="caption"><div align="center">条形码编号</div></td>
          <td class="caption"><div align="center">垛位级别</div></td>
          <!--<td class="caption"><div align="center">父级垛位</div></td>-->
          <!--<td class="caption"><div align="center">显示顺序</div></td>
          <td class="caption"><div align="center">是否显示</div></td>
          <td class="caption"><div align="center">显示方式</div></td>-->
          <td class="caption"><div align="center">创建人</div></td>
          <td class="caption"><div align="center">创建时间</div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
        <?php
foreach($_TGLOBAL['tree_crib'] as $key=>$val){
	foreach($val as $k=>$value){
		
		if($storeid && $storeid != $key){
			break;  //如果是查询某个仓库的垛位，不是这个仓库就退出本次循环
		}
		
		$html = '';
		if($value['sort']){
			$html = '&nbsp;&nbsp;'.$value['html'];
		}
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo get_pos($value['storeid'], $tree_store); ?></td>
          <td align="left"><?php echo $html.$value['name']; ?></td>
          <td align="center"><?php echo $value['barcode']; ?></td>
          <td align="center"><?php echo $value['graded'] ? $_TGLOBAL['setting']['crib_graded'][$value['graded']] : '' ; ?></td>
          <!--<td align="center"><a href="module.php?ac=setting&mod=crib&id=<?php echo $value['id']; ?>">管理子类别</a></td>-->
		  <td align="center"><?php echo $value['createname']; ?></td>
		  <td align="center"><?php echo date("Y-m-d H:i" ,$value['date']); ?></td>
          <!--<td align="center"><?php echo $value['is_hidden']==1 ? '隐藏' : '显示'; ?></td>
          <td align="center"><?php echo $value['orderlist'] ? $value['orderlist'] : '-'; ?></td>
          <td align="center"><?php echo $value['template'] ? $_TGLOBAL['setting']['class_template'][$value['template']] : '&nbsp;'; ?></td>-->
          <td align="center"><a href="module.php?ac=setting&mod=crib_edit&storeid=<?php echo $value['storeid']; ?>&id=<?php echo $value['id']; ?>">修改</a></td>
        </tr>
		
		
        <?php }} ?>
		
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
    <li>如果垛位存在物资则不能删除垛位</li>
  </ul>
  
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
