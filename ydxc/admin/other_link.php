<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_link.php 2010-01-12 23:10:21 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

(isset($width) && $width == 88) && $height = 31;

$op = isset($_POST['op']) ? $_POST['op'] : '';
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

if($op == 'insert') {

	$_CTB['attachdir'] = '.' . $_CTB['attachdir'];
	//上传logo
	include_once(S_ROOT.'./lib/function/function_image.php');
	if ($_FILES['img']['name']) {
		$aryreturn = pic_save($_FILES['img']);
		if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
			$image_url = $aryreturn['new_name'];
		} else {
			showmsg($aryreturn);
		}
	}

	  $linkarr = array(
			'name'             => 	$_POST['name'],
			'url'              => 	$_POST['url'],
			'image'            => 	$image_url,
			'width'            => 	$width,
			'height'           => 	$height,
			'views'            => 	0,
			'clicks'           => 	0,
			'visible'          => 	$_POST['visible'],
			'posttime'         => 	$_TGLOBAL['timestamp'],
			'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0 ,
			);
		inserttable('link', $linkarr);
	  $name = $url = $class_id = '';  //方便插入下一条记录
	  $display = 0;
	  $result = '插入成功。';

} else if($op == 'update') {

	$_CTB['attachdir'] = '.' . $_CTB['attachdir'];
	//上传logo
	include_once(S_ROOT.'./lib/function/function_image.php');
	if ($_FILES['img']['name']) {
		$aryreturn = pic_save($_FILES['img']);
		if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
			$image_url = $aryreturn['new_name'];
		} else {
			showmsg($aryreturn);
		}
	}

		if ($image_url) {
			$image_url_new = $image_url;
			file_exists($_POST['img_url_edit']) && unlink($_POST['img_url_edit']);
		} else {
			$image_url_new = $_POST['img_url_edit'];
		}
		//删除缩略图
		if ($_POST['img_url_flag'] == 1) {
			file_exists($_POST['img_url_edit']) && unlink($_POST['img_url_edit']);
			$image_url_new = '';
		}

	  $linkarr = array(
			'name'             => 	$_POST['name'],
			'url'              => 	$_POST['url'],
			'image'            => 	$image_url_new,
			'visible'          => 	$_POST['visible'],
			'display'          => 	isset($_POST['display']) ? (int)$_POST['display'] : 0 ,
			);
	  updatetable('link', $linkarr, array('id' => $id));
  	  $name = $url = $class_id = '';
	  $display = 0;
	  $result = '更改成功。';

} else if($op == 'delete') {
	  $_TGLOBAL['db']->query("DELETE FROM ".tname('link')." WHERE id='$id'");
  	  $name = $url = $class_id = '';
	  $display = 0;
	  $result = '删除成功。';
}

isset($result) && showmsg($result, $_TGLOBAL['refer']);

$perpage = 20;
$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
$page<1 && $page = 1;
$start = ($page-1)*$perpage;
//检查开始数
ckstart($start, $perpage);

$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('link')), 0);

$list = array();
if($count) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('link')." ORDER BY id DESC LIMIT $start,$perpage");
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {			
		$list[] = $value;
	}
}

