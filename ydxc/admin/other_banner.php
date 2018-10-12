<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: news_news.php 2010-01-12 13:27:57 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查

if (isset($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);

	 switch($_POST['dowhat']) {

		 case 'delete' :
				//删除图片
				$query = $_TGLOBAL['db']->query("SELECT img FROM ".tname('banner')." WHERE id IN($aryid)");
				while ($value = $_TGLOBAL['db']->fetch_array($query)) {
					file_exists('.'.$value['img']) && unlink('.'.$value['img']);
					file_exists('.'.$value['img'].'.thumb.jpg') && unlink('.'.$value['img'].'.thumb.jpg');
				}	 
				$_TGLOBAL['db']->query("DELETE FROM ".tname('banner')." WHERE id IN($aryid)");
			 break;

	}
	showmsg('删除焦点图成功！');
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

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
    <DIV class=header><a href="module.php?ac=other&mod=banner_add" class="MustFill">添加新的焦点图</a></DIV>
      <form  method="post" name="formpage">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("标题", "title", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("链接", "link", $field, $order); ?></div></td>
            
            <td class="caption"><div align="center"><?php echo GetOrder("缩略图", "img", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("显示", "display", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("发布日期", "date", $field, $order); ?></div></td>
			<td class="caption"><div align="center"><?php echo GetOrder("显示顺序", "orderlist", $field, $order); ?></div></td>
            <td class="caption"><div align="center">修改</div></td>
          </tr>
<?php 
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE 1=1";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('banner').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('banner')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());

while ($value = $_TGLOBAL['db']->fetch_array($query)) {	

?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td align="center"><?php echo $value['title'] ? $value['title'] :'-'; ?></td>
            <td align="center"><?php echo $value['link'] ? $value['link'] :'-'; ?></td>
			<td align="center"><b><font color="#CC0033"><?php echo $value['img'] ? "√" : "&nbsp;"; ?></font></b></td>
            <td align="center"><?php echo $value['is_hidden'] ? '不显示' : '显示'; ?></td>
            <td align="center"><?php echo $value['orderlist'] ? $value['orderlist'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i", $value['date']); ?></td>
            <td align="center"><a href="module.php?ac=other&mod=banner_add&id=<?php echo $value['id']; ?>">修改</a></td>
          </tr>
<?php } ?>
        </tbody>
      </table>
      
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
      <input name="dowhat" type="radio" id="delete" value="delete">
      <label for="delete">删除</label>
       <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="提交" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>