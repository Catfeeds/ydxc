<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: partner_partenr_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查

//获取队长列表
$captainList = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('captain')." where `cptid` = 0 ");

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	$date_start = strtotime($_POST['date_start'].' 00:00:00'); //转换输入的时间为时间戳的方式
	$date_end = strtotime($_POST['date_end']. ' 23:59:59');
	
	
	if ($id <= 0) { //添加

		$arr = array(
				//'title'            => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['title']),
				'name'            => 	$_POST['name'],
				'school'          => 	$_POST['school'],
				'phone'          => 	$_POST['phone'],
				'cptid'          => 	$_POST['cptid'],
				'addtime'          => 	time(),
				);
		$id = inserttable('captain', $arr, 1);
		$wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." where `phone` =".$_POST['phone']);
		if(!empty($wx_user['id'])){
			$updt = array('openid'=>$wx_user['openid']);
			$where = array('phone'=>$_POST['phone']);
			updatetable('captain',$updt,$where);
		}
		$result = '内容添加成功！';

	} else { //更新
		
		$arr = array(
				'name'            => 	$_POST['name'],
				'school'          => 	$_POST['school'],
				'phone'          => 	$_POST['phone'],
				);
		updatetable('captain', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result,'module.php?ac=captain&mod=list');
}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('captain')." WHERE id='$id'");
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
  <DIV class=header>组队管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption">队长</td>
          <td><?php echo @makeselect($captainList,'cptid', $cptid,'datatype="Require" msg="请选择队长"','name', 'id','请选择队长', '0', 1);?> </td>
        </tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 姓名</td>
          <td width="86%"><input name="name" type="text" id="name" value="<?php echo @$name; ?>" size="85" maxlength="255" datatype="Require" msg="请填写姓名." ></td>
        </tr>
        <tr >
          <td class="caption"><span class="font_red">*</span>电话</td>
          <td><input name="phone" type="text" id="phone" value="<?php echo @$phone; ?>" size="85" maxlength="255" ></td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"><span class="font_red">*</span>学校</td>
          <td><input name="school" type="text" id="school" value="<?php echo @$school; ?>" size="85" maxlength="255" ></td>
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
<style>
.jiaolian{
	display:block;
}
</style>

</BODY>
</HTML>
