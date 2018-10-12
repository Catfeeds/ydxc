<?php
/*
	[CTB] (C) 2007-2009 51shop.org
	$Id: system_user.php 2009-5-4 2:29:53 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['usage'])) {

	$userarr = array(
			'password'    => 	md5($_POST['password'])
			);
	updatetable('admin', $userarr, array('userid' => $_TGLOBAL['adm_userid']));
	showmsg('密码修改成功！', $_TGLOBAL['refer']);
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
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>修改密码 </DIV>
    <table width="98%" align="center">
  <tr align="center"> 
    <td><form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
        <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
          <tr> 
            <td width="31%" align="right" class="caption">用户账号</td>
            <td width="69%" align="left" class="cell"> 
              <input name=username disabled class="read_only" value="<?php echo $_TGLOBAL['adm_username']?>" maxlength="50">            </td>
          </tr>
          <tbody> 
          <tr> 
            <td width="31%" align="right" class="caption"> 新 密 码</td>
            <td width="69%" align="left" class="cell"> 
              <input name=password  type=password maxlength="50" datatype="SafeString" msg="请正确填写新的安全密码，必须为字母加数字." >
              （3-50位数字或字母） </td>
          </tr>
          <tr> 
            <td width="31%" align="right" class="caption"> 检验密码</td>
            <td width="69%" align="left" class="cell"> 
              <input name=password2 type=password maxlength="50" datatype="Repeat" to="password" msg="两次输入密码必须相同." >
              （3-50位数字或字母） </td>
          </tr>
          </tbody> 
        </table>
        <br>
        <input name="usage" type="hidden" id="usage" value="1">
        <input name=submit type=submit class="button" value="保存">
    </form></td>
  </tr>
</table>
    <br>
    <u><span class="p14">帮助信息</span></u><span class="p14">：</span>
    <ul>
      <li><span class="p14">&quot;用户账号&quot;不能修改</span></li>
      <li>两次输入的密码应该相同</li>
    </ul>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>