<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: course_init_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	if ($id <= 0) { //添加

		$arr = array(
			'name'             => 	$_POST['name'],
			'obj'              => 	$_POST['obj'],
			'testdate'         => 	$_POST['testdate'],
			'getdate'          => 	$_POST['getdate'],
			'classid'          => 	$_POST['classid'],
			'drive_type'        => 	$_POST['drive_type'],
			'type'             => 	$_POST['type'],
			'money'            => 	$_POST['money'],
			'intro'            => 	$_POST['intro'],
			'liucheng'         => 	$_POST['liucheng'],
//			'dj_price'         => 	$_POST['dj_price'],
//			'sd_price'         => 	$_POST['sd_price'],
			'zd_price'         => 	$_POST['zd_price'],
			'price'            => 	$_POST['price'],
			'lowpay'           => 	$_POST['lowpay'],
			'displayorder'     => 	$_POST['displayorder'],
			'date'             => 	$_TGLOBAL['timestamp'],
				);
		$id = inserttable('course', $arr, 1);
		$result = '班级添加成功！';

	} else { //更新
		
		$arr = array(
			'name'             => 	$_POST['name'],
			'obj'              => 	$_POST['obj'],
			'testdate'         => 	$_POST['testdate'],
			'getdate'          => 	$_POST['getdate'],
			'classid'          => 	$_POST['classid'],
			'drive_type'        => 	$_POST['drive_type'],
			'type'             => 	$_POST['type'],
			'money'            => 	$_POST['money'],
			'intro'            => 	$_POST['intro'],
			'liucheng'         => 	$_POST['liucheng'],
//			'dj_price'         => 	$_POST['dj_price'],
//			'sd_price'         => 	$_POST['sd_price'],
			'zd_price'         => 	$_POST['zd_price'],
			'price'            => 	$_POST['price'],
			'lowpay'           => 	$_POST['lowpay'],
			'displayorder'     => 	$_POST['displayorder'],
			//'date'             => 	$_TGLOBAL['timestamp'],
				);
		updatetable('course', $arr, array('id' => $id));
		$result = '班级修改成功！';
	}
	makecache('course','id', '', 'id'); //缓存
	showmsg($result, 'module.php?ac=course&mod=init');

}

//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('course')." WHERE id='$id'");
	@extract($_TGLOBAL['db']->fetch_array($query));
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
<script language="JavaScript" src="js/popcalendar.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>班级管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 班级名称</td>
          <td width="86%"><input name="name" type="text" id="name" value="<?php echo @$name; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 所属类别</td>
          <td width="86%"><?php echo @makeselect($_TGLOBAL['tree_news_class'],'classid', $classid,'datatype="Require" msg="请选择栏目"','name', 'id','请选择栏目', '', 1);?> </td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 驾驶类型</td>
          <td><!--<input name="kemu" type="text" id="kemu" value="<?php echo @$kemu; ?>" size="85" maxlength="255" >-->
				<?php echo @makeselect($_TGLOBAL['setting']['drive_type'],'drive_type', $drive_type,'datatype="Require" msg="请选择类型"','', '','选择类型', '0', 1);?>
		  </td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 适应对象</td>
          <td width="86%"><input name="obj" type="text" id="obj" value="<?php echo @$obj; ?>" size="85" maxlength="255" datatype="Require" msg="请填写适应对象." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 练车时间</td>
          <td width="86%"><input name="testdate" type="text" id="testdate" value="<?php echo @$testdate; ?>" size="85" maxlength="255" datatype="Require" msg="请填写练车时间." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 拿证时间</td>
          <td width="86%"><input name="getdate" type="text" id="getdate" value="<?php echo @$getdate; ?>" size="85" maxlength="255" datatype="Require" msg="请填写拿证时间." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 练车方式</td>
          <td width="86%"><input name="type" type="text" id="type" value="<?php echo @$type; ?>" size="85" maxlength="255" datatype="Require" msg="请填写练车方式." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 收费标准</td>
          <td width="86%"><input name="money" type="text" id="money" value="<?php echo @$money; ?>" size="85" maxlength="255" datatype="Require" msg="请填写收费标准." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 报名价格</td>
          <td width="86%"><input name="zd_price" type="text" id="zd_price" value="<?php echo @$zd_price; ?>" size="85" maxlength="255" datatype="Double" msg="请填写自动档价格." ></td>
        </tr>
        <!--<tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 手动档价格</td>
          <td width="86%"><input name="sd_price" type="text" id="sd_price" value="<?php echo @$sd_price; ?>" size="85" maxlength="255" datatype="Double" msg="请填写手动档价格." ></td>
        </tr>-->
        <!--<tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 定金</td>
          <td width="86%"><input name="dj_price" type="text" id="dj_price" value="<?php echo @$dj_price; ?>" size="85" maxlength="255" datatype="Double" msg="请填写定金." ></td>
        </tr>-->
        <!--<tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 微信价格</td>
          <td width="86%"><input name="price" type="text" id="price" value="<?php echo @$price; ?>" size="85" maxlength="255" datatype="Double" msg="请填写微信显示价格." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 最低支付金额</td>
          <td width="86%"><input name="lowpay" type="text" id="lowpay" value="<?php echo @$lowpay; ?>" size="85" maxlength="255" datatype="Double" msg="请微信报名最低支付金额." ></td>
        </tr>-->
        <tr>
          <td class="caption"><span class="MustFill"></span>显示顺序</td>
          <td><input name="displayorder" type="text" id="displayorder" value="<?php echo @$displayorder; ?>" size="14" maxlength="10">
            数字，值越大，越排在前面</td>
        </tr>

        <tr>
          <td width="14%" class="caption">简介</td>
          <td width="86%"><textarea name="intro" cols="120" rows="20"><?php echo @$intro; ?></textarea></td>
        </tr>
        <tr>
          <td width="14%" class="caption">服务流程</td>
          <td width="86%"><textarea name="liucheng" cols="120" rows="20"><?php echo @$liucheng; ?></textarea></td>
        </tr>

        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo @$id; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
        </tr>
      </tbody>
    </table>
  </form>
</DIV>
<?php include 'footer.php'; ?>

</BODY>
</HTML>
