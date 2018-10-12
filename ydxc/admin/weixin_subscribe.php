<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: weixin_subscribe.php 2010-01-12  12:34:23 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['usage'])) {

	$arr = array(
			'intro'            => 	$_POST['intro'],
			);
	updatetable('weixin', $arr, array('itype' => 'subscribe'));
	showmsg('内容修改成功！', $_TGLOBAL['refer']);

}

//取出修改时的信息
$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('weixin')." WHERE itype='subscribe'");
extract((array)$_TGLOBAL['db']->fetch_array($query));
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
    <DIV class=header>关注时自动回复内容 </DIV>
    <form  method="post" enctype="multipart/form-data" name="FormEdit">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="14%" class="caption">&nbsp;</td>
            <td width="86%"><textarea name="intro" cols="70" rows="8" id="intro"><?php echo isset($intro) ? $intro : ''; ?></textarea></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="保存">
            <input name="usage" type="hidden" id="usage" value="1">
			
            <input name="button2" type="button" class="button" id="button2" value="切换到图文模式" onClick="location.href='module.php?ac=weixin&mod=news_add&id=<?php echo isset($id) ? $id : ''; ?>';"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>