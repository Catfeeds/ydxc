<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状

//include_once(S_ROOT.'./lib/function/function_cache.php');
if(isset ($_POST['partssubmit'])) {
	$aryid = simplode($_POST['itemid']);
	
	//判断物资名录中有没有使用
    $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('name_parts')." WHERE partsid IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        showmsg('物资名录中已经使用的物资配件不能删除！', $_TGLOBAL['refer']);
    } 
	
    $_TGLOBAL['db']->query("DELETE FROM ".tname('class_parts')." WHERE id IN ($aryid) "); 
	showmsg('物资配件删除操作成功！');
}

//取出物资类别的信息
$classid = isset($_GET['classid']) ? (int)$_GET['classid'] : 0;
if ($classid > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('class')." WHERE id='$classid'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$storename = getcount('store', array('id'=>$departmentid), 'name');
}

// 供应商联系人列表
//排序方式
$field = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

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
    <DIV class=header>物资类别管理</DIV>
		<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="15%" class="caption">类别名称</td>
            <td width="35%"><?php echo isset($name) ? $name : ''; ?></td>
			  <td width="15%" class="caption">&nbsp;</td>
			  <td width="35%"><?php echo isset($mobile) ? $mobile : ''; ?></td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td colspan="3"><?php echo isset($descript) ? $descript : ''; ?></td>
          </tr>
        <tr>
          <td class="caption">创建人</td>
          <td><?php echo isset($createname) ? $createname : '' ; ?></td>
          <td class="caption">所属仓库</td>
          <td><?php echo isset($storename) ? $storename : ''; ?></td>
        </tr>
        </tbody>
      </table>
	  <br/><br/>
	  
	  <DIV class=header><a href="module.php?ac=setting&mod=class_attr_add&classid=<?php echo $classid ;?>">添加物资属性</a> </DIV>
    <form  method="post" name="FormEdit1" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("类别名称", "classid", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("属性名称", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建人", "createname", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建时间", "date", $field, $order); ?></div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
<?php
		
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('class_attr')." WHERE classid='$classid'  ORDER BY $field $order ");
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo get_pos($classid, $_TGLOBAL['tree_class']) ; ?></td>
          <td align="center"><?php echo $value['name'] ? $value['name'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['createname'] ? $value['createname'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['date'] ? date("Y-m-d H:i" ,$value['date']) : '&nbsp'; ?></td>
          <td align="center"><a href="module.php?ac=setting&mod=class_attr_edit&classid=<?php echo $classid ;?>&id=<?php echo $value['id']; ?>">修改</a></td>
        </tr>
        <?php } ?>
      </table>
		<input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
		<label for="checkbox">全选</label>
		&nbsp;&nbsp;
		<input name="attrsubmit" type="submit" class="button" id="attrsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
	<br/><br/><br/>
	
	  <DIV class=header><a href="module.php?ac=setting&mod=class_parts_add&classid=<?php echo $classid ;?>">添加物资配件</a> </DIV>
    <form  method="post" name="FormEdit2" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("类别名称", "classid", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("配件名称", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建人", "createname", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建时间", "date", $field, $order); ?></div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
<?php
		
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('class_parts')." WHERE classid='$classid'  ORDER BY $field $order ");
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo get_pos($classid, $_TGLOBAL['tree_class']) ; ?></td>
          <td align="center"><?php echo $value['name'] ? $value['name'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['createname'] ? $value['createname'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['date'] ? date("Y-m-d H:i" ,$value['date']) : '&nbsp'; ?></td>
          <td align="center"><a href="module.php?ac=setting&mod=class_parts_edit&classid=<?php echo $classid ;?>&id=<?php echo $value['id']; ?>">修改</a></td>
        </tr>
        <?php } ?>
      </table>
		<input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
		<label for="checkbox" >全选</label>
		&nbsp;&nbsp;
		<input name="partssubmit" type="submit" class="button" id="partssubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
	
  <BR>
  <u>帮助</u><span class="p14">： </span>
  <ul>
    <li>如果物资名录中已经填写了这个物资配件，则不能删除。</li>
  </ul>
  
  
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>