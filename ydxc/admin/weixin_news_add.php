<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: weixin_news_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'news'); //权限检查

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

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
				'itype'            => 	'weixin',
				'keywords'         => 	$_POST['keywords'],
				'title'            => 	$_POST['title'],
				'intro'            => 	$_POST['intro'],
				'class_id'         => 	$_POST['class_id'],
				'img'              => 	$img_url,
				'content'          => 	$_POST['content'],
				'jumpto'           => 	$_POST['jumpto'],
				'flag'             => 	$_POST['flag'],
				'readno'           => 	0,
				'date'             => 	$_TGLOBAL['timestamp'],
				'uname'            => 	$_TGLOBAL['adm_username'],
				'displayorder'          => 	isset($_POST['displayorder']) ? (int)$_POST['displayorder'] : 0,
				'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0,
				'cote'             => 	isset($_POST['cote']) ? implode(",", $_POST['cote']) : '' ,
				);
		$id = inserttable('weixin', $arr, 1);
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
				'itype'            => 	'weixin',
				'keywords'         => 	$_POST['keywords'],
				'title'            => 	$_POST['title'],
				'intro'            => 	$_POST['intro'],
				'class_id'         => 	$_POST['class_id'],
				'img'              => 	$img_url_new,
				'content'          => 	$_POST['content'],
				'jumpto'           => 	$_POST['jumpto'],
				'flag'             => 	$_POST['flag'],
				'displayorder'          => 	isset($_POST['displayorder']) ? (int)$_POST['displayorder'] : 0,
				'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0,
				'cote'             => 	isset($_POST['cote']) ? implode(",", $_POST['cote']) : '' ,
				);
		updatetable('weixin', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	//************** 处理图片到数据库 start 	
	
	showmsg($result, 'module.php?ac=weixin&mod=news');

}

$display = 1;
$flag 	 = 1;
//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('weixin')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
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
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>图文回复 </DIV>
    <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="14%" class="caption">关键词</td>
            <td width="86%"><input name="keywords" type="text" id="keywords" value="<?php echo isset($keywords) ? $keywords : ''; ?>" size="85" maxlength="255">
              <br>
多个关键词请用空格格开：例如: 美丽 漂亮 好看</td>
          </tr>
          <tr>
            <td class="caption"><span class="font_red">*</span> 标题</td>
            <td><input name="title" type="text" id="title" value="<?php echo isset($title) ? $title : 0; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
          </tr>
          <tr>
            <td class="caption">简介</td>
            <td><textarea name="intro" cols="55" rows="8" id="intro"><?php echo isset($intro) ? $intro : 0; ?></textarea></td>
          </tr>
          <tr>
            <td class="caption">操作类别</td>
            <td><?php 
					$cote = isset($cote) ? $cote : '';
					echo GetCheckbox((array)$_TGLOBAL['setting']['news_cote'], 'cote', $cote); ?></td>
          </tr>
          <tr>
            <td class="caption">类别</td>
            <td><?php
					$class_id = isset($class_id) ? $class_id : '';
					echo getclasszoneselect($class_id, '', 'weixin_class', 'class_id');
				?>
                <span id="goods_class"></span> <span id="goods_class_3"></span> </td>
          </tr>
          <tr>
            <td class="caption"><span class="MustFill">显示顺序</span></td>
            <td><input name="displayorder" type="text" id="displayorder" value="<?php echo isset($displayorder) ? $displayorder : ''; ?>" size="14" maxlength="10">
              数字，值越大，越排在前面</td>
          </tr>
          <tr>
            <td class="caption">封面图片地址</td>
            <td><input type="file" name="img" size="35">
              <?php if (isset($img) && $img) echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"fileimg_url\" value=\"".$img."\">删除图片"; ?></td>
          </tr>
          <tr>
            <td class="caption">显示标识</td>
            <td><input name="display" type="checkbox" id="display" value="1" <?php echo (isset($display) && $display != '') ? 'checked' : ''; ?>></td>
          </tr>
          <tr>
            <td class="caption">标签</td>
            <td><?php 
					$flag = isset($flag) ? $flag : '';
					echo GetRadio((array)$_TGLOBAL['setting']['news_flag'], 'flag', $flag); ?></td>
          </tr>
          <tr>
            <td class="caption">图文外链网址</td>
            <td><input name="jumpto" type="text" id="jumpto" value="<?php echo (isset($jumpto) && $jumpto) ? $jumpto : '' ; ?>" size="60" maxlength="255">
              <br>
需跳转到其他网址，请在这里填写网址(例如：http://baidu.com，记住必须有http://)如果填写了图文详细内容，这里请留空，不要设置！</td>
          </tr>
          
          <tr>
            <td colspan="2" align="left"><script charset="utf-8" src="kindeditor/kindeditor-min.js"></script>
		<script charset="utf-8" src="kindeditor/lang/zh_CN.js"></script>
		<script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
		</script>
		<textarea name="content" style="width:100%;height:355px;visibility:hidden;"><?php echo isset($content) ? $content : '' ; ?></textarea></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
<script type="text/javascript">
//类别选择
$("#class_id").change ( function () {
	class_list();
});
function class_list() {
	$.get("../lib/xml.php?"+Math.random(), { ac: "weixin_class", last_class_id: $("#class_id").val(), class_id: '<?php echo substr(isset($class_id) ? $class_id : '', 0, 6); ?>'},
		function(data){
			$("#goods_class").html(data);
		});
}
class_list();

//选择二级时，显示三级类别
function class_list_3(val) {
	$.get("../lib/xml.php?"+Math.random(), { ac: "weixin_class", last_class_id: val, class_id: '<?php echo isset($class_id) ? $class_id : ''; ?>'},
		function(data){
			$("#goods_class_3").html(data);
		});
}
class_list_3('<?php echo substr(isset($class_id) ? $class_id : '', 0, 6); ?>');
</script>
</BODY>
</HTML>