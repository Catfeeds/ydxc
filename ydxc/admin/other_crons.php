<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: other_crons.php 2010-1-12 15:58:39 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['usage'])) {   

  switch($_POST['type_mode']) {
	 case 'delete' :
		 $aryid = simplode($_POST['itemid']);
		 $_TGLOBAL['db']->query('DELETE FROM '.tname('crons')." WHERE cronid IN($aryid) AND type='user'");
		 showmsg('计划任务删除成功！', 'module.php?ac=other&mod=crons');
		 break;
	 case 'update' :
	 	 foreach($_POST['namenew'] AS $key => $value) {
			$advarr = array(
				'name'			=> 	$_POST['namenew'][$key],
				'available'     => 	$_POST['availablenew'][$key]
				//'nextrun'       =>  0
			);
			updatetable('crons', $advarr, array('cronid' => $key));
		 }
		 showmsg('计划任务修改成功！', $_TGLOBAL['refer']);
		 break;
 }
}

//取出修改时的信息
$id = isset($_GET['runid']) ? (int)$_GET['runid'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('crons')." WHERE cronid='$id'");
	$cron = $_TGLOBAL['db']->fetch_array($query);
	
	$cron['filename'] = str_replace(array('..', '/', '\\'), array('', '', ''), $cron['filename']);
	$cronminute = str_replace("\t", ',', $cron['minute']);
	$cron['minute'] = explode("\t", $cron['minute']);
	
	
	if(!@include_once S_ROOT.($cronfile = S_ROOT."./lib/crons/$cron[filename]")) {
		showmsg('计划任务发生错误，请检查此脚本'.$cron[filename]);
	} else {
		require_once S_ROOT.'./lib/function/function_cron.php';
		cronnextrun($cron);
	}
	
	showmsg('计划任务运行成功！', $_TGLOBAL['refer']);
}

$query = $_TGLOBAL['db']->query('SELECT cronid, filename FROM '.tname('crons'));
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
   if(!file_exists(S_ROOT.'./lib/crons/'.$value['filename'])) {
		$_TGLOBAL['db']->query("UPDATE ".tname('crons')." SET available='0', nextrun='0' WHERE cronid='$value[cronid]'");		
	}
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header><a href="module.php?ac=other&mod=crons_work" class="MustFill">添加计划任务</a></DIV>
    <form name="FormPage" method="post" action="">
    <div align="center"><?php 
  //排序方式
	$field  = isset($_GET['field']) ? $_GET['field'] : 'cronid';
	$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;
	
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);	

	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('crons')), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('crons')." ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	
