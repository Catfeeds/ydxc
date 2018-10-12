<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: weixin_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'class'); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');

$mod = 'weixin_class';

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

		$class_id = $_POST['class_id'];
		$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT MAX(class_id) FROM ".tname('weixin_class')." WHERE class_id LIKE '".$class_id."___'"), 0);
		$class_id2 = substr($count, -3, 3);
		$class_id = $class_id . substr($class_id2 + 1 + 1000, -3, 3);
	
		$classarr = array(
				'name'			  => 	trim($_POST['name']),
				'pid'			  => 	trim($_POST['pid']),
				'class_id'        => 	$class_id,
				'display'         => 	intval($_POST['display']),
				'jumpto'		  =>	trim($_POST['jumpto']),
				'img'             => 	$img_url,
				'type'             => 	$_POST['type'],
				);
		inserttable('weixin_class', $classarr);
		//weixin_class_cache();
		makecache('weixin_class','id', '', 'id'); 
		showmsg('类别添加成功！', 'module.php?ac=weixin&mod=class&class_id='.$_POST['class_id']);

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
		
		$classarr = array(
				'name'			  => 	trim($_POST['name']),
				'pid'			  => 	trim($_POST['pid']),
				'display'         => 	intval($_POST['display']),
				'jumpto'		  =>	trim($_POST['jumpto']),
				'img'             => 	$img_url_new,
				'type'             => 	$_POST['type'],
				);
		updatetable('weixin_class', $classarr, array('id' => $id));
		//weixin_class_cache();
		makecache('weixin_class','id', '', 'id'); 
		showmsg('类别修改成功！', 'module.php?ac=weixin&mod=class&class_id='.$_POST['class_id']);

	}
}



//取出修改时的信息
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('weixin_class')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>TOUR V1.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 97%">
  <DIV class=header>类别管理</DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="22%" class="caption">类别名称</td>
          <td width="78%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写类别名称."></td>
        </tr>
        <tr>
          <td class="caption">转向网址</td>
          <td><input name="jumpto" type="text" id="jumpto" value="<?php echo isset($jumpto) ? $jumpto : ''; ?>" size="50" maxlength="255" ></td>
        </tr>
        <tr>
          <td class="caption">显示顺序</td>
          <td><input name="display" type="text" id="display" value="<?php echo isset($display) ? $display : '' ; ?>" size="14" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>
        <tr>
          <td class="caption">类别图片</td>
          <td><input type="file" name="img" size="35">
            <?php if (isset($img) && $img != '') echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"fileimg_url\" value=\"".$img."\">删除图片"; ?></td>
        </tr>
        <tr>
          <td class="caption">事件类型</td>
          <td><?php 
				$type = isset($type) ? $type : '' ;
				echo GetRadio((array)$_TGLOBAL['setting']['weixin_type'], 'type', $type); ?></td>
        </tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="usage" type="hidden" id="usage" value="1">
            <input name="pid" type="hidden" id="class_id" value="<?php echo isset($_GET['class_id']) ? $_GET['class_id'] : 0 ; ?>"></td>
        </tr>
      </tbody>
    </table>
    <div class="font_red"><strong>注意：</strong>自定义菜单最多包括3个一级菜单，每个一级菜单最多包含5个二级菜单。一级菜单最多4个汉字，二级菜单最多7个汉字，多出来的部分将会以“...”代替。请注意，创建自定义菜单后，由于微信客户端缓存，需要24小时微信客户端才会展现出来。建议测试时可以尝试取消关注公众账号后再次关注，则可以看到创建后的效果。</div>
  </form>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
