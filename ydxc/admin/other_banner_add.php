<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: news_news_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	$img_url = '';
	$_CTB['attachdir'] = '.' . $_CTB['attachdir'];
	//上传logo
	//var_dump($_FILES);die;
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
				'title'            => 	$_POST['title'],
				'summary'          => 	$_POST['summary'],
				'img'              => 	$img_url,
				'link'             => 	$_POST['link'],
				'flag'             => 	@implode(",", $_POST['flag']),
				'date'             => 	$_TGLOBAL['timestamp'],
				'is_hidden'        => 	@(int)$_POST['is_hidden'],
				'orderlist'        => 	@(int)$_POST['orderlist'],
				);
		$id = inserttable('banner', $arr, 1);
		$result = '焦点图添加成功！';

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
				'title'            => 	$_POST['title'],
				'summary'          => 	$_POST['summary'],
				'img'              => 	$img_url_new,
				'link'             => 	$_POST['link'],
				'flag'             => 	@implode(",", $_POST['flag']),
				'is_hidden'        => 	@(int)$_POST['is_hidden'],
				'orderlist'        => 	@(int)$_POST['orderlist'],
				);
		updatetable('banner', $arr, array('id' => $id));
		$result = '焦点图修改成功！';
	}

	showmsg($result, 'module.php?ac=other&mod=banner');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('banner')." WHERE id='$id'");
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
  <DIV class=header>焦点图管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 标题</td>
          <td width="86%"><input name="title" type="text" id="title" value="<?php echo @$title; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>
        <tr>
          <td class="caption"><span class="MustFill">显示顺序</span></td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo @$orderlist; ?>" size="14" maxlength="10">
            数字，值越大，越排在前面</td>
        </tr>
        <tr>
          <td class="caption">缩略图</td>
          <td><input type="file" name="img" size="35">
            <?php if (@$img) echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"fileimg_url\" value=\"".$img."\">删除图片"; ?></td>
        </tr>
        <tr>
          <td class="caption">是否隐藏</td>
          <td><input name="is_hidden" type="checkbox" id="is_hidden" value="1" <?php echo @$is_hidden ? 'checked' : ''; ?>></td>
        </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>推荐位置</td>
          <td><?php echo @GetCheckbox($_TGLOBAL['setting']['banner_flag'], 'flag', $flag); ?></td>
        </tr>
        <tr>
          <td class="caption"><span class="font_red">*</span>链接地址</td>
          <td><input name="link" type="text" id="link" value="<?php echo @$link; ?>" size="60" maxlength="255" datatype="Require" msg="请填写链接地址.">
需跳转到其他网址，请在这里填写网址</td>
        </tr>
        <tr>
          <td width="14%" class="caption">摘要</td>
          <td width="86%"><textarea name="summary" cols="85" rows="5"><?php echo @$summary; ?></textarea></td>
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
