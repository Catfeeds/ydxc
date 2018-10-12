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
	$_TGLOBAL['db']->query("DELETE FROM ".tname('sign')." WHERE id IN($aryid)");
	showmsg('报名删除成功！');
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
    <!--<DIV class=header><a href="module.php?ac=sign&mod=init_add" class="MustFill">添加新的班级</a></DIV>-->
    <form  method="post" name="FormEdit">
      &nbsp;搜索
    <input name="keywords" type="text" id="keywords" placeholder="姓名，手机" size="30" value="<?php echo $keywords; ?>">
      <input name="button" type="submit" id="button" value="查询" class="button">
    </form>
      <form  method="post" name="formpage">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("ID", "id", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("订单编号", "sn", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("班级", "courseid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("学员姓名", "name", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("性别", "sex", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("学员手机", "mobile", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("报考教练", "coach_id", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("是否缴费", "ispay", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("价格", "money", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("身份证", "cardno", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("推荐人", "inv", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("地址", "area", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("缴费时间", "paydate", $field, $order); ?></div></td>-->
            <!--<td class="caption"><div align="center"><?php echo GetOrder("报名时间", "date", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center">更换</div></td>
          </tr>
<?php 
	$perpage = 15;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE ispay=1";
	$keywords && $where .= " AND (name LIKE '%$keywords%' OR sn='$keywords' OR mobile='$keywords')";
	//$class_id && $where .= " AND class_id LIKE '$class_id%'";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('sign').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());

while ($value = $_TGLOBAL['db']->fetch_array($query)) {
	$coach = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$value['coach_id']);
	$value['coach_name'] = $coach['xingming'];
	if(!empty($value['inv'])){
		$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$value['inv']);
		$value['captain_name'] = $captain['name'];
		if(!empty($captain['cptid'])){
			$duiyuan = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$captain['cptid']);
			$value['duiyuan_name'] = $duiyuan['name'];
		}
	}
	
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td align="center"><?php echo $value['id']; ?></td>
            <!--<td style="padding-left: 10px;"><?php echo $value['sn']; ?></td>-->
            <td align="center"><?php echo $value['courseid'] ? $_TGLOBAL['course'][$value['courseid']]['name'] : '&nbsp'; ?></td>
            <td align="center"><?php echo $value['name']; ?></td>
            <!--<td align="center"><?php echo $value['sex'] ? $_TGLOBAL['setting']['sex'][$value['sex']] : ''; ?></td>-->
            <td align="center"><?php echo $value['mobile']; ?></td>
            <td align="center"><?php echo $value['coach_name']; ?></td>
            <!--<td align="center"><?php echo $value['ispay'] ? '是' : '否'; ?></td>
            <td align="center"><?php echo $value['ispay'] ? $value['money'] : '-'; ?></td>
            <td align="center"><?php echo $value['cardno']; ?></td>
            <td align="center"><?php echo $value['duiyuan_name'].'.'.$value['captain_name']; ?></td>
            <td align="center"><?php echo $value['area']; ?></td>-->
            <!--<td align="center"><?php echo $value['ispay'] ? date("Y-m-d H:i", $value['paydate']) : '-'; ?></td>-->
            <!--<td align="center"><?php echo date("Y-m-d H:i", $value['date']); ?></td>-->
            <td align="center"><a href="module.php?ac=change&mod=edit&id=<?php echo $value['id']; ?>">更换</a></td>
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