$multi = multi($count, $perpage, $page, get_current_url());

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<script language="JavaScript" src="js/setselect.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>友情链接 </DIV>
  <table width="100%" align="center" cellpadding="2" cellspacing="1" bgcolor="dddddd" class="list_table">
        <tr bgcolor="e8e8e8"> 
          <td align="center" class="caption"><div align="center">名称</div></td>
          <td align="center" class="caption"><div align="center">Url</div></td>
          <td align="center" class="caption"><div align="center">显示顺序</div></td>
          <td align="center" class="caption">          <div align="center">显示</div></td>
          <td align="center" class="caption"><div align="center">登记日期</div></td>
          <td align="center" class="caption"><div align="center">文件</div></td>
          <td align="center" class="caption"><div align="center">操作</div></td>
    </tr>
        <form name="formInsert" enctype="multipart/form-data" method="post" action="">
          <tr bgcolor="#FDFFF7"> 
            <td> <input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ''; ?>" size="12" maxlength="100">            </td>
            <td> <input type="text" name="url" value="<?php echo isset($_POST['url']) ? $_POST['url'] : '' ; ?>" size="14" maxlength="200">            </td>
            <td> <input name="display" type="text" id="display" value="<?php echo isset($_POST['display']) ? $_POST['display'] : '' ; ?>" size="2" maxlength="8">            </td>
            <td align="center"> <select name="visible">
                <option value="0">否</option>
                <option value="1">是</option>
              </select> </td>
            <td align="center">&nbsp;</td>
            <td><input type="file" name="img" size="18" value="<?php echo isset($img) ? $img : '' ;?>">
            <!--<input class="edit" name="file" type="file" size="12">--></td>
            <td align="center"> <input type="hidden" name="op" value="insert"> 
              <input class="button" type="submit" name="insertBtn" value="添加">            </td>
          </tr>
          <script language="JavaScript">
    setSelect("formInsert", "visible", "<?php echo $_POST['visible'] ? $_POST['visible'] : 1; ?>");
  </script>
        </form>
        <tr bgcolor="#f7f7f7"> <!--<?php  if ($i % 2 ==0) echo "#FDFFF7";else echo "#f7f7f7"; ?>-->
          <td colspan="7" height="25" align="center"> <?php echo isset($result) ? $result : '' ; ?></td>
        </tr>
        <?php
$i = 1 ;
foreach(is_array($list) ? $list : array($list) AS $value) {

  $id  = $value['id'];
  $img = $value['image'];
?>
        <form name="form<?php echo $id ?>" enctype="multipart/form-data" method="post" action="">
          <tr bgcolor="<?php  if ($i % 2 ==0) echo "#FDFFF7";else echo "#f7f7f7"; ?>"> 
            <td> <input type="text" name="name" value="<?php echo $value['name']; ?>" size="12" maxlength="100">            </td>
            <td> <input type="text" name="url" value="<?php echo $value['url']; ?>" size="14" maxlength="200">            </td>
            <td> <input name="display" type="text" id="display" value="<?php echo $value['display']; ?>" size="2" maxlength="8">            </td>
            <td align="center"> <select name="visible">
            <option value="0">否</option>
                <option value="1">是</option>
            </select> </td>
            <td align="center"> <?php echo date("Y-m-d H:i", $value['posttime']); ?> </td>
            <td><input type="file" name="img" size="18" value="<?php echo $img;?>">
              <?php if ($img) echo "<br><a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"img_url_edit\" value=\"".$img."\">删除图片"; ?>
			<!--<input class="edit" name="file" type="file" size="12">--></td>
            <td align="center"> <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
              <input name="page" type="hidden" id="page" value="<?php echo $page; ?>"> 
              <input type="hidden" name="op" value=""> <input class="button" type="button" name="updateBtn" value="更改"
        onClick="document.forms['form<?php echo $id; ?>'].op.value='update'; document.forms['form<?php echo $id; ?>'].submit();"> 
              <input class="button" type="button" name="deleteBtn" value="删除"
        onClick="document.forms['form<?php echo $id; ?>'].op.value='delete'; if(confirm('您确定删除该记录吗？')) document.forms['form<?php echo $id; ?>'].submit();">            </td>
          </tr>
          <script language="JavaScript">
    setSelect("form<?php echo $id; ?>", "visible", "<?php echo $value['visible']; ?>");
  </script>
        </form>
        <?php
$i++;
}
?>
  </table>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
  <u>帮助信息</u>：
  <ul>
    <li><span class="p14">可以通过修改一个友情链接的“显示”为“否”来屏蔽显示一个友情链接</span></li>
    <li>显示顺序：数值，值越大，越在前面</li>
    <li><span class="p14">点“更改”确认修改各变动</span></li>
    <li><span class="p14">点“删除”，确认删除后，删除一条</span><span class="p14">友情链接</span></li>
  </ul>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
