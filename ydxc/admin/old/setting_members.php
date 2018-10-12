<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: members.php 2009-6-14 17:54:52 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查
loadcache('ment'  ,'id', '', 'orderlist');   // 加载缓存树状

//include_once(S_ROOT.'./lib/function/function_cache.php');
			 
if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	
	//判断判断成员有没有未归还的物资
    $query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('use_detail')." WHERE membersid IN($aryid) AND state=1 ");
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        showmsg('该成员有领用物资未归还，不能删除！', $_TGLOBAL['refer']);
    } 
	
	$_TGLOBAL['db']->query("DELETE FROM ".tname('members')." WHERE id IN($aryid)");
	showmsg('删除人员成功！', $_TGLOBAL['refer']);
}

//排序方式
$field = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : '' ));
$date_start = trim(isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : '' ));
$date_end = trim(isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : '' ));
$mentid   = trim(isset($_POST['mentid']) ? $_POST['mentid'] : (isset($_GET['mentid']) ? $_GET['mentid'] : '' ));
$sex      = trim(isset($_POST['sex']) ? $_POST['sex'] : (isset($_GET['sex']) ? $_GET['sex'] : '' ));
$usertype = trim(isset($_POST['usertype']) ? $_POST['usertype'] : (isset($_GET['usertype']) ? $_GET['usertype'] : '' ));
$CusPhone = trim(isset($_POST['CusPhone']) ? $_POST['CusPhone'] : (isset($_GET['CusPhone']) ? $_GET['CusPhone'] : ''));
$openid   = trim(isset($_POST['openid']) ? $_POST['openid'] : (isset($_GET['openid']) ? $_GET['openid'] : '' ));
$CusName  = trim(isset($_POST['CusName']) ? $_POST['CusName'] : (isset($_GET['CusName']) ? $_GET['CusName'] : ''));

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
  <DIV class=header><a href="module.php?ac=setting&mod=members_add" class="MustFill">添加新的人员</a> </DIV>
  <form  method="post" name="FormEdit">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
	
    &nbsp;
    关键词：<input placeholder="关键词" name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
    &nbsp;
    <!--<input placeholder="电话" name="CusPhone" type="text" id="CusPhone" value="<?php echo $CusPhone; ?>" size="30">
    &nbsp;
    <input placeholder="openid" name="openid" type="text" id="openid" value="<?php echo $openid; ?>" size="30">
    &nbsp;
    <input placeholder="姓名" name="CusName" type="text" id="CusName" value="<?php echo $CusName; ?>" size="30">
    <span class="p"> </span>
    <input placeholder="注日期" name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
  
    -
    <input placeholder="注册日期" name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">-->
    部门：
    <?php 
		$mentid = isset($mentid) ? $mentid : '' ;
		echo makeselect($_TGLOBAL['ment'], 'mentid', $mentid, 'datatype="Require" msg="请选择部门名称."', 'name', 'id', '请选择部门') ;
	?>
	&nbsp;
	性别：
    <?php 
		$sex = isset($sex) ? $sex : '' ;
		echo makeselect($_TGLOBAL['setting']['sex'], 'sex', $sex, 'datatype="Require" msg="请选择性别."', '','', '请选择性别') ;
	?>
	&nbsp;
    <input name="button" type="submit" id="button" value="查询" class="button">
	
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("部门名称", "mentid", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("姓名", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("性别", "sex", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("电话", "tel", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("手机", "mobile", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("邮箱", "email", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("QQ", "qq", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("职位", "office", $field, $order); ?></div></td>
          <!--<td class="caption"><div align="center">是否显示</div></td>
          <td class="caption"><div align="center">显示方式</div></td>-->
          <td class="caption"><div align="center"><?php echo GetOrder("创建人", "userid", $field, $order); ?></div></td>
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
		$where .= " OR tel LIKE '%$keywords%'";//
		$where .= " OR mobile LIKE '%$keywords%'";//
		$where .= " OR qq LIKE '%$keywords%'";
		$where .= " OR email LIKE '%$keywords%' ";
		$where .= " OR office LIKE '%$keywords%' ";
		$where .= " OR descript LIKE '%$keywords%' ";
		$where .= " OR remark LIKE '%$keywords%')";
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
	
	if ($sex) {
		$where .= " AND sex LIKE '%$sex%' ";
	}
	
	if ($mentid) {
		$where .= " AND mentid LIKE '%$mentid%' ";
	}
	
    //处理日期段搜索
    if ($date_start && $date_end) {
		$date_start = strtotime($date_start.' 00:00:00'); //转换输入的时间为时间戳的方式
		$date_end = strtotime($date_end. ' 23:59:59');
		$where .= " AND (date between '$date_start' and '$date_end')"; 
    }
	
	$usertype && $where .= " AND usertype='$usertype'";
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('members')." ".$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT m.* FROM ".tname('members')." m
										$where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());



	if (isset($_POST['btnexport'])) { //导出
		$query = $_TGLOBAL['db']->query("SELECT m.* FROM ".tname('members')." m 
											$where ORDER BY $field $order ");
		$arytitle = array('客户ID','级别','openid','姓名','电话','余额','账户状态','性别','年龄','地区','注册时间');
		$arydata  = array();
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			  $arydata[] = array(
								$value['CustomerID'],							
								$_TGLOBAL['member_group'][$value['usertype']]['name'],							
								$value['Openid'],							
								$value['CusName'],							
								$value['CusPhone'],								
								$value['Balance'],
								$_TGLOBAL['setting']['member_Status'][$value['Status']],
								$_TGLOBAL['setting']['gender'][$value['Sex']],
								$value['Age'],
								$value['zone'],
								$value['date'] ? date("Y-m-d H:i" ,$value['date']) : '',
							  );
		}
		ob_end_clean();//清除缓冲区,避免乱码
		header("Content-type: text/html;charset=utf-8;");
		header('Content-Type: application/vnd.ms-excel;charset=utf-8;');
		$filename = '会员管理列表';
		//echo $filename;die;
		makeexcel($filename, $arytitle, $arydata); //文件名，标题数组，数据数组
		die;
	}

	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	

?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo $_TGLOBAL['ment'][$value['mentid']]['name']; ?></td>
          <td align="center"><?php echo $value['name']; ?></td>
          <td align="center"><?php echo $_TGLOBAL['setting']['sex'][$value['sex']]; ?></td>
          <td align="center"><?php echo $value['tel']; ?></td>
          <td align="center"><?php echo $value['mobile']; ?></td>
          <td align="center"><?php echo $value['email']; ?></td>
          <td align="center"><?php echo $value['qq']; ?></td>
          <td align="center"><?php echo $value['office']; ?></td>
		  <td align="center"><?php echo $value['createname']; ?></td>
		  <td align="center"><?php echo date("Y-m-d H:i" ,$value['date']); ?></td>
          <td align="center"><a href="module.php?ac=setting&mod=members_edit&id=<?php echo $value['id']; ?>">修改</a></td>
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
    <li>如果机构成员有领用物资未归还则不能删除。</li>
    <li>删除机构成员，会引起以前成员的领用归还信息，请谨慎操作。</li>
  </ul>
  
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
