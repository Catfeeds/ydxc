<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
loadcache('ment'  ,'id', '', 'orderlist');   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	if ($id <= 0) { //添加

		$classarr = array(
				'name'             => 	$_POST['name'],
				'descript'         => 	$_POST['descript'],
				'address'          => 	$_POST['address'],
				'contact'          => 	$_POST['contact'],
				'tel'              => 	$_POST['tel'],
				'mobile'           => 	$_POST['mobile'],
				'fax'              => 	$_POST['fax'],
				'qq'               => 	$_POST['qq'],
				'remark'           => 	$_POST['remark'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				//'orderlist'        => 	$_POST['orderlist']

				);
		inserttable('ment', $classarr);
		makecache('ment','id', '', 'orderlist'); //缓存
		showmsg('机构添加成功！', 'module.php?ac=setting&mod=ment');

	} else { //更新

		$classarr = array(
				'name'             => 	$_POST['name'],
				'descript'         => 	$_POST['descript'],
				'address'          => 	$_POST['address'],
				'contact'          => 	$_POST['contact'],
				'tel'              => 	$_POST['tel'],
				'mobile'           => 	$_POST['mobile'],
				'fax'              => 	$_POST['fax'],
				'qq'               => 	$_POST['qq'],
				'remark'           => 	$_POST['remark'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				//'orderlist'        => 	$_POST['orderlist']
				);
		updatetable('ment', $classarr, array('id' => $id));
		makecache('ment','id', '', 'orderlist'); //缓存
		showmsg('机构修改成功！', 'module.php?ac=setting&mod=ment');

	}
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	//$tree = $_TGLOBAL['ment'][$id];
	@extract($_TGLOBAL['ment'][$id]);
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
  <DIV class=header>机构管理</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <!--<tr>
          <td width="30%" class="caption">机构名称</td>
          <td width="70%">
				<select name="pid" id="pid" datatype="Require" msg="请选择机构.">
					<option value="1">十六团</option>
				</select>
			</td>
        </tr>-->
        <tr>
          <td width="30%" class="caption"><span class="font_red">*</span>部门名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : '' ; ?>" size="50" maxlength="255" datatype="Require" msg="请填写部门名称."></td>
        </tr>
        <tr>
          <td width="30%" class="caption">联系人</td>
          <td width="70%"><input name="contact" type="text" id="contact" value="<?php echo isset($contact) ? $contact : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">手 机</td>
          <td width="70%"><input name="mobile" type="text" id="mobile" value="<?php echo isset($mobile) ? $mobile : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">公司电话</td>
          <td width="70%"><input name="tel" type="text" id="tel" value="<?php echo isset($tel) ? $tel : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">传真</td>
          <td width="70%"><input name="fax" type="text" id="fax" value="<?php echo isset($fax) ? $fax : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <tr>
          <td width="30%" class="caption">QQ</td>
          <td width="70%"><input name="qq" type="text" id="qq" value="<?php echo isset($qq) && $qq ? $qq : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>
        <!--<tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>
        <tr>
          <td width="30%" class="caption">地区</td>
          <td width="70%"><input name="zone" type="text" id="zone" value="<?php echo isset($zone) ? $zone : '' ; ?>" size="20" maxlength="255" ></td>
        </tr>-->
        <tr>
          <td width="30%" class="caption">办公地址</td>
          <td width="70%"><input name="address" type="text" id="address" value="<?php echo isset($address) ? $address : '' ; ?>" size="110" maxlength="255" ></td>
        </tr>
		<tr>
			<td class="caption"> 部门描述</td>
			<td><textarea name="descript" cols="80" rows="4" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
		</tr>
		<tr>
			<td class="caption"> 备注</td>
			<td><textarea name="remark" cols="80" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
		</tr>
        <tr>
          <td width="30%" class="caption">创建人</td>
          <td width="70%"><input name="createname" type="text" id="createname" value="<?php echo isset($createname) ? $createname : '' ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><input name="storeid" type="text" id="storeid" value="<?php echo $storename ? $storename : '' ; ?>" size="20" maxlength="255" disabled /></td>
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
