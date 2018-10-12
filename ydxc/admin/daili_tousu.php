<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: sign_init.php 2010-01-12 13:27:57 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查

if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query("DELETE FROM ".tname('tousu')." WHERE id IN($aryid)");
	showmsg('代理申请删除成功！');
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
//$class_id = trim(isset($_POST['class_id']) ? $_POST['class_id'] : (isset($_GET['class_id']) ? $_GET['class_id'] : ''));
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">

  <DIV class=datacontainer2 style="WIDTH: 98%">
    <!--<DIV class=header><a href="module.php?ac=daili&mod=init_add" class="MustFill">添加新的班级</a></DIV>-->
    <form  method="post" name="FormEdit">
      &nbsp;搜索
    <input name="keywords" type="text" id="keywords" size="30" value="<?php echo $keywords; ?>">
	 &nbsp;
      <input name="button" type="submit" id="button" value="查询" class="button">
    </form>
      <form  method="post" name="formpage">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("微信昵称", "openid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("姓名", "openid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("联系电话", "openid", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("联系方式", "tel", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("投诉问题", "title", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("投诉建议内容", "content", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("提交时间", "inputtime", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center">详情</div></td>-->
          </tr>
<?php 
	$perpage = 15;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE 1=1";
	$keywords && $where .= " AND (name LIKE '%$keywords%' OR title LIKE '%$keywords%' OR tel LIKE '%$keywords%' OR remark LIKE '%$keywords%' )";
	//$class_id && $where .= " AND class_id LIKE '$class_id%'";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('tousu').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tousu')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());

while ($value = $_TGLOBAL['db']->fetch_array($query)) {	

?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <?php $weixin = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." WHERE openid='".$value['openid']."'");?>
            <td align="center"><?php echo $weixin['nickname']; ?></td>
            <td align="center"><?php echo $weixin['name']; ?></td>
            <td align="center"><?php echo $weixin['phone']; ?></td>
            <td align="center"><?php echo $value['content']; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i", $value['inputtime']); ?></td>
            <!--<td align="center"><a href="module.php?ac=daili&mod=edit&id=<?php echo $value['id']; ?>">详情</a></td>--->
          </tr>
<?php } ?>
        </tbody>
      </table>
      
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
       <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','删除');">
    </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>





  <?php include 'footer.php'; ?>
</BODY>
</HTML>