<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_list.php 2010-6-9 20:01:11 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if(isset ($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);
	
    $_TGLOBAL['db']->query("DELETE FROM ".tname('supplier_product')." WHERE supplierid IN ($aryid) "); //供应物资
    $_TGLOBAL['db']->query("DELETE FROM ".tname('supplier_contact')." WHERE supplierid IN ($aryid) "); //删除联系人
	$_TGLOBAL['db']->query("DELETE FROM ".tname('supplier')." WHERE id IN($aryid)");
	makecache('supplier','id', '', 'id'); //缓存
	showmsg('供应商删除操作成功！');
}

//排序方式
$field = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : '' ));
$date_start = trim(isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : '' ));
$date_end = trim(isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : '' ));
$usertype = trim(isset($_POST['usertype']) ? $_POST['usertype'] : (isset($_GET['usertype']) ? $_GET['usertype'] : '' ));
$CusPhone = trim(isset($_POST['CusPhone']) ? $_POST['CusPhone'] : (isset($_GET['CusPhone']) ? $_GET['CusPhone'] : ''));
$openid   = trim(isset($_POST['openid']) ? $_POST['openid'] : (isset($_GET['openid']) ? $_GET['openid'] : '' ));
$CusName  = trim(isset($_POST['CusName']) ? $_POST['CusName'] : (isset($_GET['CusName']) ? $_GET['CusName'] : ''));


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<script language="JavaScript" src="js/selectTime.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header><a href="module.php?ac=setting&mod=supplier_add">添加供应商</a> </DIV>
  <form  method="post" name="FormEdit">
    &nbsp;
    <input placeholder="关键词" name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
    &nbsp;
    <!--<input placeholder="电话" name="CusPhone" type="text" id="CusPhone" value="<?php echo $CusPhone; ?>" size="30">
    &nbsp;
    <input placeholder="姓名" name="CusName" type="text" id="CusName" value="<?php echo $CusName; ?>" size="30">
    <span class="p"> </span>-->
    <input placeholder="登记日期" name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd ');"><!--SelectDate(this,'yyyy-MM-dd hh:mm:ss')-->
  
    -
    <input placeholder="登记日期" name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd ');">


    <input name="button" type="submit" id="button" value="查询" class="button">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("供应商名称", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("区域", "address", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("负责人", "contact", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("手机", "mobile", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("电话", "tel", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("传真", "fax", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建人", "createname", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("创建时间", "date", $field, $order); ?></div></td>
          <td class="caption"><div align="center">修改</div></td>
        </tr>
        <?php 
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = ' WHERE 1';

	if ($keywords) {
		$where .= " AND (";
		$where .= " name LIKE '%$keywords%'";
		$where .= " OR address LIKE '%$keywords%'";//
		$where .= " OR contact LIKE '%$keywords%'";//
		$where .= " OR mobile LIKE '%$keywords%'";
		$where .= " OR tel LIKE '%$keywords%' ";
		$where .= " OR fax LIKE '%$keywords%' ";
		$where .= " OR createname LIKE '%$keywords%')";
	}
	
	if ($CusPhone) {
		$where .= " AND CusPhone LIKE '%$CusPhone%' ";
	}
	
	if ($openid) {
		$where .= " AND openid LIKE '%$openid%' ";
	}
	
	if ($CusName) {
		$where .= " AND CusName LIKE '%$CusName%' ";
	}
	
    //处理日期段搜索
    if ($date_start && $date_end) {
		$date_start = strtotime($date_start.' 00:00:00'); //转换输入的时间为时间戳的方式
		$date_end = strtotime($date_end. ' 23:59:59');
		$where .= " AND (date between '$date_start' and '$date_end')"; 
    }
	
	$usertype && $where .= " AND usertype='$usertype'";
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('supplier')." ".$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT m.* FROM ".tname('supplier')." m
										$where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());

	

while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo $value['name']; ?></td>
          <td align="center"><?php echo $value['zone']; ?></td>
          <td align="center"><?php echo $value['contact'] ? $value['contact'] : '-'; ?></td>
          <td align="center"><?php echo $value['mobile'] ? $value['mobile'] : '-'; ?></td>
          <td align="center"><?php echo $value['tel']; ?></td>
          <td align="center"><?php echo $value['fax'] ? $value['fax'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['createname'] ? $value['createname'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['date'] ? date("Y-m-d H:i" ,$value['date']) : '&nbsp'; ?></td>
          <td align="center">
				<a href="module.php?ac=setting&mod=contact&supplierid=<?php echo $value['id']; ?>">详情</a>
				&nbsp;
				<a href="module.php?ac=setting&mod=supplier_edit&id=<?php echo $value['id']; ?>">修改</a>
		  </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
    <label for="checkbox">全选</label>
    <label></label>
    <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
	<!--<input name="btnexport" type="submit" class="button" id="btnexport" value="导出">-->
  </form>
  <BR>
  <u>帮助</u><span class="p14">： </span>
  <ul>
    <li>删除供应商时，将删除供应商的所有信息，请谨慎操作</li>
	<li>包括：供应商联系人、供应产品等信息</li>
	<li>已经进货的物资信息也将会出现错误</li>
  </ul>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>

