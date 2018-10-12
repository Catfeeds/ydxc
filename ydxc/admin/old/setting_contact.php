<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

//include_once(S_ROOT.'./lib/function/function_cache.php');

if(isset ($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);
    $_TGLOBAL['db']->query("DELETE FROM ".tname('supplier_contact')." WHERE id IN ($aryid) "); 
	showmsg('供应商联系人删除操作成功！', $_TGLOBAL['refer']);
}

//取出供应商的信息
$supplierid = isset($_GET['supplierid']) ? (int)$_GET['supplierid'] : 0;
if ($supplierid > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('supplier')." WHERE id='$supplierid'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$zone = explode('/', $zone);
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
    <DIV class=header>供应商管理</DIV>
		<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="15%" class="caption">供应商名称</td>
            <td width="35%"><?php echo isset($name) ? $name : ''; ?></td>
			  <td width="15%" class="caption">手机</td>
			  <td width="35%"><?php echo isset($mobile) ? $mobile : ''; ?></td>
          </tr>
        <tr>
          <td class="caption">负责人</td>
          <td><?php echo isset($contact) ? $contact : ''; ?></td>
          <td class="caption">公司电话</td>
          <td><?php echo isset($tel) ? $tel : ''; ?></td>
        </tr>
        <tr>
          <td class="caption">地区</td>
          <td><?php echo $zone[0], '&nbsp;', $zone[1], '&nbsp;', $zone[2];?></td>
          <td class="caption">传真</td>
          <td colspan="3"><?php echo isset($fax) ? $fax : ''; ?></td>
        </tr>
        <tr>
          <td class="caption">地址</td>
          <td colspan="3"><?php echo isset($address) ? $address : ''; ?></td>
        </tr>
          <tr>
            <td class="caption">描述</td>
            <td colspan="3"><?php echo isset($descript) ? $descript : ''; ?></td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td colspan="3"><?php echo isset($remark) ? $remark : ''; ?></td>
          </tr>
        <tr>
          <td class="caption">创建人</td>
          <td><?php echo isset($createname) ? $createname : '' ; ?></td>
          <td class="caption">所属仓库</td>
          <td><?php echo isset($storename) ? $storename : ''; ?></td>
        </tr>
        </tbody>
      </table>
	  <DIV class=header><a href="module.php?ac=setting&mod=contact_add&supplierid=<?php echo $supplierid ;?>">添加联系人</a> </DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("联系人", "contact", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("性别", "sex", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("电话", "tel", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("手机", "mobile", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("QQ", "qq", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("邮箱", "email", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("职位", "office", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建人", "createname", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建时间", "date", $field, $order); ?></div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
<?php
		
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('supplier_contact')." WHERE supplierid='$supplierid'  ORDER BY $field $order ");

	

while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo $value['contact']; ?></td>
          <td align="center"><?php echo $_TGLOBAL['setting']['sex'][$value['sex']]; ?></td>
          <td align="center"><?php echo $value['tel'] ? $value['tel'] : '-'; ?></td>
          <td align="center"><?php echo $value['mobile'] ? $value['mobile'] : '-'; ?></td>
          <td align="center"><?php echo $value['qq']; ?></td>
          <td align="center"><?php echo $value['email'] ? $value['email'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['office'] ? $value['office'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['createname'] ? $value['createname'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['date'] ? date("Y-m-d H:i" ,$value['date']) : '&nbsp'; ?></td>
          <td align="center"><a href="module.php?ac=setting&mod=contact_edit&supplierid=<?php echo $supplierid ;?>&id=<?php echo $value['id']; ?>">修改</a></td>
        </tr>
        <?php } ?>
		
		
		
      </table>
		<input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
		<label for="checkbox">全选</label>
		&nbsp;&nbsp;
		<input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>