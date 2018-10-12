<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_list.php 2010-6-9 20:01:11 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if(isset ($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);

    $query = $_TGLOBAL['db']->query("SELECT ID, CustomerID FROM ".tname('members')." WHERE id IN($aryid)");									
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        $_TGLOBAL['db']->query("DELETE FROM ".tname('member_money')." WHERE userid = '$value[ID]'");
    } 
	$_TGLOBAL['db']->query("DELETE FROM ".tname('members')." WHERE id IN($aryid)");
	showmsg('会员操作成功！');
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
  <DIV class=header>会员管理 </DIV>
  <form  method="post" name="FormEdit">
    &nbsp;
    <input placeholder="关键词" name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
    &nbsp;
    <input placeholder="电话" name="CusPhone" type="text" id="CusPhone" value="<?php echo $CusPhone; ?>" size="30">
    &nbsp;
    <input placeholder="openid" name="openid" type="text" id="openid" value="<?php echo $openid; ?>" size="30">
    &nbsp;
    <input placeholder="姓名" name="CusName" type="text" id="CusName" value="<?php echo $CusName; ?>" size="30">
    <!--<span class="p"> </span>-->
    <input placeholder="注册日期" name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
  
    -
    <input placeholder="注册日期" name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">

    级别
    <?php GetSelect($_TGLOBAL['member_group'], 'usertype', $usertype, 'name', 'onChange="this.form.submit();"'); ?>
    <input name="button" type="submit" id="button" value="查询" class="button">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("客户ID", "CustomerID", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("级别", "usertype", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("openid", "openid", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("姓名", "CusName", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("电话", "CusPhone", $field, $order); ?></div></td>
          <!---<td class="caption"><div align="center"><?php echo GetOrder("车辆牌照", "PlateNumber", $field, $order); ?></div></td>--->
          <td class="caption"><div align="center"><?php echo GetOrder("余额", "Balance", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("账户状态", "Status", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("性别", "Sex", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("年龄", "Age", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("地区", "zone", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("注册时间", "LogTime", $field, $order); ?></div></td>
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
		$where .= " CustomerID LIKE '%$keywords%'";
		$where .= " OR CusName LIKE '%$keywords%'";//
		$where .= " OR CusPhone LIKE '%$keywords%'";//
		$where .= " OR PlateNumber LIKE '%$keywords%'";
		$where .= " OR openid LIKE '%$keywords%' ";
		$where .= " OR zone LIKE '%$keywords%')";
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
		$where .= " AND (LogTime between '$date_start' and '$date_end')"; 
    }
	
	$usertype && $where .= " AND usertype='$usertype'";
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('members')." ".$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT m.* FROM ".tname('members')." m
										
										$where ORDER BY $field $order LIMIT $start,$perpage");//LEFT JOIN ".tname('member_car')." mc ON m.CustomerID = mc.CustomerID
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
								$value['LogTime'] ? date("Y-m-d H:i" ,$value['LogTime']) : '',
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
          <td><?php echo $value['CustomerID']; ?></td>
          <td align="center"><?php echo $_TGLOBAL['member_group'][$value['usertype']]['name']; ?></td>
          <td align="center"><?php echo $value['Openid']; ?></td>
          <td align="center"><?php echo $value['CusName'] ? $value['CusName'] : '-'; ?></td>
          <td align="center"><?php echo $value['CusPhone'] ? $value['CusPhone'] : '-'; ?></td>
          <!---<td align="center"><?php echo $value['PlateNumber'] ? $value['PlateNumber'] : '-'; ?></td>--->
          <!---<td align="center"><?php echo $value['CarNumber'] ? $value['CarNumber'] : '-'; ?></td>--->
          <td align="center"><a href="module.php?ac=member&mod=money&keywords=<?php echo $value['CustomerID'] ?>"><?php echo $value['Balance'] ? $value['Balance'] : '&nbsp;'; ?></a></td>
          <td align="center"><?php echo $_TGLOBAL['setting']['member_Status'][$value['Status']]; ?></td>
          <td align="center"><?php echo $value['Sex'] ? $_TGLOBAL['setting']['gender'][$value['Sex']] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['Age'] ? $value['Age'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['zone'] ? $value['zone'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['LogTime'] ? date("Y-m-d H:i" ,$value['LogTime']) : '&nbsp'; ?></td>
          <td align="center"><a href="module.php?ac=member&mod=list_work&id=<?php echo $value['id']; ?>">修改</a></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
    <label for="checkbox">全选</label>
    <label></label>
    <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
	<input name="btnexport" type="submit" class="button" id="btnexport" value="导出">
  </form>
  <BR>
  <u>帮助</u><span class="p14">： </span>
  <ul>
    <li>删除会员时，将删除会员的所有信息，请谨慎操作</li>
	<li>包括：签到记录、进出场记录、充值记录、车辆信息、用户剩余信息、支付记录</li>
  </ul>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>

