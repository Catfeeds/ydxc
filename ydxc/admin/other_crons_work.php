<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_crons_work.php 2010-1-12 16:26:24 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'crons'); //权限检查


//取出修改时的信息
$keywords = isset($_POST['keywords']) ? (int)$_POST['keywords'] : (isset($_GET['keywords']) ? (int)$_GET['keywords'] : '');
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('crons')." WHERE cronid='$id'");
	$cron = $_TGLOBAL['db']->fetch_array($query);
	
	$cron['filename'] = str_replace(array('..', '/', '\\'), array('', '', ''), $cron['filename']);
	$cronminute = str_replace("\t", ',', $cron['minute']);
	$cron['minute'] = explode("\t", $cron['minute']);

} else {
	$cron['available'] = 1;
}

if (isset($_POST['usage'])) {

	$_POST['day'] = $_POST['weekday'] != -1 ? -1 : $_POST['day'];
	$minutenew = $_POST['minute'];
	if(strpos($minutenew, ',') !== FALSE) {
		$minutenew = explode(',', $minutenew);
		foreach($minutenew as $key => $val) {
			$minutenew[$key] = $val = intval($val);
			if($val < 0 || $var > 59) {
				unset($minutenew[$key]);
			}
		}
		$minutenew = array_slice(array_unique($minutenew), 0, 12);
		$minutenew = implode("\t", $minutenew);
	} else {
		$minutenew = intval($minutenew);
		$minutenew = $minutenew >= 0 && $minutenew < 60 ? $minutenew : '';
	}

	if(preg_match("/[\\\\\/\:\*\?\"\<\>\|]+/", $_POST['filename'])) {
		showmsg('任务脚本无效');
	} elseif(!is_readable(S_ROOT.($cronfile = S_ROOT."./lib/crons/$_POST[filename]"))) {
		showmsg('任务脚本不存在');
	} elseif($_POST['weekday'] == -1 && $_POST['day'] == -1 && $_POST['hour'] == -1 && $minutenew === '') {
		showmsg('你必须设置一个任务运行的时间');
	}
				
	if ($id <= 0) { //添加

		$cronarr = array(
			'available'        => 	$_POST['available'],
			'type'             => 	'user',
			'name'             => 	$_POST['name'],
			'filename'         => 	$_POST['filename'],
			'lastrun'          => 	'',
			'nextrun'          => 	$_TGLOBAL['timestamp'],
			'weekday'          => 	$_POST['weekday'],
			'day'              => 	$_POST['day'],
			'hour'             => 	$_POST['hour'],
			'minute'           => 	$minutenew
				);
		$id = inserttable('crons', $cronarr, 1);
		$msg = '计划任务添加成功！';

	} else { //更新

		$cronarr = array(
			'available'        => 	$_POST['available'],
			'name'             => 	$_POST['name'],
			'filename'         => 	$_POST['filename'],
			'weekday'          => 	$_POST['weekday'],
			'day'              => 	$_POST['day'],
			'hour'             => 	$_POST['hour'],
			'minute'           => 	$minutenew
				);
		updatetable('crons', $cronarr, array('cronid' => $id));			
		$msg = '计划任务修改成功！';

	}
	
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('crons')." WHERE cronid='$id'");
		$cron = $_TGLOBAL['db']->fetch_array($query);
		
		$cron['filename'] = str_replace(array('..', '/', '\\'), array('', '', ''), $cron['filename']);
		$cronminute = str_replace("\t", ',', $cron['minute']);
		$cron['minute'] = explode("\t", $cron['minute']);
		require_once S_ROOT.'./lib/function/function_cron.php';
		cronnextrun($cron);
		require_once S_ROOT.'./lib/function/function_cache.php';
		config_cache();
		
		showmsg($msg, 'module.php?ac=other&mod=crons');
}


