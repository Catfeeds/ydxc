<?php
/*
	[CTB] (C) 2007-2009 
	$Id: index_index.php 2011-5-13 14:35:03 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
$ua = $_SERVER["HTTP_USER_AGENT"]; 
$filename = date("Y-m-d") ."体检码管理.xls";
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
            <td class="caption"><div align="center">体检原码</div></td>
            <td class="caption"><div align="center">随机码</div></td>
            <td class="caption"><div align="center">体检新码</div></td>
            <td class="caption"><div align="center">录入时间</div></td>
            <td class="caption"><div align="center">是否分配</div></td>
            <td class="caption"><div align="center">所属机构</div></td>
            <td class="caption"><div align="center">申请人</div></td>
            <td class="caption"><div align="center">申请人电话</div></td>
            <td class="caption"><div align="center">申请时间</div></td>
          </tr>
<?php
	$perpage = 15;
	$page = $_REQUEST['page'];
//	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE 1=1";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('tj_code_info').$where), 0);
	if(empty($page)){
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tj_code_info')." $where ORDER BY $field $order");
	} else {
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tj_code_info')." $where ORDER BY $field $order LIMIT $start,$perpage");
	}
	$multi = multi($count, $perpage, $page, get_current_url());
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$check = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('check')." where old_code='".$value['tj_code']."'");
		 $openid = $check['openid'];
		 $wx_user = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('wx_user')." where openid='".$openid."'");
		 if(empty($wx_user['name'])){
		 	$value['stu_name'] = '';
		 } else {
			 $value['stu_name'] = $wx_user['name'];
		 }
		 if(empty($wx_user['phone'])){
		 	$value['stu_phone'] = '';
		 } else {
		 	$value['stu_phone'] = $wx_user['phone'];
		 }
		 if(empty($check['inputtime'])){
		 	$value['stu_inputtime'] = '';
		 } else {
			 $value['stu_inputtime'] = $check['inputtime'];
		 }
		 $sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news_class')." where id=".$value['belong_to']);
		$belong_to = $_TGLOBAL['db']->fetch_array($sql);
?>
          <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
            <td align="center"><?php echo $value['id']; ?></td>
            <td align="center" style="vnd.ms-excel.numberformat:@"><?php echo $value['tj_code'];?></td>
            <td align="center" style="vnd.ms-excel.numberformat:@"><?php echo $value['rand_code'];?></td>
            <td align="center" style="vnd.ms-excel.numberformat:@"><?php echo $value['tj_code_new'] ? $value['tj_code_new'] : '&nbsp;'; ?></td>
            <td align="center"><?php echo date("Y-m-d H:i",$value['inputtime']) ; ?></td>
            <td align="center"><?php if($value['is_use']==1){echo "未分配";}else{echo "已分配";} ?></td>
            <td align="center"><?php echo $belong_to['name']; ?></td>
            <td align="center"><?php echo $value['stu_name']; ?></td>
            <td align="center"><?php echo $value['stu_phone'];?></td>
            <td align="center"><?php echo date("Y-m-d H:i",$value['stu_inputtime']);?></td>
          </tr>
<?php } ?>
	</tbody>
 </table>
 </div> 
     </body> 
 </html> 