<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_cache.php 2010-01-12 0:28:37 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['btnconfig'])) {
	config_cache();
	$result = '更新系统配置完毕.<br><br>';	
} 

if (isset($_POST['btnadmin_role'])) {
	loadcache('admin_role'  ,'id', '', 'orderlist'); 
	$result .= '更新管理员角色完毕.<br><br>';	
}

if (isset($_POST['btnmember_group'])) {
	loadcache('member_group','id', '', 'orderlist'); 
	$result .= '更新会员级别完毕.<br><br>';	
} 

isset($result) && showmsg($result);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>更新缓存 </DIV>
    <form action="" method="post" name="formcache" id="formcache">
      <table width="100%" border="0" class="list_table">
        <tr>
          <td width="22%" align="right">更新系统配置</td>
          <td width="78%"><input name="btnconfig" type="checkbox" id="btnconfig" value="1" checked></td>
        </tr>
        <tr>
          <td align="right">更新管理员角色</td>
          <td><input name="btnadmin_role" type="checkbox" id="btnadmin_role" value="1" checked></td>
        </tr>
        <tr>
          <td align="right">更新会员级别</td>
          <td><input name="btnmember_group" type="checkbox" id="btnmember_group" value="1" checked></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="更新"></td>
        </tr>
      </table>
    </form>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>