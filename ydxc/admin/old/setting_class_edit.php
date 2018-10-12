<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	//判断 父级 是否存在
	if($_POST['pid']){
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('class')." WHERE id='$_POST[pid]' AND id<>$id");
		if (!$list=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('父级物资类别不存在，请检查是不是将自己作为父级了！');
		}		
	}
	
	
	if ($id <= 0) { //添加

		$classarr = array(
				'pid'              => 	$_POST['pid'],
				'name'             => 	$_POST['name'],
				'orderlist'        => 	$_POST['orderlist'],
				'descript'         => 	$_POST['descript'],
				'remark'           => 	$_POST['remark'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				);
		$classid = inserttable('class', $classarr, 1);
		// 更新编号、条形码
		$class['no']      = str_repeat(0,3 - strlen($classid)).$classid;
		//$class['barcode'] = makeno('class', 'barcode', 10, 'c'.$class['no']);;
		updatetable('class', $class, array('id' => $classid));
		
		makecache('class','id', '', 'orderlist', 1); //缓存
		showmsg('物资类别添加成功！', 'module.php?ac=setting&mod=class&id='.$_POST['id']);

	} else { //更新

		$classarr = array(
				'pid'              => 	$_POST['pid'],
				'name'             => 	$_POST['name'],
				'orderlist'        => 	$_POST['orderlist'],
				'descript'         => 	$_POST['descript'],
				'remark'           => 	$_POST['remark'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				);
		updatetable('class', $classarr, array('id' => $id));
		makecache('class','id', '', 'orderlist', 1); //缓存
		showmsg('物资类别修改成功！', 'module.php?ac=setting&mod=class&id='.$_POST['id']);

	}
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['tree_class'][$id];
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
          <td width="30%" class="caption">父级物资类别</td>
          <td width="70%"><?php 
				$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_class'],'pid', $tree['pid'],'datatype="Require" msg="请选择父级物资类别."','name', 'id','作为一级物资类别', '0', 1) ;?></td>
        </tr>
        <tr>
          <td width="30%" class="caption"><span class="font_red">*</span>物资类别名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($tree['name']) ? $tree['name'] : '' ; ?>" size="50" maxlength="255" datatype="Require" msg="请填写物资类别名称."></td>
        </tr>
        <!--<tr>
          <td width="30%" class="caption">物资类别条形码</td>
          <td width="70%"><input name="barcode" type="text" id="barcode" value="<?php echo isset($tree['barcode']) ? $tree['barcode'] : '' ; ?>" size="50" maxlength="255" disabled />（后台自动生成）</td>
        </tr>
        <tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>-->
		<tr>
			<td class="caption">描述</td>
			<td><textarea name="descript" cols="38" rows="4" id="descript"><?php echo isset($tree['descript']) ? $tree['descript'] : ''; ?></textarea></td>
		</tr>
        <tr>
          <td width="30%" class="caption">创建人</td>
          <td width="70%"><input name="createname" type="text" id="createname" value="<?php echo isset($tree['createname']) ? $tree['createname'] : '' ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><input name="storeid" type="text" id="storeid" value="<?php echo isset($storename) ? $storename : ''; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
		
		
	
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
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
