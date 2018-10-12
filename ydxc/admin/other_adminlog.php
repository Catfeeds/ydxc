<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_adminlog.php 2010-01-12 0:13:18 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['submitdeldays']) && isset($_POST['date_start']) && isset($_POST['date_end'])) {
	$date_start = strtotime($_POST['date_start']);
	$date_end = strtotime($_POST['date_end']);
	$where = " (date between '$date_start' and '$date_end')"; 
	$_TGLOBAL['db']->query('DELETE FROM '.tname('adminlog')." WHERE $where");
	showmsg('删除成功！');
}

if (isset($_POST['usage'])) {   
	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query('DELETE FROM '.tname('adminlog')." WHERE id IN($aryid)");
	showmsg('删除成功！', $_TGLOBAL['refer']);	 
}
$username = isset($_POST['username']) ? $_POST['username'] : (isset($_GET['username']) ? $_GET['username'] : '');
$date_start = isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : '');
$date_end = isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : '');
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
    <DIV class=header>管理员日志 </DIV>
    <form name="FormPage" method="post" action="">
    <div align="center">按用户查询： 
      <?php
$query = $_TGLOBAL['db']->query("SELECT username FROM ".tname('admin'));
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
<a href="module.php?ac=other&mod=adminlog&username=<?php echo $value['username']?>"><?php echo $value['username']?></a> 
<?php } ?>
      　　
      <?php
  //排序方式
	$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
	$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;
  
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);	
	
    $where = "";
    $username && $where = " WHERE (username='$username')";

    //处理日期段搜索
    if ($date_start && $date_end) {
		$date_start = strtotime($date_start); //转换输入的时间为时间戳的方式
		$date_end = strtotime($date_end);
		$where .= " AND (endtime between '$date_start' and '$date_end')"; 
    }
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('adminlog').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('adminlog')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());         
?>
      <input type="hidden" name="username" value="<?php echo $username?>">
      <br>
      删除<span class="p">: </span> 
      <input type="text" name="date_start" size="10" value="<?php echo $date_start?>" maxlength="10" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
      
      - 
      <input type="text" name="date_end" size="10" value="<?php echo $date_end?>" maxlength="10" onclick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
		
	  所有的日志
      <input type="submit" name="submitdeldays" value="删除">
    </div>
    <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tr bgcolor="#F1F5FE"> 
        <td width="18%" align="center" class="caption"><div align="center">登录用户</div></td>
        <td width="19%" align="center" class="caption"><div align="center">登录IP地址</div></td>
        <td width="25%" align="center" class="caption"><div align="center">登录日期</div></td>
        <td width="31%" align="center" class="caption"><div align="center">操作</div></td>
        <td width="7%" align="center" class="caption"><div align="center">选择</div></td>
      </tr>
      <?php
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
      <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';"> 
        <td width="18%"> 
          <?php echo $value['username']?>        </td>
        <td width="19%"> <a href="http://<?php echo $value['ip']?>" target="_blank">
          <?php echo $value['ip']?>
          </a> </td>
        <td width="25%"> 
          <?php echo date("Y-m-d H:i", $value['date']);?>        </td>
        <td width="31%"><a href="<?php echo $value['url']?>" target="_blank"> 
          <?php echo sub_url($value['url'], 40)?>
          </a></td>
        <td width="7%" align="center"><input type="checkbox" name="itemid[]" value="<?php echo $value['id'];?>"></td>
      </tr>
      <?php } ?>
      <tr> 
        <td colspan="5" align="center"><input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
          <label for="checkbox">全选</label>
          <input name="usage" type="submit" class="button" id="usage" value="删除"  onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
          </td>
      </tr>
    </table>
  </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div></DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>