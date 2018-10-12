<?php
/*
	[CTB] (C) 2007-2009 
	$Id: money_scjf.php 2012-1-19 13:53:56 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if(isset ($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	 $_TGLOBAL['db']->query("DELETE FROM ".tname('member_money')." WHERE id IN($aryid)");
	showmsg('删除操作成功！', $_TGLOBAL['refer']);
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
$money_op = trim(isset($_POST['money_op']) ? $_POST['money_op'] : (isset($_GET['money_op']) ? $_GET['money_op'] : ''));
$date_start = trim(isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : ''));
$date_end = trim(isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : ''));

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
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>用户余额列表</DIV>
    <form  method="post" name="FormEdit">
      &nbsp;关键词搜索
        <input name="keywords" type="text" id="keywords" size="30" value="<?php echo $keywords; ?>">
        <span class="p">日期 </span>
        <input name="date_start" type="text" value="<?php echo isset($_POST['date_start']) ?$_POST['date_start'] : ''; ?>" size="10" maxlength="10"  onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
-
<input name="date_end" type="text" value="<?php echo isset($_POST['date_end']) ? $_POST['date_end'] : ''; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');" >
操作类型
        <?php GetSelect((array)$_TGLOBAL['setting']['member_money_op'], 'money_op', $money_op, '', 'onChange="this.form.submit();"'); ?>
      <input name="button" type="submit" id="button" value=" 查询 ">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("微信订单号", "weixin_orderno", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("订单流水号", "date", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("客户ID", "CustomerID", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("操作用户", "userid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("操作类型", "op", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("操作余额", "money ", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("当前余额", "cur_money", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("操作日期", "date", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("备注", "remark", $field, $order); ?></div></td>
          </tr>
<?php 
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = ' WHERE 1';
	$keywords && $where .= " AND (m.CusName LIKE '%$keywords%' or m.CustomerID LIKE '%$keywords%')"; // OR s.remark LIKE '%$keywords%'
	$money_op && $where .= " AND op='$money_op'";
		
	//处理日期段搜索
    if ($date_start && $date_end) {
		$where .= " AND date >= UNIX_TIMESTAMP('{$date_start} 00:00:00') AND date <= UNIX_TIMESTAMP('{$date_end} 23:59:59')"; 
    }
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('member_money')." s
										LEFT JOIN ".tname('members')." m ON s.userid=m.id
										".$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT s.*, m.CusName, m.CustomerID
										FROM ".tname('member_money')." s
										LEFT JOIN ".tname('members')." m ON s.userid=m.id
										$where ORDER BY s.$field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	

	if (isset($_POST['btnexport'])) { //导出
		$query = $_TGLOBAL['db']->query("SELECT s.*, m.CusName, m.CustomerID
											FROM ".tname('member_money')." s
											LEFT JOIN ".tname('members')." m ON s.userid=m.id
											$where ORDER BY s.$field $order ");
		$arytitle = array('     微信订单号     ','        订单流水号        ','客户ID','操作用户','操作类型','操作余额','当前余额','操作日期','备注');
		$arydata  = array();
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			  $arydata[] = array(
								$value['weixin_orderno'],	
								$value['CustomerID'].date("YmdHis",$value['date']).str_repeat('0',5-strlen($value['id'])).$value['id'],
								$value['CustomerID'],							
								$value['CusName'],							
								$_TGLOBAL['setting']['member_money_op'][$value['op']],							
								$value['money'] ? $value['money'] : '-',
								$value['cur_money'] ? $value['cur_money'] : '-',
								$value['date'] ? date("Y-m-d H:i", $value['date']) : '',
								$value['remark'],
							  );
		}
		ob_end_clean();//清除缓冲区,避免乱码
		header("Content-type: text/html;charset=utf-8;");
		header('Content-Type: application/vnd.ms-excel;charset=utf-8;');
		$filename = '支付记录';
		//echo $filename;die;
		makeexcel($filename, $arytitle, $arydata); //文件名，标题数组，数据数组
		die;
	}

	
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td align="center"><?php echo $value['weixin_orderno'] ? $value['weixin_orderno'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo $value['CustomerID'].date("YmdHis",$value['date']).str_repeat('0',5-strlen($value['id'])).$value['id'] ; ?></td>
            <td align="center"><?php echo $value['CustomerID'] ? $value['CustomerID'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo $value['CusName'] ? $value['CusName'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo $_TGLOBAL['setting']['member_money_op'][$value['op']]; ?> </td>
            <td align="center"><?php echo $value['money'] ? $value['money'] : '-'; ?></td>
            <td align="center"><?php echo $value['cur_money'] ? $value['cur_money'] : '-'; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i", $value['date']); ?></td>
            <td align="center"><?php echo $value['remark'] ? $value['remark'] : '&nbsp;'; ?></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
	  
      <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
	  <input name="btnexport" type="submit" class="button" id="btnexport" value="导出">
    </form>
    <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>

