<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: sign_init.php 2010-01-12 13:27:57 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查

if (isset($_POST['btnsubmit'])) {
	$aryid = simplode($_POST['itemid']);
	$_TGLOBAL['db']->query("DELETE FROM ".tname('sign')." WHERE id IN($aryid)");
	showmsg('报名删除成功！');
}

//排序方式
$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

$keywords = trim(isset($_POST['keywords']) ? $_POST['keywords'] : (isset($_GET['keywords']) ? $_GET['keywords'] : ''));
//$class_id = trim(isset($_POST['class_id']) ? $_POST['class_id'] : (isset($_GET['class_id']) ? $_GET['class_id'] : ''));
$start_date = trim(isset($_POST['start_date']) ? $_POST['start_date'] : (isset($_GET['start_date']) ? $_GET['start_date'] : ''));
$end_date = trim(isset($_POST['end_date']) ? $_POST['end_date'] : (isset($_GET['end_date']) ? $_GET['end_date'] : ''));
$start_date_unx = null;
$end_date_unx = null;
if($start_date){
	$start_date_unx = strtotime($start_date.' 00:00:00');
}
if($end_date){
	$end_date_unx = strtotime($end_date.' 23:59:59');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<link rel="stylesheet" href="https://at.alicdn.com/t/font_234130_nem7eskcrkpdgqfr.css">
	<style>
		*{
			margin: 0;
			padding: 0;
		}
		ul{
			list-style: none;
		}
		#schedule-box{
			width: 320px;
			margin: 0 auto;
			padding: 35px 20px;
			font-size: 13px;
		}
		
		#schedule-box1{
			width: 320px;
			margin: 0 auto;
			padding: 35px 20px;
			font-size: 13px;
		}
		
		.schedule-hd{
			display: flex;
			justify-content: space-between;
			padding: 0 15px;
		}
		.today{
			flex: 1;
			text-align: center;
		}
		.ul-box{
			overflow: hidden;
		}
		.ul-box > li{
			float: left;
			width: 14.28%;
			text-align: center;
			padding: 5px 0;
		}
		.other-month{
			color: #999999;
		}
		.current-month{
			color: #333333;
		}
		.today-style{
			border-radius: 50%;
			background: #58d321;
		}
		.arrow{
			cursor: pointer;
		}
		.dayStyle{
			display: inline-block;
			width: 35px;
			height: 35px;
			border-radius: 50%;
			text-align: center;
			line-height: 35px;
			cursor: pointer;
		}
		.current-month > .dayStyle:hover{
			background: #00BDFF;
			color: #ffffff;
		}
		.today-flag{
			background: #00C2B1;
			color: #fff;
		}
		.boxshaw{
			box-shadow: 2px 2px 15px 2px #e3e3e3;
		}
		.selected-style {
			background: #00BDFF;
			color: #ffffff;
		}
		/*#h3Ele{
			text-align: center;
			padding: 10px;
		}*/
	</style>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/jquery-1.11.0.min.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">

  <DIV class=datacontainer2 style="WIDTH: 98%">
    <!--<DIV class=header><a href="module.php?ac=sign&mod=init_add" class="MustFill">添加新的班级</a></DIV>-->
    <form  method="post" name="FormEdit">
      &nbsp;搜索
    <input name="keywords" type="text" id="keywords" size="30" placeholder="订单号，学员姓名，手机" value="<?php echo $keywords; ?>">
      <input name="button" type="submit" id="button" value="查询" class="button">
    </form>
    &nbsp;&nbsp;&nbsp;&nbsp;<input type="button" name="button" class="button" onclick="dcqb()" value="导出全部订单" />
    <input type="button" name="button" class="button" onclick="dcby()" value="导出本页订单" />
    
    <form  method="post" name="FormEdit">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text" name="start_date" id="start_date" size="20" placeholder="开始日期" value="<?php echo $start_date; ?>">
    	<input type="text" name="end_date" id="end_date" size="20" placeholder="结束日期" value="<?php echo $end_date; ?>">
      <input name="button" type="submit" id="s_button" value="查询" class="button">
    </form>
    <input type="button" name="button" class="button" onclick="dcrq()" value="导出" />
   	 	<div id='schedule-box' class="boxshaw" style="float: left;display: none;position: absolute;left: 400px;background:#FFFFFF;top:50px;"></div>
   	 	<div id='schedule-box1' class="boxshaw" style="float: left;display: none;position: absolute;left: 660px;background:#FFFFFF;top:50px;"></div>
	<!--<div>
		<h3 id='h3Ele'></h3>
	</div>-->
    
      <form  method="post" name="formpage">
      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption"><div align="center">选择</div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("ID", "id", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("订单编号", "sn", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("班级", "courseid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("学员openid", "openid", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("学员姓名", "name", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("性别", "sex", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("学员手机", "mobile", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("报考教练", "coach_id", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("是否缴费", "ispay", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("价格", "money", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("身份证", "cardno", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("合伙人", "", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("队员", "", $field, $order); ?></div></td>
            <td class="caption"><div align="center"><?php echo GetOrder("地址", "area", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center"><?php echo GetOrder("缴费时间", "paydate", $field, $order); ?></div></td>-->
            <td class="caption"><div align="center"><?php echo GetOrder("报名时间", "date", $field, $order); ?></div></td>
            <!--<td class="caption"><div align="center">详情</div></td>-->
          </tr>
<?php
	$perpage = 15;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE ispay=1";
	$keywords && $where .= " AND (name LIKE '%$keywords%' OR sn='$keywords' OR mobile='$keywords')";
	$start_date_unx && $end_date_unx && $where .= " AND date>='$start_date_unx' AND date<='$end_date_unx'";
	//$class_id && $where .= " AND class_id LIKE '$class_id%'";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('sign').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." $where ORDER BY $field $order LIMIT $start,$perpage");
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
            <td align="center"><input name="itemid[]" type="checkbox" id="itemid[]" value="<?php echo $value['id'];?>"></td>
            <td align="center"><?php echo $value['id']; ?></td>
            <td style="padding-left: 10px;"><?php echo $value['sn']; ?></td>
            <td align="center"><?php echo $value['courseid'] ? $_TGLOBAL['course'][$value['courseid']]['name'] : '&nbsp'; ?></td>
            <td align="center"><?php echo $value['openid']; ?></td>
            <td align="center"><?php echo $value['name']; ?></td>
            <!--<td align="center"><?php echo $value['sex'] ? $_TGLOBAL['setting']['sex'][$value['sex']] : ''; ?></td>-->
            <td align="center"><?php echo $value['mobile']; ?></td>
            <td align="center"><?php echo $value['coach_name']; ?></td>
            <td align="center"><?php echo $value['ispay'] ? '是' : '否'; ?></td>
            <td align="center"><?php echo $value['ispay'] ? $value['money'] : '-'; ?></td>
            <td align="center"><?php echo $value['cardno']; ?></td>
            <td align="center"><?php echo $value['duiyuan_name']; ?></td>
            <td align="center"><?php echo $value['captain_name']; ?></td>
            <td align="center"><?php echo $value['area']; ?></td>
            <!--<td align="center"><?php echo $value['ispay'] ? date("Y-m-d H:i", $value['paydate']) : '-'; ?></td>-->
            <td align="center"><?php echo date("Y-m-d H:i", $value['date']); ?></td>
            <!--<td align="center"><a href="module.php?ac=course&mod=sign_edit&id=<?php echo $value['id']; ?>">详情</a></td>-->
          </tr>
<?php } ?>
        </tbody>
      </table>
      
      <input type="checkbox" name="checkbox" id="checkbox" onClick="chkbox_sel_all(this.form.name,'itemid[]', this.checked);">
      <label for="checkbox">全选</label>&nbsp;&nbsp;
       <input name="btnsubmit" type="submit" class="button" id="btnsubmit" value="删除" onClick="return submit_select_items(this.form.name,'itemid[]','删除');">
    </form>
  <div align="center"><span class="page"><?php echo $multi; ?></span></div>
</DIV>

<script type="text/javascript">
	function dcqb(){
		window.location.href="/index.php?do=dc_sign";
	}
	
	function dcby(){
		window.location.href="/index.php?do=dc_sign&page=<?php echo $page ?>";
	}
	
	function dcrq(){
		window.location.href="/index.php?do=dc_sign&start_date_unx=<?php echo $start_date_unx ?>&end_date_unx=<?php echo $end_date_unx ?>";
	}
</script>



  <?php include 'footer.php'; ?>
</BODY>
<script src="js/schedule.js"></script>
<script>
	
	$("#start_date").focus(function(){
		$("#schedule-box").css("display","block");
		$("#schedule-box1").css("display","none");
	});
	
	$("#end_date").focus(function(){
		$("#schedule-box1").css("display","block");
		$("#schedule-box").css("display","none");
	});
	var mySchedule = new Schedule({
		el: '#schedule-box',
		//date: '2018-9-20',
		clickCb: function (y,m,d) {
			document.querySelector('#start_date').value = y+'-'+m+'-'+d;
			$("#schedule-box").css("display","none");
		},
		nextMonthCb: function (y,m,d) {
			document.querySelector('#start_date').value = y+'-'+m+'-'+d;
		},
		nextYeayCb: function (y,m,d) {
			document.querySelector('#start_date').value = y+'-'+m+'-'+d;
		},
		prevMonthCb: function (y,m,d) {
			document.querySelector('#start_date').value = y+'-'+m+'-'+d;
		},
		prevYearCb: function (y,m,d) {
			document.querySelector('#start_date').value = y+'-'+m+'-'+d;
		}
	});
	
	var mySchedule1 = new Schedule({
		el: '#schedule-box1',
		//date: '2018-9-20',
		clickCb: function (y,m,d) {
			document.querySelector('#end_date').value = y+'-'+m+'-'+d;
			$("#schedule-box1").css("display","none");
		},
		nextMonthCb: function (y,m,d) {
			document.querySelector('#end_date').value = y+'-'+m+'-'+d	;
		},
		nextYeayCb: function (y,m,d) {
			document.querySelector('#end_date').value = y+'-'+m+'-'+d	;
		},
		prevMonthCb: function (y,m,d) {
			document.querySelector('#end_date').value = y+'-'+m+'-'+d	;
		},
		prevYearCb: function (y,m,d) {
			document.querySelector('#end_date').value = y+'-'+m+'-'+d	;
		}
	});
</script>
</HTML>