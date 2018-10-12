<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: weixin_text_add.php 2013-11-24 22:29:55 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'text'); //权限检查

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$arr = array(
				'itype'            => 	'text', //显示文本回复的内容
				'keywords'         => 	$_POST['keywords'],				
				'content'          => 	$_POST['content'],
				'readno'           => 	0,
				'date'             => 	$_TGLOBAL['timestamp'],
				'uname'            => 	$_TGLOBAL['adm_username'],
				'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0,
				'cote'             => 	isset($_POST['cote']) ? implode(",", $_POST['cote']) : '' ,
				);
		inserttable('weixin', $arr);
		showmsg('内容添加成功！', 'module.php?ac=weixin&mod=text');

	} else { //更新
		
		$arr = array(
				'keywords'         => 	$_POST['keywords'],
				'content'          => 	$_POST['content'],				
				'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0,
				'cote'             => 	isset($_POST['cote']) ? implode(",", $_POST['cote']) : 0 ,
				);
		updatetable('weixin', $arr, array('id' => $id));
		showmsg('内容修改成功！', 'module.php?ac=weixin&mod=text');

	}
}

$display = 1;
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
  <DIV class=header>文本回复 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption">关键词</td>
          <td colspan="2"><input name="keywords" type="text" id="keywords" value="<?php echo isset($keywords) ? $keywords : ''; ?>" size="85" maxlength="255">
            <br>
            多个关键词请用空格格开：例如: 美丽 漂亮 好看</td>
        </tr>
        <tr>
          <td class="caption">回复内容</td>
          <td width="36%"><textarea name="content" cols="55" rows="8" id="content"><?php echo isset($content) ? $content : ''; ?></textarea>
            <br>
            请不要多于1000字否则无法发送!</td>
          <td width="50%"><p><span class="font_red">文字加超链接范例：</span><br>
              &lt;a href=&quot;http://3g.baidu.com&quot;&gt;3G首页&lt;/a&gt;</p>
            <p>效果如下：</p>
            <img src="images/chaolianjie.jpg" width="200" height="62"></td>
        </tr>
        <tr>
          <td class="caption">操作类别</td>
          <td colspan="2"><?php 
				$cote = isset($cote) ? $cote : '';
				echo GetCheckbox((array)$_TGLOBAL['setting']['news_cote'], 'cote', $cote); ?></td>
        </tr>
        <tr>
          <td class="caption">显示标识</td>
          <td colspan="2"><input name="display" type="checkbox" id="display" value="1" <?php echo (isset($display) && $display) ? 'checked' : ''; ?>></td>
        </tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td colspan="2"><input name="button" type="submit" class="button" id="button" value="提交">
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
	$.get("../include/xml.php?"+Math.random(), { ac: "weixin_class", last_class_id: $("#class_id").val(), class_id: '<?php echo substr(isset($class_id) ? $class_id : 0 , 0, 6); ?>'},
		function(data){
			$("#goods_class").html(data);
		});
}
class_list();

//选择二级时，显示三级类别
function class_list_3(val) {
	$.get("../include/xml.php?"+Math.random(), { ac: "weixin_class", last_class_id: val, class_id: '<?php echo isset($class_id) ? $class_id : 0; ?>'},
		function(data){
			$("#goods_class_3").html(data);
		});
}
class_list_3('<?php echo @substr($class_id, 0, 6); ?>');
</script>
</BODY>
</HTML>
