<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: system_admin.php 2009-5-3 21:45:48 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//检录检查
!$_TGLOBAL['adm_username'] && header("Location: module.php?ac=system&mod=login");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('系统管理 &raquo; 管理首页 &raquo; ');">
<DIV class=sp_height_5px></DIV>
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
    var yy = now.getFullYear()<200 ? now.getFullYear()+1900:now.getFullYear();
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
<DIV id=top>
  <DIV class=top_bar>
    <UL>
      <LI class="spW10 fl"></LI>
      <LI class="item fl">系统管理员 <FONT color="red"><?php echo $_TGLOBAL['adm_username']; ?> </FONT>你好！ 欢迎您进入<FONT color="red"><?php echo $_TCONFIG['sitename']; ?></FONT>网站管理系统，现在是
        <SCRIPT language=javascript>
<!--
document.write('<span id="calendarYear" >'+thisYear()+'年</span>');
document.write('<span id="calendarMonth" >'+Year_Month()+'</span>');
document.write('<span id="calendarDay" >'+Date_of_Today()+'日</span>');
document.write('<span id="calendarClock4" >'+CurentTime()+'</span>');
setInterval('refreshCalendarClock()',1000);
//-->
</SCRIPT>
        。祝您工作愉快！<br>
<br>
 </LI>
    </UL>
    <DIV class=clearB></DIV>
  </DIV>
  <DIV class=datacontainer2 style="WIDTH: 720px">
    <DIV class=header>站点信息 </DIV>
    <TABLE class=list_table cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        
        <TR>
          <TD class=caption align=right width=120>站点名称</TD>
          <TD class=cell colSpan=3><?php echo $_TCONFIG['sitename']; ?> </TD>
        </TR>
        <TR>
          <TD class=caption align=right width=120>默认SEO数据</TD>
          <TD class=cell colSpan=3><TABLE class=none_border cellSpacing=2 cellPadding=2 width="100%" 
border=0>
              <TBODY>
                <TR>
                  <TD align=right width=120>title：</TD>
                  <TD><?php echo $_TCONFIG['sitename']; ?></TD>
                </TR>
                <TR>
                  <TD align=right width=120>keywords：</TD>
                  <TD><?php echo $_TCONFIG['keywords']; ?></TD>
                </TR>
                <TR>
                  <TD align=right width=120>description：</TD>
                  <TD><?php echo $_TCONFIG['description']; ?></TD>
                </TR>
              </TBODY>
            </TABLE>
            <br></TD>
        </TR>
        <TR>
          <TD class=caption align=right width=120>系统信息</TD>
          <TD class=cell colSpan=3>            <br>
            CTB&nbsp; <FONT color=#ff0000><?php echo X_VER; ?></FONT> Licensed to <?php echo $_TCONFIG['sitename']; ?><BR>
            <B>package 
            time: </B><?php echo X_RELEASE; ?><BR>
            <B>packager: </B>jerry<br>
            <BR></TD>
        </TR>
      </TBODY>
    </TABLE>
    <p>&nbsp;</p>
  </DIV>
  <br>
  <br>
  <?php include 'footer.php'; ?>
</DIV>
</BODY>
</HTML>
