<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_syslog.php 2010-01-12 0:28:37 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

$logdir = './data/log/';
$operation = 'error';
$logfiles = get_log_files($logdir, $operation);
$logs = array();
foreach($logfiles as $logfile) {
	$logs = array_merge($logs, file($logdir.$logfile));
}

$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
$keyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
$lpp = empty($lpp) ? 20 : $lpp;
$page = max(1, isset($page) ? intval($page) : 0 );
$start = ($page - 1) * $lpp;
$logs = array_reverse($logs);

if(empty($keyword)) {
	$num = count($logs);
	$multi = multi($num, $lpp, $page, get_current_url(), 0, 3);
	$logs = array_slice($logs, $start, $lpp);

} else {
	foreach($logs as $key => $value) {
		if(strpos($value, $keyword) === FALSE) {
			unset($logs[$key]);
		}
	}
	$multi = '';
}


function get_log_files($logdir = '', $action = 'action') {
	$dir = opendir($logdir);
	$files = array();
	while($entry = readdir($dir)) {
		$files[] = $entry;
	}
	closedir($dir);

	if($files) {
		sort($files);
		$logfile = $action;
		$logfiles = array();
		$ym = '';
		foreach($files as $file) {
			if(strpos($file, $logfile) !== FALSE) {
				if(substr($file, 0, 6) != $ym) {
					$ym = substr($file, 0, 6);
				}
				$logfiles[$ym][] = $file;
			}
		}
		if($logfiles) {
			$lfs = array();
			foreach($logfiles as $ym => $lf) {
				$lastlogfile = $lf[0];
				unset($lf[0]);
				$lf[] = $lastlogfile;
				$lfs = array_merge($lfs, $lf);
			}
			return array_slice($lfs, -2, 2);
		}
		return array();
	}
	return array();
} 
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
    <DIV class=header>系统日志 </DIV>
    <form action="" method="post" name="formcache" id="formcache">
      &nbsp;&nbsp;关键字搜索
        <input name="keyword" type="text" id="keyword" value="<?php echo $keyword; ?>" size="40">
        <input type="submit" name="button" id="button" value="搜索">
      <table width="100%" border="0" class="list_table">
        <tr>
          <td align="right" class="caption"><div align="center">记录时间</div></td>
          <td class="caption"><div align="center">IP地址</div></td>
          <td class="caption"><div align="center">操作地址</div></td>
          <td class="caption"><div align="center">备注</div></td>
        </tr>
<?php
	$timeoffset = 8;
	foreach($logs as $logrow) {
		$log = explode("\t", $logrow);
		if(empty($log[1])) {
			continue;
		}
		//$log[1] = gmdate('y-n-j H:i', $log[1] + $timeoffset * 3600);
		$tmp = explode('&lt;br /&gt;', $log[3]);
		//$username = $tmp[1] ? "<a href=\"space.php?username=".rawurlencode($tmp[0])."\" target=\"_blank\">$tmp[0]</a>" : '';
		$ip = $tmp[1] ? $tmp[1] : $tmp[0];
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onmouseover="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onmouseout="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onclick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td><?php echo $log[1]; ?></td>
          <td><?php echo $ip; ?></td>
          <td><?php echo $log[5]; ?></td>
          <td><?php echo $log[6]; ?></td>
        </tr>
<?php } ?>
      </table>
      <div align="center"><span class="page"><?php echo $multi; ?></span></div>
    </form>
</DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>