?>
      <br>
      <a href="module.php?ac=other&mod=gegz_work&type=<?php echo $type; ?>"></a></div>
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tr bgcolor="#F1F5FE" align="center">
        <td class="caption"><div align="center"><?php echo GetOrder("任务名称","name",$field,$order); ?></div></td>
        <td class="caption"><div align="center"><?php echo GetOrder("可用","available",$field,$order); ?></div></td>
        <td class="caption"><div align="center"><?php echo GetOrder("类型","type",$field,$order); ?></div></td>
        <td class="caption"><div align="center">时间</div>        </td>
        <td class="caption"><div align="center"><?php echo GetOrder("上次运行时间","lastrun",$field,$order); ?></div></td>
        <td class="caption"><div align="center"><?php echo GetOrder("下次运行时间","nextrun",$field,$order); ?></div></td>
        <td class="caption"><div align="center">选择</div></td>
        <td class="caption">&nbsp;</td>
      </tr>
      <?php 
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	

	$cronid = $value['cronid'];
	
	$value['time'] = '';
	if($value['day'] > 0 && $value['day'] < 32) {
		$value['time'] .= '每月'.$value['day'].'日';
	} elseif($value['weekday'] >= 0 && $value['weekday'] < 7) {
		$value['time'] .= '每周'.lang('cron_week_day_'.$value['weekday']);
	} elseif($value['hour'] >= 0 && $value['hour'] < 24) {
		$value['time'] .= '每日';
	} else {
		$value['time'] .= '每小时';
	}
	
	isset($value['hour']) && $value['time'] .= ($value['hour'] >= 0 && $value['hour'] < 24) ? sprintf('%02d', $value['hour']).'时' : '';
	
	if(!in_array($value['minute'], array(-1, ''))) {
		foreach($value['minute'] = explode("\t", $value['minute']) as $k => $v) {
			$value['minute'][$k] = sprintf('%02d', $v);
		}
		$value['minute'] = implode(',', $value['minute']);
		$value['time'] .= $value['minute'].'分';
	} else {
		$value['time'] .= '00'.'分';
	}
	
	$value['lastrun'] = isset($value['lastrun']) ? gmdate("Y-n-j <\b\\r />H:i", $value['lastrun'] + $_TGLOBAL['setting']['timeoffset'] * 3600) : '<b>N/A</b>';
	$value['nextcolor'] = isset($value['nextrun']) && $value['nextrun'] + $_TGLOBAL['setting']['timeoffset'] * 3600 < $timestamp ? 'style="color: #ff0000"' : '';
	$value['nextrun'] = isset($value['nextrun']) ? gmdate("Y-n-j <\b\\r />H:i", $value['nextrun'] + $_TGLOBAL['setting']['timeoffset'] * 3600) : '<b>N/A</b>';

?>
      <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
        <td align="center"><input name="namenew[<?php echo $cronid?>]" type="text" class="txt" id="namenew[<?php echo $cronid?>]" value="<?php echo $value['name']?>" size="40"></td>
        <td align="center"><input name="availablenew[<?php echo $cronid?>]" type="checkbox" class="checkbox" id="availablenew[<?php echo $cronid?>]" value="1" <?php echo $value['available'] ? 'checked' : ''; ?>></td>
        <td align="center">          <?php echo $value['type']== 'system' ? '内置':'自定义'; ?>        </td>
        <td align="center"><?php echo $value['time']?></td>
        <td align="center"><?php echo $value['lastrun']?></td>
        <td align="center"> <?php echo $value['nextrun']?> </td>
        <td align="center"><input name="itemid[]" type="checkbox" class="read_only" id="itemid[]" value="<?php echo $cronid;?>" <?php echo $value['type']== 'system' ? 'disabled':''; ?>></td>
        <td align="center"><a href="module.php?ac=other&mod=crons_work&id=<?php echo $cronid?>">修改</a><br>
        <a href="module.php?ac=other&mod=crons&runid=<?php echo $cronid?>">执行</a></td>
      </tr>
      <?php  } ?>
      <tr align="center"> 
        <td colspan="8">
          <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
          <label for="checkbox">全选</label>
        <font color="#CC3366"></font>
          <input name="type_mode" type="radio" value="update" checked>
更新<font color="#CC3366">&nbsp; </font>
<input name="type_mode" type="radio" value="delete">
删除
<input name="usage" type="submit" class="button" id="usage" onClick="if(!confirm('确定要操作这些吗？')) return false;" value="提交"></td>
      </tr>
    </table>
  </form>
    <label for="checkbox"></label>
  </form>
  <u><span class="p14">帮助信息</span></u><span class="p14">：</span>
  <ul>
    <li><span class="p14">计划任务是一项使系统在规定时间自动执行某些特定任务的功能，在需要的情况下，您也可以方便的将其用于功能的扩展</span></li>
    <li>计划任务是与系统核心紧密关联的功能特性，不当的设置可能造成系统功能的隐患，严重时可能导致网站无法正常运行，因此请务必仅在您对计划任务特性十分了解，并明确知道正在做什么、有什么样后果的时候才自行添加或修改任务项目</li>
  </ul>
<div align="center"><span class="page"><?php echo $multi; ?></span></div></DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>