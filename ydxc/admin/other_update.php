<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: news_news_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
//权限检查
checkpermission(); //权限检查
loadcache('news_class'  ,'id', '', 'orderlist', 1);  // 加载缓存树状栏目

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	$date_start = strtotime($_POST['date_start'].' 00:00:00'); //转换输入的时间为时间戳的方式
	$date_end = strtotime($_POST['date_end']. ' 23:59:59');
	
	$img_url = '';
	$_CTB['attachdir'] = '.' . $_CTB['attachdir'];
	//上传logo
	include_once(S_ROOT.'./lib/function/function_image.php');
	if ($_FILES['img']['name']) {
		$aryreturn = pic_save($_FILES['img']);
		if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
			$img_url = $aryreturn['new_name'];
		} else {
			showmsg($aryreturn);
		}
	}
	
	if ($id <= 0) { //添加

		$arr = array(
				'name'            => 	$_POST['name'],
				'phone'           => 	$_POST['phone'],
				'station'         => 	$_POST['station'],
				'code'             => 	$_POST['code'],
				'inputtime'          => time(),
				);
		$id = inserttable('change_coach', $arr, 1);
		$result = '内容添加成功！';

	} else { //更新
		
		if ($img_url) {
			$img_url_new = $img_url;
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			file_exists($_POST['fileimg_url'].'.thumb.jpg') && unlink($_POST['fileimg_url'].'.thumb.jpg');
		} else {
			$img_url_new = $_POST['fileimg_url'];
		}

		//删除缩略图
		if ($_POST['img_url_flag'] == 1) {
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			$img_url_new = '';
		}
		$arr = array(
				'name'            => 	$_POST['name'],
				'phone'           => 	$_POST['phone'],
				'station'         => 	$_POST['station'],
				'code'             => 	$_POST['code'],
				);
		updatetable('change_coach', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result, 'module.php?ac=change&mod=check');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('change_coach')." WHERE id='$id'");
	@extract($_TGLOBAL['db']->fetch_array($query));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/jquery.js"></SCRIPT>
<SCRIPT language=JavaScript src="jquery-2.1.4.min.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=DBd897f58d7a63e585485e3dea011253"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">

<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>更换教练申请管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 姓名</td>
          <td width="50%"><input name="name" type="text" id="name" value="<?php echo @$name; ?>" size="85" maxlength="255" datatype="Require" msg="请填写姓名." ></td>
        </tr>
        <tr>
          <td class="caption">电话</td>
          <td>
          	
          	<input name="phone" type="text" id="phone" value="<?php echo @$phone; ?>" size="85" maxlength="255" datatype="Require" msg="请填写电话." >
          		
          	</td>
        </tr>
        <tr>
          <td class="caption">体检站</span></td>
          <td>
          	<select name="station">
          		<option value="0">选择体检站</option>
          		<?php $sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news_class')." where pid=24");
				while ($value = $_TGLOBAL['db']->fetch_array($sql)) {	 ?>
					<?php $strs.=$value['id'].",";?>
				<?php } ?>
				<?php $strs = substr($strs,0,-1);?>
					
				<?php $news_sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." where class_id in (".$strs.")");
				while ($data = $_TGLOBAL['db']->fetch_array($news_sql)) {	 ?>
					<option value="<?php echo $data['id'];?>" <?php if(@$station==$data['id']){?>selected="selected"<?php } ?>>
						<?php echo $data['title']; ?>
					</option>
				<?php } ?>
          	</select>
          </td>
        </tr>
		<tr>
          <td class="caption">体检码</span></td>
          <td>
          	<input type="text" value="<?php echo @$code; ?>" id="code"/>
          	
          </td>
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
<script type="text/javascript">
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例



//类别选择
$("#class_id").change ( function () {
	if($("#class_id").val() == 3 ){
		$(".jiaolian").css("display","block");
		$(".jiaolian").removeClass("jiaolian");
	}else{
		//$(".jiaolian").addClass("jiaolian");
	}
	class_list();
});
function class_list() {
	$.get("../lib/xml.php?"+Math.random(), { ac: "news_class", last_class_id: $("#class_id").val(), class_id: '<?php echo @substr($class_id, 0, 6); ?>'},
		function(data){
			$("#goods_class").html(data);
		});
}
class_list();

//选择二级时，显示三级类别
function class_list_3(val) {
	$.get("../lib/xml.php?"+Math.random(), { ac: "news_class", last_class_id: val, class_id: '<?php echo @$class_id; ?>'},
		function(data){
			$("#goods_class_3").html(data);
		});
}
class_list_3('<?php echo @substr($class_id, 0, 6); ?>');


</script>
</BODY>
</HTML>