$weekdayselect = $dayselect = $hourselect = array();
for($i = 0; $i <= 6; $i++) {
	$weekdayselect[$i] = lang('cron_week_day_'.$i);
}
for($i = 1; $i <= 31; $i++) {
	$dayselect[$i] = "$i 日";
}

for($i = 0; $i <= 23; $i++) {
	$hourselect[$i] = "$i 时";
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
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>计划任务管理</DIV>
    <form action="" method="post" enctype="multipart/form-data" name="FormEdit" id="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="98%" align="center" class="list_table">
      
      <tr>
        <td align="left" class="vtop rowform">&nbsp;</td>
        <td align="left" class="vtop tips2">&nbsp;</td>
      </tr>
      <tr>
        <td align="left" class="vtop rowform">任务名称：<br>
        <input name="name" type="text" class="txt" id="name" value="<?php echo stripslashes(isset($cron['name']) ? $cron['name'] : '');?>" size="60"/></td>
        <td align="left" class="vtop tips2">任务名称只为识别辨认不同任务条目之用</td>
      </tr>
      <tr>
        <td align="left" class="vtop rowform"><span class="td25">可用：
            <input name="available" type="checkbox" class="checkbox" value="1" <?php echo isset($cron['available']) ? "checked" : ""; ?>>
        </span></td>
        <td align="left" class="vtop tips2">当“可用”时，任务才会在指定的时间运行</td>
      </tr>
      <tr>
        <td width="35%" align="left" class="vtop rowform">每周：<br>
        <?php 
			$cron['weekday'] = isset($cron['weekday']) ? $cron['weekday'] : '' ;
			echo GetSelect((array)$weekdayselect, 'weekday', $cron['weekday'], '' , 'style="width:340px;"', '*', '-1'); ?></td>
        <td width="65%" align="left" class="vtop tips2">设置星期几执行本任务，“*”为不限制，本设置会覆盖下面的“日”设定</td>
      </tr>
      <tr class="nobg">
        <td align="left" class="vtop rowform">每月：<br>
        <?php 
			$cron['day'] = isset($cron['day']) ? $cron['day'] : '' ;
			echo GetSelect((array)$dayselect, 'day', $cron['day'], '' , 'style="width:340px;"', '*', '-1'); ?></td>
        <td align="left" class="vtop tips2">设置哪一日执行本任务，“*”为不限制</td>
      </tr>
      
      <tr>
        <td align="left" class="vtop rowform">小时：<br>
        <?php 
			$cron['hour'] = isset($cron['hour']) ? $cron['hour'] : '' ;
			echo GetSelect((array)$hourselect, 'hour', $cron['hour'], '' , 'style="width:340px;"', '*', '-1'); ?></td>
        <td align="left" class="vtop tips2">设置哪一小时执行本任务，“*”为不限制</td>
      </tr>
      <tr>
        <td align="left" class="vtop rowform">分钟：<br>
            <input name="minute" type="text" class="txt" id="minute" value="<?php echo isset($cronminute) ? $cronminute : '';?>" size="60"/></td>
        <td align="left" class="vtop tips2">设置哪些分钟执行本任务，至多可以设置 12 个分钟值，多个值之间用半角逗号“,”隔开，留空为不限制</td>
      </tr>
      <tr>
        <td align="left" class="vtop rowform">任务脚本：<br>
            <input name="filename" type="text" class="txt" id="filename" value="<?php echo isset($cron['filename']) ? $cron['filename'] : '';?>" size="60" dataType="Require" msg="任务脚本不能为空"/></td>
        <td align="left" class="vtop tips2">设置本任务的执行程序文件名，请勿包含路径，程序脚本统一存放于 ./include/crons/ 目录中</td>
      </tr>
      <tr class="nobg">
        <td colspan="15"><input name="button" type="submit" class="button" id="button" value="提交">
          <input name="id" type="hidden" id="id" value="<?php echo isset($id) ? $id : ''; ?>">
          <input name="usage" type="hidden" id="usage" value="1"></td>
      </tr>
    </table>
</form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>