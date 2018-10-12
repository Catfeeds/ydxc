<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: db_optimize.php 2010-01-12 17:52:30 jerry $
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
    <DIV class=header>数据库优化 </DIV>
    <p><?php
@$tables = mysql_list_tables($_CTB['dbname'], $_TGLOBAL['db']->link);
$num_tables = mysql_numrows($tables);
$no = 0;
for($j = 0; $j < $num_tables; $j ++)
{
  $table = mysql_tablename($tables, $j);

  //当表的前缀不等于系统设置的前缀时,则进行下一个循环
  if ($_CTB['tablepre'] && substr($table, 0, strlen($_CTB['tablepre'])) != $_CTB['tablepre']) continue;
  $sql = "optimize table $table";
  echo "优化表 $table ...";
  flush();
  $_TGLOBAL['db']->query($sql);
  echo "<b>ok!</b><br>\n";
  flush();
  $no++;
}
echo "<BR> $no 个表表优化完毕。";
?>
</p>
    <p>&nbsp;</p>
    <p>&nbsp;    </p>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>