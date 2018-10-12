<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: db_store.php 2010-01-12 18:08:55 jerry $
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
    <DIV class=header>数据库恢复 </DIV>
    <?php 
//单击修改按钮
if (isset($_POST['action']) && $_POST['action'] == "db_restore") {
		
		if($_POST['from'] == "server") {
			$datafile = $_POST['datafile_server'];
			$datafile_size = filesize($datafile_server);
		}
		$fp = fopen($_FILES['datafile']['tmp_name'], "r");
		if($datafile_size) {
			flock($fp, 3);
			$sqldump = fread($fp, $datafile_size);
		} else {
			$sqldump = fread($fp, 99999999);
		}
		fclose($fp);
		if(!$sqldump) {
				 echo "&nbsp;数据文件不存在：可能服务器不允许上传文件或尺寸超过限制。";
				 exit();
			}

			$sqlquery = splitsql($sqldump);
			unset($sqldump);
			foreach($sqlquery AS $sql) {
				if(trim($sql) != '') {
					$_TGLOBAL['db']->query($sql);
				}
			}
		echo "<BR><BR>&nbsp;数据成功导入数据库。";
} else {
?>
    <form action="" method="post" enctype="multipart/form-data" name="FormEdit">
      <table width="90%" border="0" cellspacing="0" cellpadding="3" align="center" bgcolor="#FFFFFF" bordercolor="#FFFFFF" bordercolorlight="cccccc">
        <tr bgcolor="#FFFFFF">
          <td class="tblhead">特别提示</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="firstalt"><ul>
              <li>本功能在恢复备份数据的同时，将全部覆盖原有数据，请确定是否需要恢复，以免造成数据损失。 
              </ul>
              <ul>
                <li>数据恢复功能只能恢复由相同版本导出的数据文件，其他软件导出格式可能无法识别。 
            </ul>
            <ul>
                <li>从本地恢复数据需要服务器支持文件上传并保证数据尺寸小于允许上传的上限，否则只能使用从服务器恢复。 
            </ul></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="tblhead">数据恢复 <br>
          </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="96%" class="secondalt"><br>
              <input type="radio" name="from" value="server" checked onClick="this.form.datafile_server.disabled=!this.checked;this.form.datafile.disabled=this.checked">
            从服务器(填写文件名或 URL)：
            <input type="text" size="40" name="datafile_server" value="./bak/"></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="firstalt"><input type="radio" name="from" value="local" onClick="this.form.datafile_server.disabled=this.checked;this.form.datafile.disabled=!this.checked">
            从本地文件：
            <input type="file" size="29" name="datafile" disabled></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td width="96%" align="center" class="secondalt"><input name="action" type="hidden" id="action" value="db_restore">
              <input type="submit" name="Submit2" value=" 恢复数据 ">
          </td>
        </tr>
      </table>
    </form>
    <?php  } ?>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>