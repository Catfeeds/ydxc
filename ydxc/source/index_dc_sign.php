<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$ua = $_SERVER["HTTP_USER_AGENT"]; 
$filename = date("Y-m-d") ."报名订单.xls";
$encoded_filename = urlencode($filename); 
$encoded_filename = str_replace("+", "%20", $encoded_filename); 
header("Pragma: public");
      header("Expires: 0");
      header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Content-type:application/vnd.ms-excel;charset=utf-8");
      header("Content-Type: application/force-download");
      header("Content-Type: application/octet-stream");
      header("Content-Type: application/download");;
      if (preg_match("/MSIE/", $ua)) { 
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"'); 
		} else if (preg_match("/Firefox/", $ua)) { 
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"'); 
		} else { 
		header('Content-Disposition: attachment; filename="' . $filename . '"'); 
		} 
      header("Content-Transfer-Encoding: binary ");

	//排序方式
	$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
	$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;
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
            <td class="caption"><div align="center">订单编号</td>
            <td class="caption"><div align="center">班级</div></td>
            <td class="caption"><div align="center">学员姓名</div></td>
            <td class="caption"><div align="center">学员手机</div></td>
            <td class="caption"><div align="center">报考教练</div></td>
            <td class="caption"><div align="center">是否缴费</div></td>
            <td class="caption"><div align="center">价格</div></td>
            <td class="caption"><div align="center">身份证</div></td>
            <td class="caption"><div align="center">合伙人</div></td>
            <td class="caption"><div align="center">队员</div></td>
            <td class="caption"><div align="center">地址</div></td>
            <td class="caption"><div align="center">报名时间</div></td>
          </tr>
<?php
	$perpage = 15;
	$page = $_REQUEST['page'];
	$start_date_unx = $_REQUEST['start_date_unx'];
	$end_date_unx = $_REQUEST['end_date_unx'];
//	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE ispay=1";
	if($start_date_unx && $end_date_unx){
		$where .= " AND date>='$start_date_unx' AND date<='$end_date_unx'";
	}
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('sign').$where), 0);
	if(empty($page)){
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." $where ORDER BY $field $order");
	} else {
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." $where ORDER BY $field $order LIMIT $start,$perpage");
	}
	
	$multi = multi($count, $perpage, $page, get_current_url());
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$coach = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$value['coach_id']);
		$value['coach_name'] = $coach['xingming'];
		if(!empty($value['inv'])){
			$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$value['inv']);
	
			if(!empty($captain['cptid'])){ //如果有上级，就显示队员和队员的上级（合伙人）；否则只显示合伙人
				$value['captain_name'] = $captain['name'];
				$duiyuan = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$captain['cptid']);
				$value['duiyuan_name'] = $duiyuan['name'];
			} else {
				$value['duiyuan_name'] = $captain['name']; //显示合伙人
			}
		}
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><?php echo $value['id']; ?></td>
            <td style="padding-left: 10px;"><?php echo $value['sn']; ?></td>
            <td align="center"><?php echo $value['courseid'] ? $_TGLOBAL['course'][$value['courseid']]['name'] : '&nbsp'; ?></td>
            <td align="center"><?php echo $value['name']; ?></td>
            <td align="center"><?php echo $value['mobile']; ?></td>
            <td align="center"><?php echo $value['coach_name']; ?></td>
            <td align="center"><?php echo $value['ispay'] ? '是' : '否'; ?></td>
            <td align="center"><?php echo $value['ispay'] ? $value['money'] : '-'; ?></td>
            <td align="center" style="vnd.ms-excel.numberformat:@"><?php echo $value['cardno']; ?></td>
            <td align="center"><?php echo $value['duiyuan_name']; ?></td>
            <td align="center"><?php echo $value['captain_name']; ?></td>
            <td align="center"><?php echo $value['area']; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i", $value['date']); ?></td>
          </tr>
<?php } ?>
	</tbody>
 </table>
 </div> 
     </body> 
 </html> 