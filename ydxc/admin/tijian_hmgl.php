<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: tj_code_info_tj_code_info.php 2010-01-12 13:27:57 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
header("Content-Type: text/html; charset=UTF-8");
loadcache('news_class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

//权限检查
checkpermission(); //权限检查

if (isset($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);

	 switch($_POST['dowhat']) {

		 case 'delete' :
				//删除图片
				$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tj_code_info')." WHERE id IN($aryid)");
				while ($value = $_TGLOBAL['db']->fetch_array($query)) {
					file_exists('.'.$value['img']) && unlink('.'.$value['img']);
					file_exists('.'.$value['img'].'.thumb.jpg') && unlink('.'.$value['img'].'.thumb.jpg');
				}	 
				$_TGLOBAL['db']->query("DELETE FROM ".tname('tj_code_info')." WHERE id IN($aryid)");
			 break;

		 case 'display' :
			  $_TGLOBAL['db']->query("UPDATE ".tname('tj_code_info')." SET display=1 WHERE id IN($aryid)");
			  break;

		 case 'nodisplay' :
			 $_TGLOBAL['db']->query("UPDATE ".tname('tj_code_info')." SET display=0 WHERE id IN($aryid)");
			 break;

		 case 'move' :
			$_TGLOBAL['db']->query("UPDATE ".tname('tj_code_info')." SET class_id='$_POST[class_id]' WHERE id IN($aryid)");
			 break;
	}
	showmsg('内容操作成功！');
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
$class_id = trim(isset($_POST['class_id']) ? $_POST['class_id'] : (isset($_GET['class_id']) ? $_GET['class_id'] : ''));
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


<table width="100%" border="0" align="center" >
  <tr>
	<td width="15%" valign="top">
	
	
	
	
	
<!--<table width="100%" border="0" class="tab_01">
<?php
$tree = $_TGLOBAL['tree_tj_code_info_class'];
if($tree){
	foreach($tree as $key=>$val){
		$html = '';
		if($val['sort']){
			$html = '&nbsp;&nbsp;'.$val['html'];
		}
		//if($val['pid']){
			echo "<tr><td align='left'><a href='module.php?ac=tj_code_info&mod=li&class_id=$val[id]' style='text-decoration: none;'>$html $val[name]</a></td></tr>";
		//}else{
		//	echo "<tr><td align='left'>$html $val[name]</td></tr>";
		//}
	}
}else{
	echo "<tr><td align='left'>暂无栏目信息</td></tr>";
}
?>
   </table>-->
	
	



  <DIV class=datacontainer2 style="WIDTH: 98%">
    <!--<DIV class=header><a href="module.php?ac=tijian&mod=add" class="MustFill">添加新的体检号</a></DIV>-->
    <form  method="post" name="FormEdit">
      &nbsp;搜索
    <input name="keywords" type="text" id="keywords" size="30" placeholder="体检原码，体检新码" value="<?php echo $keywords; ?>">
	&nbsp;
	
      <input name="button" type="submit" id="button" value="查询" class="button">
    </form>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="button" class="button" onclick="dcqb()" value="导出全部" />
    <input type="button" name="button" class="button" onclick="dcby()" value="导出本页" />
      <form  method="post" name="formpage">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("id", "id", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("体检原码", "tj_code", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("随机码", "rand_code", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("体检新码", "tj_new_code", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("录入时间", "inputtime", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("发放时间", "putouttime", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("是否分配", "is_use", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("所属机构", "belong_to", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("申请人", "", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("申请人电话", "", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("申请时间", "", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center">修改</div></td>-->
          </tr>
<?php 
	$perpage = 15;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE 1=1";
	$keywords && $where .= " AND (tj_code='$keywords' OR tj_code_new='$keywords')";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('tj_code_info').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tj_code_info')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());

while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
	 $check = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('check')." where old_code='".$value['tj_code']."'");
	 $openid = $check['openid'];
	 $wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." where openid='".$openid."'");
	 if(empty($wx_user['name'])){
	 	$value['stu_name'] = '-';
	 } else {
		 $value['stu_name'] = $wx_user['name'];
	 }
	 if(empty($wx_user['phone'])){
	 	$value['stu_phone'] = '-';
	 } else {
	 	$value['stu_phone'] = $wx_user['phone'];
	 }
	 if(empty($check['inputtime'])){
	 	$value['stu_inputtime'] = '-';
	 } else {
		 $value['stu_inputtime'] = $check['inputtime'];
	 }

?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td align="center"><?php echo $value['id']; ?></td>
            <td align="center"><?php echo $value['tj_code'];?></td>
            <td align="center"><?php echo $value['rand_code'];?></td>
            <td align="center"><?php echo $value['tj_code_new'] ? $value['tj_code_new'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i",$value['inputtime']) ; ?></td>
            <!--<td align="center"><?php echo date("Y-m-d H:i",$value['putouttime']); ?></td>-->
            <td align="center"><?php if($value['is_use']==1){echo '未分配';}else{echo '已分配';} ?></td>
           <?php
           		$sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news_class')." where id=".$value['belong_to']);
				$belong_to = $_TGLOBAL['db']->fetch_array($sql);
           	?>
            <td align="center"><?php echo $belong_to['name']; ?></td>
            <td align="center"><?php echo $value['stu_name'];?></td>
            <td align="center"><?php echo $value['stu_phone'];?></td>
            <td align="center"><?php echo date("Y-m-d H:i",$value['stu_inputtime']);?></td>
            <!--<td align="center"><a href="module.php?ac=tijian&mod=add&id=<?php echo $value['id']; ?>">修改</a></td>-->
          </tr>
<?php } ?>
        </tbody>
      </table>
      
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
      <input name="dowhat" type="radio" id="delete" value="delete">
      <label for="delete">删除</label>
       <input type="radio" name="dowhat" id="display" value="display">
      <label for="mov">移动至</label>
<?php
echo makeselect((array)$_TGLOBAL['tree_tj_code_info_class'],'class_id', $class_id,'datatype="Require" msg="请选择栏目"','name', 'id','请选择栏目', '0', 1);?> 
       <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="提交" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
    </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>

	<script type="text/javascript">
		function dcqb(){
			window.location.href="/index.php?do=dc_tijian";
		}
		
		function dcby(){
			window.location.href="/index.php?do=dc_tijian&page=<?php echo $page ?>";
		}
	</script>


  <?php include 'footer.php'; ?>
</BODY>
</HTML>