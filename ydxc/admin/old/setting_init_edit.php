<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状
loadcache('brand'  ,'id', '', 'orderlist');  
loadcache('supplier'  ,'id', '', 'orderlist');  

//include_once(S_ROOT.'./lib/function/function_cache.php');
//$classid = isset($_GET['classid']) ? (int)$_GET['classid'] : (isset($_POST['classid']) ? (int)$_POST['classid'] : 0);


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
				
				'nameid'           => 	$_POST['nameid'],
				'classid'          => 	$_POST['classid'],
				'brandid'          => 	$_POST['brandid'],
				'num'              => 	$_POST['num'],
				'getdate'          => 	strtotime($_POST['getdate']),
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],

				);
		inserttable('product_init', $grouparr);
		//showmsg('物资属性添加成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资初始化添加成功！', 'module.php?ac=setting&mod=init');

	} else { //更新

		$grouparr = array(
				'nameid'           => 	$_POST['nameid'],
				'classid'          => 	$_POST['classid'],
				'brandid'          => 	$_POST['brandid'],
				'num'              => 	$_POST['num'],
				'getdate'          => 	strtotime($_POST['getdate']),
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],

				);
		updatetable('product_init', $grouparr, array('id' => $id));
		//showmsg('物资属性修改成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资初始化修改成功！', 'module.php?ac=setting&mod=init');

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('product_init')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$storename = getcount('store', array('id'=>$departmentid), 'name');
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/jquery.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/jsAddress.js"></script>
<script language="JavaScript" src="js/selectTime.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>物资供应管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <!--<tr>
            <td width="22%" class="caption">供应商</td>
            <td width="78%"> <?php 
				$supplierid = isset($supplierid) ? $supplierid : 0 ;
				echo makeselect((array)$_TGLOBAL['supplier'],'supplierid', $supplierid,'datatype="Require" msg="请选择供应商."','name', 'id','选择供应商', '', 1) ;?></td>
          </tr>-->
          <tr>
            <td width="22%" class="caption"><!--<span class="font_red">*</span>-->类别名称</td>
            <td width="78%"> <?php 
				$classid = isset($classid) ? $classid : 0 ;
				//echo makeselect((array)$_TGLOBAL['tree_class'],'classid', $classid,'datatype="Require" msg="选择物资类别."','name', 'id','选择物资类别', '', 1) ;
				echo $_TGLOBAL['tree_class'][$classid]['name'];
				?></td>
          </tr>
          <tr>
            <td width="22%" class="caption"><!--<span class="font_red">*</span>-->品牌</td>
            <td width="78%"> <?php 
				$brandid = isset($brandid) ? $brandid : 0 ;
				//echo makeselect((array)$_TGLOBAL['brand'],'brandid', $brandid,'datatype="Require" msg="请选择品牌."','name', 'id','选择品牌', '0', 1) ;
				echo $_TGLOBAL['brand'][$brandid]['name'];
				?></td>
          </tr>

        <tr>
          <td class="caption"><!---<span class="font_red">*</span>->物资名称</td>
          <td><!--<input name="name" type="text" id="name" value="<?php echo isset($nameid) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写属性名称.">--><?php echo isset($nameid) ? getcount('name',"id=$nameid", 'name') : ''; ?><!--<span id="goods_name">--></span></td>
        </tr>
		
        <tr>
          <td class="caption"><!--<span class="font_red">*</span>-->数量</td>
          <td><!--<input name="num" type="text" id="num" value="<?php echo isset($num) ? $num : '' ; ?>" datatype="Integer" msg="请填写物资预警数量." size="20" maxlength="255" >--><?php echo isset($num) ? $num : '' ; ?></td>
        </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span><!---->采购时间</td>
          <td><!--<input placeholder="" name="getdate" type="text" value="<?php echo isset($getdate) ? date('Y-m-d',$getdate) : '' ; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd');" datatype="Require" msg="选择采购时间.">（可以填写一个大概时间，判断物资是否报废）--><?php echo isset($getdate) ? date('Y-m-d',$getdate) : '' ; ?></td>
        </tr>	
		<tr>
			<td class="caption">备注</td>
			<td><!--<textarea name="remark" cols="60" rows="4" id="remark"></textarea>--><?php echo isset($remark) ? nl2br($remark) : ''; ?></td>
		</tr>
        <tr>
          <td class="caption">创建人</td>
          <td><!--<input name="createname" type="text" id="createname" value="<?php echo $createname ? $createname : '' ; ?>" size="50" maxlength="255" disabled />--><?php echo $createname ? $createname : '' ; ?></td>
        </tr>
        <tr>
          <td class="caption">所属仓库</td>
          <td><!--<input name="departmentid" type="text" id="departmentid" value="<?php echo $storename ? $storename : '' ; ?>" size="50" maxlength="255" disabled />--><?php echo $storename ? $storename : '' ; ?></td>
        </tr>
		
          <!--<tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="userid" type="hidden" id="id" value="<?php echo $_TGLOBAL['adm_userid']; ?>">
			<input name="usage" type="hidden" id="usage" value="1">
          </tr>-->
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
<script type="text/javascript">


//类别选择
$("#classid").change ( function () {
	//alert($("#classid").val())
	goods_list();
});

//品牌选择
$("#brandid").change ( function () {
	goods_list();
});

function goods_list() {
	$.get("./lib/xml.php?"+Math.random(), { ac: "init", classid: $("#classid").val(), brandid: $("#brandid").val(), nameid: '<?php echo isset($nameid) ? $nameid : 0 ;?>',},
		function(data){
			$("#goods_name").html(data);
		});
}
goods_list();


</script>

</HTML>