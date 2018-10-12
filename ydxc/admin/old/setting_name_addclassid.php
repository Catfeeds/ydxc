<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	//判断 是否子级存在
	if($_POST['id']){
		$list  = $_TGLOBAL['db']->getall("SELECT NULL FROM ".tname('class')." WHERE pid='$_POST[id]' ");
		
		if ($list) {
			showmsg('父级分类无法添加产品！！', 'module.php?ac=setting&mod=name_addclassid');
		}else{
			header("Location: module.php?ac=setting&mod=name_add&classid=$id"); 
		}
	}
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>TOUR V1.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 97%">
  <DIV class=header>物资类别管理</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="30%" class="caption">请选择物资类别</td>
          <td width="70%"><?php 
				$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_class'],'id', 0,'datatype="Require" msg="请选择物资类别."','name', 'id','选择物资类别', '', 1) ;?></td>
        </tr>
        <!--<tr>
          <td width="30%" class="caption"><span class="font_red">*</span>物资类别名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($tree['name']) ? $tree['name'] : '' ; ?>" size="50" maxlength="255" datatype="Require" msg="请填写物资类别名称."></td>
        </tr>
        <tr>
          <td width="30%" class="caption">物资类别条形码</td>
          <td width="70%"><input name="barcode" type="text" id="barcode" value="<?php echo isset($tree['barcode']) ? $tree['barcode'] : '' ; ?>" size="50" maxlength="255" disabled />（后台自动生成）</td>
        </tr>
        <tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>
		<tr>
			<td class="caption">描述</td>
			<td><textarea name="descript" cols="38" rows="4" id="descript"><?php echo isset($tree['descript']) ? $tree['descript'] : ''; ?></textarea></td>
		</tr>
        <tr>
          <td width="30%" class="caption">创建人</td>
          <td width="70%"><input name="createname" type="text" id="createname" value="<?php echo $_TGLOBAL['adm_name'] ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><input name="storeid" type="text" id="storeid" value="<?php echo $_TGLOBAL['adm_storename'] ? $_TGLOBAL['adm_storename'] : '' ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>-->
		
		
	
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="下一步">
            <!--<input name="id" type="hidden" id="id" value="<?php echo $id; ?>">-->
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
