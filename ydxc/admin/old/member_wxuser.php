<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_wxuser.php 2010-6-9 20:01:11 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

if (isset($_POST['btnimport'])) {

	 set_time_limit(0);
	 $access_token = weixin_access_token();
	$result = getData("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token);
	$ary = json_decode($result);

	$total = 0;
	foreach($ary->data->openid AS $openid) {

		//判断用户是否存在
		$sql = "SELECT NULL FROM ctb_wx_user WHERE openid='$openid'";
		$query = $_TGLOBAL['db']->query($sql);
		//用户存在，则更新
		if (!$user = $_TGLOBAL['db']->fetch_array($query)) {  //添加用户信息
			$result = getData("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid);
			$u = json_decode($result, true);

			$_TGLOBAL['db']->query("
						INSERT INTO ctb_wx_user (	
							`agent_no`,
							`subscribe`,
							`openid`,
							`nickname`,
							`sex`,
							`city`,
							`country`,
							`province`,
							`language`,
							`headimgurl`,
							`subscribe_time`,
							`visit_time`
							)	
						 VALUES (	
							'$shop_no',
							'$u[subscribe]',
							'$openid',
							'$u[nickname]',
							'$u[sex]',
							'$u[city]',
							'$u[country]',
							'$u[province]',
							'$u[language]',
							'$u[headimgurl]',
							'$u[subscribe_time]',
							'$_TGLOBAL[timestamp]'
							)
					");
			$total++;
		}
		//导入所有用户
	}

	showmsg($total.'个 公众号用户导入成功', $_TGLOBAL['refer']);
}


if(isset ($_POST['btnsubmit'])) {

	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query("DELETE FROM ".tname('wx_user')." WHERE id IN($aryid)");
	showmsg('关注用户删除成功！', $_TGLOBAL['refer']);
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
$date_start = trim(isset($_POST['date_start']) ? $_POST['date_start'] : (isset($_GET['date_start']) ? $_GET['date_start'] : ''));
$date_end = trim(isset($_POST['date_end']) ? $_POST['date_end'] : (isset($_GET['date_end']) ? $_GET['date_end'] : ''));
$nickname = trim(isset($_POST['nickname']) ? $_POST['nickname'] : (isset($_GET['nickname']) ? $_GET['nickname'] : ''));
$openid = trim(isset($_POST['openid']) ? $_POST['openid'] : (isset($_GET['openid']) ? $_GET['openid'] : ''));
$province = trim(isset($_POST['province']) ? $_POST['province'] : (isset($_GET['province']) ? $_GET['province'] : ''));
$city = trim(isset($_POST['city']) ? $_POST['city'] : (isset($_GET['city']) ? $_GET['city'] : ''));


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<script language="JavaScript" src="js/selectTime.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>公众号关注用户 </DIV>
  <form  method="post" name="FormEdit">
    &nbsp;关键词搜索
    <input name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
    &nbsp;用户昵称
    <input name="nickname" type="text" id="nickname" value="<?php echo $nickname; ?>" size="30">
    &nbsp;openid
    <input name="openid" type="text" id="openid" value="<?php echo $openid; ?>" size="30">
    &nbsp;省份
    <input name="province" type="text" id="province" value="<?php echo $province; ?>" size="30">
    &nbsp;城市
    <input name="city" type="text" id="city" value="<?php echo $city; ?>" size="30">
    <span class="p">关注日期 </span>
    <input name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
  
    -
    <input name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
    <input name="button" type="submit" id="button" value="查询">
    <input name="btnimport" type="submit" class="button" id="btnimport" value="导入所有公众号用户">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td class="caption"><div align="center">选择</div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("订阅", "subscribe", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("OPENID", "openid", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("头像", "headimgurl", $field, $order); ?> </div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("用户昵称", "nickname", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("性别", "sex", $field, $order); ?></div>          </td>
          <td class="caption"><div align="center"><?php echo GetOrder("城市", "city", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("省份", "province", $field, $order); ?></div>          </td>
          <td class="caption"><div align="center"><?php echo GetOrder("关注时间", "subscribe_time", $field, $order); ?></div></td>
          <td class="caption"><div align="center"><?php echo GetOrder("最后访问时间", "visit_time", $field, $order); ?></div></td>
        </tr>
        <?php 
	$perpage = 20;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = ' WHERE 1';

	if ($keywords) {
		$where .= " AND (";
		$where .= " openid LIKE '%$keywords%'";//
		$where .= " OR nickname LIKE '%$keywords%'";//
		$where .= " OR province LIKE '%$keywords%'";		
		$where .= " OR city LIKE '%$keywords%'";
		$where .= " )";
	}
	
	if ($nickname) {
		$where .= " AND nickname LIKE '%$nickname%' ";
	}
	
	if ($openid) {
		$where .= " AND openid LIKE '%$openid%' ";
	}
	
	if ($province) {
		$where .= " AND province LIKE '%$province%' ";
	}
	
	if ($city) {
		$where .= " AND city LIKE '%$city%' ";
	}
	
    //处理日期段搜索
    if ($date_start && $date_end) {
		$date_start = strtotime($date_start.' 00:00:00'); //转换输入的时间为时间戳的方式
		$date_end = strtotime($date_end. ' 23:59:59');
		$where .= " AND (subscribe_time between '$date_start' and '$date_end')"; 
    }
	
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('wx_user')." ".$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('wx_user')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	
		

	if (isset($_POST['btnexport'])) { //导出
		$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('wx_user')." $where ORDER BY $field $order ");
		$arytitle = array('订阅','OPENID','用户昵称','性别','省份','城市','关注时间','最后访问时间');
		$arydata  = array();
		while ($value = $_TGLOBAL['db']->fetch_array($query)) {
			  $arydata[] = array(
								$value['subscribe'] ? "订阅" : "未订阅",							
								$value['openid'],							
								//$value['headimgurl'],							
								$value['nickname'],							
								$_TGLOBAL['setting']['gender'][$value['sex']],	
								$value['province'],	
								$value['city'],	
								$value['subscribe_time'] ? date("Y-m-d H:i" ,$value['subscribe_time']) : '',
								$value['visit_time'] ? date("Y-m-d H:i" ,$value['visit_time']) : '',
							  );
		}
		ob_end_clean();//清除缓冲区,避免乱码
		header("Content-type: text/html;charset=utf-8;");
		header('Content-Type: application/vnd.ms-excel;charset=utf-8;');
		$filename = '公众号关注用户';
		//echo $filename;die;
		makeexcel($filename, $arytitle, $arydata); //文件名，标题数组，数据数组
		die;
	}

	
	
while ($value = $_TGLOBAL['db']->fetch_array($query)) {	
?>
        <tr bgcolor="<?php echo $bgcolor = (isset($bgcolor) && $bgcolor == '#FFFFFF') ? '#F1F5FE' : '#FFFFFF'; ?>" onMouseOver="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='#E4EAF2';" onMouseOut="if (this.bgColor != '<?php echo $_TCONFIG['table_tr_click']; ?>') this.bgColor='<?php echo $bgcolor; ?>';" onClick="this.bgColor=this.bgColor == '<?php echo $_TCONFIG['table_tr_click']; ?>' ? '<?php echo $bgcolor; ?>' : '<?php echo $_TCONFIG['table_tr_click']; ?>';">
          <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['uid'];?>"></td>
          <td align="center"><b><font color="#CC0033"><?php echo $value['subscribe'] ? "√" : "&nbsp;"; ?></font></b></td>
          <td align="center"><?php echo $value['openid']; ?></td>
          <td align="center"><a href="<?php echo $value['headimgurl']; ?>" target="_blank"><img src="<?php echo $value['headimgurl']; ?>" width="50" border="0" /></a></td>
          <td align="center"><?php echo $value['nickname']; ?></td>
          <td align="center"><?php echo $_TGLOBAL['setting']['gender'][$value['sex']]; ?></td>
          <td align="center"><?php echo $value['city']; ?></td>
          <td align="center"><?php echo $value['province']; ?></td>
          <td align="center"><?php echo $value['subscribe_time'] ? date("Y-m-d H:i" ,$value['subscribe_time']) : '&nbsp'; ?></td>
          <td align="center"><?php echo $value['visit_time'] ? date("Y-m-d H:i" ,$value['visit_time']) : '&nbsp'; ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
    <label for="checkbox">全选</label>
    &nbsp;&nbsp;
    <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','操作');">
	<input name="btnexport" type="submit" class="button" id="btnexport" value="导出" onClick="return daochu_select_items(this.form.name,'itemid[]','操作');">
  </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>

<script>
// 提交，默认是批量导出
// 根据后两个参数确定
function daochu_select_items(form, obj_name, op_lang, op_action) {
	if(typeof(op_lang) == 'undefined') op_lang = '导出';
	if(typeof(op_action) == 'undefined') op_action = 1;
	if(confirm('你还没有选择导出的内容？\n\n点击“确定”导出全部内容，“取消”重新选择内容。')) {
		if(op_action == 1) {
			return true;
		} else {
			// 不提交默认表单中的action
			var oform	= document.forms[form];
			oform.action = op_action;
			oform.submit();
			return true;
		}
	} else {
		return false;
	}
}
</script>