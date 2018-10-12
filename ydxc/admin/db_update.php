<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: db_update.php 2010-01-12 18:08:55 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

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
    <DIV class=header>数据库升级 </DIV>
    &nbsp;
    <?php 
//单击修改按钮
if (isset($_POST['action']) && $_POST['action'] == "db_update") {

		$sqlquery = splitsql($_POST['queries']);
		foreach($sqlquery AS $sql) {
			if(trim($sql) != "") {
				$_TGLOBAL['db']->query(stripslashes($sql));
			}
		}
		echo "<BR><BR>&nbsp;数据结构成功升级。";
} else {
?>
    <form name="FormEdit" method="post" action="">
      <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" bgcolor="#FFFFFF" bordercolor="#FFFFFF" bordercolorlight="cccccc">
        <tr bgcolor="#FFFFFF">
          <td class="tblhead">请将数据库升级语句粘贴在下面</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="96%" align="center" class="firstalt"><textarea name="queries" cols="80" rows="13"></textarea>
              <br>
            注意：为确保升级成功，请不要修改 SQL 语句的任何部分。</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="96%" align="center" class="secondalt"><input name="action" type="hidden" id="action" value="db_update">
              <input type="submit" name="Submit2" value=" 数据库升级 ">
          </td>
        </tr>
      </table>
    </form>
    <?php  } ?>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>