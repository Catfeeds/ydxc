<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查


//取出信息
if ($_POST['prints']) {
	$aryid = simplode($_POST['itemid']);
	$barcodes = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('barcode')." WHERE id IN($aryid)");
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
<script language="JavaScript" src="js/jsAddress.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>打印条形码</DIV>
    
	
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
		
			<?php 
			$i = 0;
			foreach($barcodes as $key=>$val):
				if($i%2 == 0) echo '<tr>';
			?>
				<td><img src="./tiaoxingma.php?str=<?php echo isset($val['barcode']) ? $val['barcode'] : '' ; ?>"></td>
			<?php 	
				if($i%2 == 1) echo '</tr>';
				$i++;
			endforeach; ?>
        </tbody>
      </table>

	  
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>

<script>window.print();</script>