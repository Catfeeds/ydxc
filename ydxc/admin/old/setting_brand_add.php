<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
//loadcache('ment'  ,'id', '', 'orderlist');   // 加载缓存树状栏目


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	if ($id <= 0) { //添加

		$classarr = array(
				
				'name'             => 	$_POST['name'],
				'link'             => 	$_POST['link'],
				'descript'         => 	$_POST['descript'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'orderlist'        => 	$_POST['orderlist'],
				
				);
		$brandid = inserttable('brand', $classarr,1);
		// 更新编号、条形码
		$brand['no']      = str_repeat(0,3 - strlen($brandid)).$brandid;
		//$brand['barcode'] = makeno('brand', 'barcode', 10, 'b'.$brand['no']);;
		updatetable('brand', $brand, array('id' => $brandid));
		
		makecache('brand','id', '', 'orderlist'); //缓存
		showmsg('品牌添加成功！', 'module.php?ac=setting&mod=brand');

	} else { //更新

		$classarr = array(
				'name'             => 	$_POST['name'],
				'link'             => 	$_POST['link'],
				'descript'         => 	$_POST['descript'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'orderlist'        => 	$_POST['orderlist'],
				);
		updatetable('brand', $classarr, array('id' => $id));
		makecache('brand','id', '', 'orderlist'); //缓存
		showmsg('品牌修改成功！', 'module.php?ac=setting&mod=brand');

	}
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('brand')." 
										WHERE id='$id' ");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$storename = getcount('store', array('id'=>$departmentid), 'name');
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
  <DIV class=header>品牌管理</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="30%" class="caption"><span class="font_red">*</span>品牌名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : '' ; ?>" size="20" maxlength="255" datatype="Require" msg="请填写品牌名称."></td>
        </tr>
        <tr>
          <td width="30%" class="caption">网址</td>
          <td width="70%"><input name="link" type="text" id="link" value="<?php echo isset($link) ? $link : '' ; ?>" size="81" maxlength="255" ></td>
        </tr>
        <!--<tr>
          <td width="30%" class="caption">电 话</td>
          <td width="70%"><input name="tel" type="text" id="tel" value="<?php echo isset($tel) ? $tel : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">邮 箱</td>
          <td width="70%"><input name="email" type="text" id="email" value="<?php echo isset($email) ? $email : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">QQ</td>
          <td width="70%"><input name="qq" type="text" id="qq" value="<?php echo isset($qq) ? $qq : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">职位</td>
          <td width="70%"><input name="office" type="text" id="office" value="<?php echo isset($office) ? $office : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>-->
		<tr>
			<td class="caption"> 品牌描述</td>
			<td><textarea name="descript" cols="60" rows="6" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
		</tr>
		<!--<tr>
			<td class="caption"> 备注</td>
			<td><textarea name="remark" cols="60" rows="6" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
		</tr>-->
        <tr>
          <td width="30%" class="caption">创建人</td>
          <td width="70%"><input name="createname" type="text" id="createname" value="<?php echo $_TGLOBAL['adm_name'] ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><input name="storeid" type="text" id="storeid" value="<?php echo $_TGLOBAL['adm_storename'] ? $_TGLOBAL['adm_storename'] : '' ; ?>" size="20" maxlength="255" disabled /></td>
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
