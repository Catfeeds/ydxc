<?php
/*
	[CTB] (C) 2007-2009 您
	$Id: money_add.php 2012-7-4 9:03:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission('', 'money'); //权限检查

if (isset($_POST['usage'])) {

		//以出此用户ID
		$query   = $_TGLOBAL['db']->query("SELECT Balance, Openid, id FROM ".tname('members')." WHERE CustomerID = '$_POST[username]'");
		if(!($userinfo = $_TGLOBAL['db']->fetch_array($query))) {
			showmsg('错误：你输入的用户名不存在！');
		}

		//如果输入的金额 > 当前用户金额
		if ($_POST['money'] < 0) {
			if (abs($_POST['money']) > $userinfo['Balance'] && $userinfo['Balance'] > 0) {
				$_POST['money'] = -$userinfo['Balance'];
			}
		}
		
		$total = $_POST['money'];

		//添加到记录表
		$arr = array( 'uid' => $userinfo['id'],
					   'op' =>  'admin',
					   'money' => $total,
					   'cur_money' => $userinfo['Balance'],
					   'remark' => 	$_POST['remark'],
					  );
		$money_id = add_member_money($arr);

        /*
        充值成功，模板通知用户
        */
        template_enter($userinfo['Openid'], 'recharge_ok', $total, $money_id, '客服调整');




		showmsg('用户余额增加成功！', $_TGLOBAL['refer']);
}

$CustomerID = isset($_GET['CustomerID']) ? $_GET['CustomerID'] : '';
if($CustomerID){
	$members = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('members')." WHERE CustomerID='$CustomerID'");
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/jquery.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>用户余额增/减</DIV>
    <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="16%" class="caption">* 客户ID </td>
            <td width="84%"><input name="username" type="text" id="username" value="<?php echo $CustomerID; ?>" size="50" maxlength="255" datatype="Require" msg="请填写用户帐号." readonly>（客户ID不能修改）</td>
          </tr>
          <tr>
            <td width="16%" class="caption">当前金额 </td>
            <td width="84%"> &nbsp;<?php echo isset($members['Balance']) ? $members['Balance'] : '';?><input type="hidden" class="dq" value="<?php echo isset($members['Balance']) ? $members['Balance'] : '';?>"></td>
          </tr>
          <tr>
            <td class="caption">* 金额调整</td>
            <td><input name="money" type="text" id="money" size="50" maxlength="255" datatype="Range" min="0.01" max="10000" msg="请填写正确金额.">（正数增加金额，负数减少金额）</td>
          </tr>
          <tr>
            <td width="16%" class="caption">调整后金额 </td>
            <td width="84%"> &nbsp;<span class="tz">(输入调整金额后自动显示)</span></td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td><textarea name="remark" id="remark" cols="45" rows="5"></textarea></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
              <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>


<script>
	$("#money").blur(function(){
		var money = parseInt($(this).val());
		var dq = parseInt($(".dq").val());
		var tz = money + dq;
		tz = isNaN(tz) ? '请输入数字' : tz;
		$(".tz").html(tz);
		
	})
</script>