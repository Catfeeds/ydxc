<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$ua = $_SERVER["HTTP_USER_AGENT"]; 
$filename = date("Y-m-d") ."教练列表.xls"; 
$encoded_filename = urlencode($filename); 
$encoded_filename = str_replace("+", "%20", $encoded_filename); 
header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Content-type:application/vnd.ms-excel;charset=utf-8");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");
      if (preg_match("/MSIE/", $ua)) { 
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"'); 
		} else if (preg_match("/Firefox/", $ua)) { 
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"'); 
		} else { 
		header('Content-Disposition: attachment; filename="' . $filename . '"'); 
		} 
      header("Content-Transfer-Encoding: binary ");

	//排序方式
	$field  = isset($_GET['field']) ? $_GET['field'] : 'kemu';
	$order = isset($_GET['order']) ? $_GET['order'] : 'asc' ;
?>
	<html xmlns:o="urn:schemas-microsoft-com:office:office"
 xmlns:x="urn:schemas-microsoft-com:office:excel"
 xmlns="http://www.w3.org/TR/REC-html40">
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
 <html> 
     <head> 
        <meta http-equiv="Content-type" content="text/html;charset=UTF-8" /> 
         <style id="Classeur1_16681_Styles"></style> 
     </head> 
     <body> 
         <div id="Classeur1_16681" align=center x:publishsource="Excel"> 
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">id</div></td>
            <td class="caption"><div align="center">教练姓名</td>
            <td class="caption"><div align="center">教练电话</div></td>
            <td class="caption"><div align="center">优质教练</div></td>
            <td class="caption"><div align="center">科目</div></td>
            <td class="caption"><div align="center">驾驶类型</div></td>
            <td class="caption"><div align="center">累计培训人数</div></td>
            <td class="caption"><div align="center">科二通过率</div></td>
            <td class="caption"><div align="center">科三通过率</div></td>
            <td class="caption"><div align="center">教练所属场地</div></td>
          </tr>
<?php
	$perpage = 15;
	$page = $_REQUEST['page'];
//	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE class_id=3";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('news').$where), 0);
	if(empty($page)){
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." $where ORDER BY $field $order");
	} else {
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." $where ORDER BY $field $order LIMIT $start,$perpage");
	}
	$multi = multi($count, $perpage, $page, get_current_url());
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><?php echo $value['id']; ?></td>
            <td align="center"><?php echo $value['xingming']; ?></td>
            <td align="center"><?php echo $value['coach_phone']; ?></td>
            <td align="center"><?php if($value['good_coach']==1){echo '是';}else{echo '否';} ?></td>
            <td align="center"><?php echo '科目'.$value['kemu']; ?></td>
            <td align="center"><?php echo $value['drive_type']; ?></td>
            <td align="center"><?php echo $value['ljpxrs']; ?></td>
            <td align="center"><?php echo $value['ketgl'].'%'; ?></td>
            <td align="center"><?php echo $value['kstgl'].'%'; ?></td>
            <?php $sscd = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." where id=".$value['sscd']);?>
            <td align="center"><?php echo $sscd['title']; ?></td>
          </tr>
<?php } ?>
	</tbody>
 </table>
 </div> 
     </body> 
 </html> 