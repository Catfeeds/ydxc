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
	$img_url1 = '';
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
	if ($_FILES['img1']['name']) {
		$aryreturn1 = pic_save($_FILES['img1']);
		if (is_array($aryreturn1)) { //返回数组则上传成功,取得文件名
			$img_url1 = $aryreturn1['new_name'];
		} else {
			showmsg($aryreturn1);
		}
	}
	
	if ($id <= 0) { //添加

		$arr = array(
				//'title'            => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['title']),
				'title'            => 	$_POST['title'],
				'description'          => $_POST['description'],
				'vedio_url'          => $_POST['vedio_url'],
				'catid'            => $_POST['catid'],
				
				'img'              => 	$img_url,
				'img1'              => 	$img_url1,
				//'content'          => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['content']),
				'content'          => 	$_POST['content'],
				'inputtime'      => time()
				);
		$id = inserttable('activity', $arr, 1);
		$result = '内容添加成功！';

	} else { //更新
		
		if ($img_url) {
			$img_url_new = $img_url;
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			file_exists($_POST['fileimg_url'].'.thumb.jpg') && unlink($_POST['fileimg_url'].'.thumb.jpg');
		} else {
			$img_url_new = $_POST['fileimg_url'];
		}
		
		if ($img_url1) {
			$img_url_new1 = $img_url1;
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			file_exists($_POST['fileimg_url'].'.thumb.jpg') && unlink($_POST['fileimg_url'].'.thumb.jpg');
		} else {
			$img_url_new1 = $_POST['fileimg_url'];
		}
		
		//删除缩略图
		if ($_POST['img_url_flag'] == 1) {
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			$img_url_new = '';
		}
		if ($_POST['img_url_flag1'] == 1) {
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			$img_url_new1 = '';
		}
		
		$arr = array(
				//'title'            => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['title']),
				'title'            => 	$_POST['title'],
				'description'      => $_POST['description'],
				'vedio_url'          => $_POST['vedio_url'],
				'catid'            => $_POST['catid'],
				
				'img'              => 	$img_url?$img_url:$_POST['img'],
				'img1'              => 	$img_url1?$img_url1:$_POST['img1'],
				//'content'          => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['content']),
				'content'          => 	$_POST['content'],
				'inputtime'      => time()
				);
		updatetable('activity', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result, 'module.php?ac=activity&mod=list');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('activity')." WHERE id='$id'");
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
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=DBd897f58d7a63e585485e3dea011253"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">

<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>活动管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
      	<tr>
      		<td>活动分类</td>
      		<td>
      			<select name="catid">
      				<?php $sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('activity_cate'));
					while ($value = $_TGLOBAL['db']->fetch_array($sql)) {	 ?>
	          		<option  value="<?php echo $value['id']; ?>" <?php if(@$catid==$value['id']){?>selected="selected"<?php } ?>><?php echo $value['name'];?></option>
	          		<?php } ?>
      			</select>
      		</td>
      	</tr>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 标题</td>
          <td width="86%"><input name="title" type="text" id="title" value="<?php echo @$title; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>
        <tr>
          <td width="14%" class="caption">描述</td>
          <td width="86%"><textarea name="description" cols="85" rows="5"><?php echo @$description; ?></textarea></td>
        </tr>
        
        <tr>
          <td width="14%" class="caption">视频链接</td>
          <td width="86%"><textarea name="vedio_url" cols="85" rows="5"><?php echo @$vedio_url; ?></textarea></td>
        </tr>
        
        <tr>
          <td class="caption">外部封面图</td>
          <td><input type="file" name="img" size="35">
            <?php if (@$img) echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"img\" value=\"".$img."\">删除图片"; ?>（列表页图片展示）</td>
        </tr>
        <tr>
          <td class="caption">内部顶部图</td>
          <td><input type="file" name="img1" size="35">
            <?php if (@$img1) echo "<a href='".$img1."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag1\" value=\"1\"><input type=\"hidden\" name=\"img1\" value=\"".$img1."\">删除图片"; ?>（列表页图片展示）</td>
        </tr>
        <tr>
        		<td class="caption">内容</td>
          <td><script charset="utf-8" src="ueditor/ueditor.config.js" type="text/javascript"></script>
			<script charset="utf-8" src="ueditor/ueditor.all.min.js" type="text/javascript"> </script>
			<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
			<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
			<script charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
			<script id="editor" type="text/plain" style="width:100%;height:500px;" name="content"><?php echo @$content; ?></script>	</td>
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
<script type="text/javascript">
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例


var ue = UE.getEditor('editor',
				{
					//sourceEditor :"textarea",
				});

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

