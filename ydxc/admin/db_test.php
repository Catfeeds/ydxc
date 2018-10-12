<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: db_test.php 2010-01-12 17:52:30 jerry $
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
    <DIV class=header>数据库测试 </DIV>
    <p><br>
      &nbsp;
      <?php
function mtime()
{
  $a = explode(" ", microtime());
  return round(((double)$a[1] + (double)$a[0]) * 1000);
}

function timer($testName)
{
  global $t0;
  echo $testName." 所需时间为 ";
  echo mtime() - $t0;
  echo " 毫秒<br>\n";
}

$t0 = mtime();
$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('weixin')." LIMIT 10");
while ($value = $_TGLOBAL['db']->fetch_array($query)) ;

timer("查询10条简单记录");
?>
</p>
    <p>&nbsp;</p>
    <p>&nbsp;    </p>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>