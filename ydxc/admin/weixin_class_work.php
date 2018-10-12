<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user_work.php 2009-8-5 15:07:33 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
checkpermission('', 'menu'); //权限检查
loadcache('weixin_class','id', '', 'id', 1); // 加载缓存树状菜单
include_once(S_ROOT . '/lib/function/function_cache.php');


if (isset($_POST['usage'])) {
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	//判断 父级 是否存在
	if($_POST['pid']){
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('weixin_class')." WHERE id='$_POST[pid]' AND id <> $id ");
		if (!$list=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('父级不存在，请检查是不是将自己作为父级了！');
		}		
	}


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
		$menuarr = array(
				'name'			  => 	trim($_POST['name']),
				'pid'			  => 	trim($_POST['pid']),
				//'class_id'        => 	$class_id,
				'display'         => 	intval($_POST['display']),
				'jumpto'		  =>	trim($_POST['jumpto']),
				'img'             => 	$img_url,
				'type'             => 	$_POST['type'],
				);
		inserttable('weixin_class', $menuarr);
		makecache('weixin_class','id', '', 'id'); // 后台菜单缓存
		makecache('weixin_class','id', '', 'id', 1); // 后台菜单缓存
		showmsg('菜单添加成功！', 'module.php?ac=weixin&mod=class');

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
		
		$menuarr = array(
				'name'			  => 	trim($_POST['name']),
				'pid'			  => 	trim($_POST['pid']),
				'display'         => 	intval($_POST['display']),
				'jumpto'		  =>	trim($_POST['jumpto']),
				'img'             => 	$img_url_new,
				'type'             => 	$_POST['type'],
				);

		updatetable('weixin_class', $menuarr, array('id' => $id));
		makecache('weixin_class','id', '', 'id'); // 后台菜单缓存
		makecache('weixin_class','id', '', 'id', 1); // 后台菜单缓存
		showmsg('菜单修改成功！', 'module.php?ac=weixin&mod=class');
	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['tree_weixin_class'][$id];
	extract($tree);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>菜单管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="22%" class="caption">父级菜单</td>
            <td width="78%"><?php 
					$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
					echo makeselect($_TGLOBAL['tree_weixin_class'],'pid', $tree['pid'],'datatype="Require" msg="请选择父级菜单."','name', 'id','作为一级菜单', '0', 1);
			
			?></td>
          </tr>
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
            <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>