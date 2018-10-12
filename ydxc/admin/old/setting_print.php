<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状
loadcache('store'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目
loadcache('brand'  ,'id', '', 'orderlist');   

//include_once(S_ROOT.'./lib/function/function_cache.php');
if (isset($_POST['prints'])) {
	$aryid = simplode($_POST['itemid']);
	
	//echo $aryid;
	//header("Location: module.php?ac=setting&mod=print_mas&ids=$aryid"); 
}

//排序方式
$field = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : '' ));
$date_start = trim(isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : '' ));
$date_end = trim(isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : '' ));
$brandid  = trim(isset($_POST['brandid']) ? $_POST['brandid'] : (isset($_GET['brandid']) ? $_GET['brandid'] : '' ));
$isused   = trim(isset($_POST['isused']) ? $_POST['isused'] : (isset($_GET['isused']) ? $_GET['isused'] : '' ));
$storeid  = trim(isset($_POST['storeid']) ? $_POST['storeid'] : (isset($_GET['storeid']) ? $_GET['storeid'] : '' ));
$itype    = trim(isset($_POST['itype']) ? $_POST['itype'] : (isset($_GET['itype']) ? $_GET['itype'] : '' ));
$crib_graded      = trim(isset($_POST['crib_graded']) ? $_POST['crib_graded'] : (isset($_GET['crib_graded']) ? $_GET['crib_graded'] : '' ));
$classid  = trim(isset($_POST['classid']) ? $_POST['classid'] : (isset($_GET['classid']) ? $_GET['classid'] : '' ));

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
<script language="JavaScript" src="js/selectTime.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
	  
	  <!--<DIV class=header><a href="module.php?ac=setting&mod=name_add">添加物资名录</a> </DIV>-->
	  <DIV class=header><a href="module.php?ac=setting&mod=name_addclassid">添加物资名录</a> </DIV>
    <form  name="myform" method="post" name="FormEdit1" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
	  
    <!--&nbsp;
    关键词：<input placeholder="关键词" name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
    &nbsp;
    录入日期：<input placeholder="" name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd');">
    -
    <input placeholder="" name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd');">-->
	&nbsp;
		条形码类别：<?php 
		echo makeselect($_TGLOBAL['setting']['barcode_itype'],'itype', $itype,'','', '','条码类别', '') ;?>
	&nbsp;
    请选择仓库：
	<?php 
		echo makeselect((array)$_TGLOBAL['tree_store'],'storeid', $storeid,'','name', 'id','请选择仓库', '', 1) ;?>
	&nbsp;
		物资类别：<?php 
		echo makeselect((array)$_TGLOBAL['tree_class'],'classid', $classid,'','name', 'id','选择物资类别', '0', 1) ;?>
	&nbsp;
		物资级别：<?php 
		echo makeselect($_TGLOBAL['setting']['crib_graded'],'crib_graded', $crib_graded,'','', '','物资级别', '') ;?>
	&nbsp;
		品牌：<?php 
		echo makeselect((array)$_TGLOBAL['brand'],'brandid', $brandid,'','name', 'id','选择品牌', '0', 1) ;?>
	&nbsp;
		是否使用：<?php 
		echo makeselect($_TGLOBAL['setting']['isused'],'isused', $isused,'','', '','是否使用', '') ;?>
	&nbsp;
    <input name="button" type="submit" id="button" value="查询" class="button">
	
	
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("条码类别", "itype", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("条码名称", "name", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("条形码", "barcode", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("是否使用", "isused", $field, $order); ?></div></td>
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

	$str = '';
	if ($itype) {
		if($itype == 1){ // 1-仓库
			$str .= '%c%';
		}elseif($itype == 2){ // 2-垛位
			$str .= '%d%';
		}elseif($itype == 3){ // 3-物资名录
			$str .= '%n%';
		}elseif($itype == 4){ // 4-物资
			$str .= '%w%';
		}
	}
	
	//仓库  垛位才有的编码
	if($storeid){
		$str .= '%c'.str_repeat(0,3 - strlen($storeid)).$storeid.'%';
	}
	
	//物资分类  物资名录、物资都有的
	if($classid){
		$str .= '%l'.str_repeat(0,4 - strlen($classid)).$classid.'%';
	}
	
	//品牌编号  物资名录、物资都有的
	if($brandid){
		$str .= '%p'.str_repeat(0,4 - strlen($brandid)).$brandid.'%';
	}
	
	//物资级别  物资才有的
	if($crib_graded){
		$str .= '%j'.str_repeat(0,2 - strlen($crib_graded)).$crib_graded.'%';
	}
	
	$str    && $where .= " AND barcode LIKE '$str' ";
	if(isset($isused) && $isused!=''){
		$where .= " AND isused = '$isused' ";
	}
	
	
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('barcode')." ".$where), 0);	
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('barcode')." $where  ORDER BY $field $order LIMIT $start,$perpage");
	@$multi = multi($count, $perpage, $page, get_current_url());
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
          <td align="center"><?php echo $value['itype'] ? $_TGLOBAL['setting']['barcode_itype'][$value['itype']] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['barcode'] ; ?></td>
          <td align="center"><?php echo $value['name'] ; ?></td>
		  <td align="center"><?php echo $value['isused'] ? $_TGLOBAL['setting']['isused'][$value['isused']] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['createname'] ? $value['createname'] : '&nbsp;'; ?></td>
          <td align="center"><?php echo $value['date'] ? date("Y-m-d H:i" ,$value['date']) : '&nbsp'; ?></td>
          <td align="center"><a href="module.php?ac=setting&mod=print_tiaoxingma&id=<?php echo $value['id'] ;?>&id=<?php echo $value['id']; ?>">打印</a></td>
        </tr>
        <?php } ?>
      </table>
		<input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
		<label for="checkbox">全选</label>
		&nbsp;&nbsp;
		<input name="prints" type="submit" class="button" id="prints" value="打印" onclick="myform.action='module.php?ac=setting&mod=print_mas';myform.submit();target='_blank'"  target="_blank">
    </form>

  <br/>
  <u>帮助</u><span class="p14">： </span>
  <ul>
    <li>每次生成条形码很浪费系统资源，所以每次最多生成本页的条形码。</li>
  </ul>
	
	<div align="center"><span class="page"><?php echo $multi; ?></span></div>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>