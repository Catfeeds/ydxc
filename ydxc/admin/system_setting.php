<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: system_setting.php 2009-5-3 21:45:48 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {
	//清空配置表所有记录
	//$_TGLOBAL['db']->query('TRUNCATE '.tname('config'));
	$_TGLOBAL['db']->query('DELETE FROM '.tname('config'));
	foreach($_POST['config'] AS $key => $val) {
		$setarr = array(
				'var'          => 	$key,
				'datavalue'    => 	$val
				);
		inserttable('config', $setarr, 0, true, 1);
	}

	data_set('setting', $_POST['setting']);
	data_set('mail', $_POST['mail']);
	
	config_cache();
	showmsg('系统设置成功！', $_TGLOBAL['refer']);
}

$query  = $_TGLOBAL['db']->query("SELECT * FROM ".tname('config'));
while ($value = $_TGLOBAL['db']->fetch_array($query)) {			
	$config[$value['var']] = $value['datavalue'];
}
//var_dump($config);
$setting = unserialize(data_get('setting'));
$mail = unserialize(data_get('mail'));


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <div align="center"><a href="#base">基本设置</a>　　<a href="#show">显示设置</a>　　<a href="#ftp">FTP设置</a>　　<a href="#mail">邮件设置</a>　　<a href="#other">其他设置</a>  </div>
  <DIV class=datacontainer2 style="WIDTH: 800px">
    <form action="" method="post" name="formset" id="formset">
    <DIV class=header>基本设置 </DIV>
    <TABLE class=list_table cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD class=caption align=right width=140>网站名称</TD>
          <TD width="660" colSpan=3 class=cell><input name="config[sitename]" type="text" id="config[sitename]" value="<?php echo @$config['sitename']; ?>" size="60">
            <input name="config[template]" type="hidden" id="config[template]" value="<?php echo @$_TCONFIG['template']; ?>"></TD>
        </TR>
        <TR>
          <TD class=caption align=right width=140>网站LOGO</TD>
          <TD class=cell colSpan=3><input name="config[sitelogo]" type="text" id="config[sitelogo]" value="<?php echo @$config['sitelogo']; ?>" size="60"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>说明</TD>
          <TD class=cell colSpan=3><textarea name="config[description]" cols="45" rows="4" id="config[description]"><?php echo @$config['description']; ?></textarea></TD>
        </TR>
        <TR>
          <TD class=caption align=right>关键词</TD>
          <TD class=cell colSpan=3><textarea name="config[keywords]" cols="45" rows="4" id="config[keywords]"><?php echo @$config['keywords']; ?></textarea></TD>
        </TR>
        <TR>
          <TD class=caption align=right>禁止文字或网址</TD>
          <TD class=cell colSpan=3><textarea name="config[prohibition]" cols="45" rows="4" id="config[prohibition]"><?php echo @$config['prohibition']; ?></textarea>
          多个请以,号分隔</TD>
        </TR>
        <TR>
          <TD class=caption align=right>网站备案信息代码</TD>
          <TD class=cell colSpan=3><input name="config[siteicpno]" type="text" id="config[siteicpno]" value="<?php echo @$config['siteicpno']; ?>" size="60">
          页面底部可以显示 ICP 备案信息，如果没有请留空</TD>
        </TR>
        <TR>
          <TD class=caption align=right>热门关键字</TD>
          <TD class=cell colSpan=3><input name="config[hotsearch]" type="text" id="config[hotsearch]" value="<?php echo @$config['hotsearch']; ?>" size="60">
            多个请以,号分隔</TD>
        </TR>
        <TR>
          <TD class=caption align=right>站点关闭</TD>
          <TD class=cell colSpan=3><input name="config[close]" type="checkbox" id="config[close]" value="1" <?php echo @$config['close'] ? 'checked' : ''; ?>>           
             暂时将网站关闭，其他人无法访问，但不影响管理员访问</TD>
        </TR>
        <TR>
          <TD class=caption align=right>关闭原因</TD>
          <TD class=cell colSpan=3><textarea name="config[closereason]" cols="45" rows="4" id="config[closereason]"><?php echo @$config['closereason']; ?></textarea></TD>
        </TR>
        <TR>
          <TD class=caption align=right><span class="cell">管理员邮箱</span></TD>
          <TD class=cell colSpan=3><input name="config[siteemail]" type="text" id="config[siteemail]" value="<?php echo @$config['siteemail']; ?>" size="60"></TD>
        </TR>
        <TR>
          <TD class=caption align=right><span class="cell">联系电话</span></TD>
          <TD class=cell colSpan=3><input name="config[sitetel]" type="text" id="config[sitetel]" value="<?php echo @$config['sitetel']; ?>" size="60">
          页面底部显示</TD>
        </TR>
        <TR>
          <TD class=caption align=right><span class="cell">公司传真</span></TD>
          <TD class=cell colSpan=3><input name="config[sitefax]" type="text" id="config[sitefax]" value="<?php echo @$config['sitefax']; ?>" size="60">
            页面底部显示</TD>
        </TR>
        <TR>
          <TD class=caption align=right><span class="cell">地址</span></TD>
          <TD class=cell colSpan=3><input name="config[siteaddress]" type="text" id="config[siteaddress]" value="<?php echo @$config['siteaddress']; ?>" size="60">
          同上</TD>
        </TR>
        <TR>
          <TD class=caption align=right><span class="cell">联系QQ</span></TD>
          <TD class=cell colSpan=3><input name="config[siteQQ]" type="text" id="config[siteQQ]" value="<?php echo @$config['siteQQ']; ?>" size="60">
          页面底部显示，多个以,号分开</TD>
        </TR>
        <TR>
          <TD class=caption align=right>联系人</TD>
          <TD class=cell colSpan=3><textarea name="config[sitecontact]" cols="45" rows="4" id="config[sitecontact]"><?php echo @$config['sitecontact']; ?></textarea></TD>
        </TR>
        <TR>
          <TD class=caption align=right>阿里旺旺</TD>
          <TD class=cell colSpan=3><input name="config[sitewangwang]" type="text" id="config[sitewangwang]" value="<?php echo @$config['sitewangwang']; ?>" size="60">
          同上</TD>
        </TR>
        
        <TR>
          <TD class=caption align=right>第三方统计代码</TD>
          <TD class=cell colSpan=3><textarea name="config[statcode]" cols="45" rows="4" id="config[statcode]"><?php echo @$config['statcode']; ?></textarea>
          页面底部可以显示第三方统计</TD>
        </TR>
        <TR>
          <TD class=caption align=right>开发者AppId</TD>
          <TD class=cell colSpan=3><input name="config[weixin_AppId]" type="text" id="config[weixin_AppId]" value="<?php echo @$config['weixin_AppId']; ?>" size="60"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>开发者AppSecret</TD>
          <TD class=cell colSpan=3><input name="config[weixin_AppSecret]" type="text" id="config[weixin_AppSecret]" value="<?php echo @$config['weixin_AppSecret']; ?>" size="60"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>开发者TOKEN</TD>
          <TD class=cell colSpan=3><input name="config[weixin_TOKEN]" type="text" id="config[weixin_TOKEN]" value="<?php echo @$config['weixin_TOKEN']; ?>" size="60"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>注册时默认上级微信号</TD>
          <TD class=cell colSpan=3><input name="config[newreg_default_recomm_id]" type="text" id="config[newreg_default_recomm_id]" value="<?php echo @$config['newreg_default_recomm_id']; ?>" size="60"></TD>
        </TR>
      </TBODY>
    </TABLE>
    <DIV class=header><a name="show" id="member5"></a>显示设置 </DIV>
    <TABLE class=list_table cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>

        
        <TR>
          <TD class=caption align=left width=144>商品缩略图宽</TD>
          <TD width="656" class=cell><input name="setting[thumbwidth]" type="text" id="setting[thumbwidth]" value="<?php echo @$setting['thumbwidth']; ?>" size="20">
            像素</TD>
        </TR>
        <TR>
          <TD class=caption align=right>商品缩略图高</TD>
          <TD class=cell><input name="setting[thumbheight]" type="text" id="setting[thumbheight]" value="<?php echo @$setting['thumbheight']; ?>" size="20">
像素</TD>
        </TR>
        <TR>
          <TD class=caption align=left>商品最大图片宽</TD>
          <TD class=cell><input name="setting[maxthumbwidth]" type="text" id="setting[maxthumbwidth]" value="<?php echo @$setting['maxthumbwidth']; ?>" size="20">
            像素　图片过大时，将自动裁剪至此像素</TD>
        </TR>
        <TR>
          <TD class=caption align=right>商品最大图片高</TD>
          <TD class=cell><input name="setting[maxthumbheight]" type="text" id="setting[maxthumbheight]" value="<?php echo @$setting['maxthumbheight']; ?>" size="20">
            像素</TD>
        </TR>
        <TR>
          <TD class=caption align=right>使用图片水印功能</TD>
          <TD class=cell>
          <input name="config[allowwatermark]" type="checkbox" id="config[allowwatermark]" value="1" <?php echo @$config['allowwatermark'] ? 'checked' : ''; ?>></TD>
        </TR>
        <TR>
          <TD class=caption align=right>水印图片地址</TD>
          <TD class=cell><input name="setting[watermarkfile]" type="text" id="setting[watermarkfile]" value="<?php echo @$setting['watermarkfile']; ?>" size="６0"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>水印图片位置</TD>
          <TD class=cell><?php echo GetRadio(array(1=>'顶端居左', 2=>'顶端居右', 3=>'底端居左', 4=>'底端居右', 5=>'随机'), 'setting[watermarkpos]', $setting['watermarkpos']); ?></TD>
        </TR>
        <TR>
          <TD class=caption align=right>咨询人数</TD>
          <TD class=cell><input name="config[zixun]" type="text" id="config[zixun]" value="<?php echo @$config['zixun']; ?>" size="６0"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>取得驾照人数</TD>
          <TD class=cell><input name="config[jiazhao]" type="text" id="config[jiazhao]" value="<?php echo @$config['jiazhao']; ?>" size="６0"></TD>
        </TR>
      </TBODY>
    </TABLE>
    <DIV class=header><a name="ftp" id="member6"></a>FTP设置 </DIV>
    <TABLE class=list_table cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD class=caption align=left width=142> 使用FTP上传商品图片</TD>
          <TD width="658" class=cell><input name="config[allowftp]" type="checkbox" id="config[allowftp]" value="1" <?php echo @$config['allowftp'] ? 'checked' : ''; ?>></TD>
        </TR>
        <TR>
          <TD class=caption align=right>使用FTP SSL传输</TD>
          <TD class=cell><input name="setting[ftpssl]" type="checkbox" id="setting[ftpssl]" value="1" <?php echo @$setting['ftpssl'] ? 'checked' : ''; ?>></TD>
        </TR>
        <TR>
          <TD class=caption align=left>FTP地址</TD>
          <TD class=cell><input name="setting[ftphost]" type="text" id="setting[ftphost]" value="<?php echo @$setting['ftphost']; ?>" size="50"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>端口</TD>
          <TD class=cell><input name="setting[ftpport]" type="text" id="setting[ftpport]" value="<?php echo @$setting['ftpport']; ?>" size="50"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>用户名</TD>
          <TD class=cell><input name="setting[ftpuser]" type="text" id="setting[ftpuser]" value="<?php echo @$setting['ftpuser']; ?>" size="50"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>密码</TD>
          <TD class=cell><input name="setting[ftppassword]" type="text" id="setting[ftppassword]" value="<?php echo @$setting['ftppassword']; ?>" size="50"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>使用PASV被动模式</TD>
          <TD class=cell><input name="setting[ftppasv]" type="checkbox" id="setting[ftppasv]" value="1" <?php echo @$setting['ftppasv'] ? 'checked' : ''; ?>></TD>
        </TR>
        <TR>
          <TD class=caption align=right>图片在FTP上的目录</TD>
          <TD class=cell><input name="setting[]" type="text" id="setting[ftpdir]" value="<?php echo @$setting['ftpdir']; ?>" size="50"></TD>
        </TR>
        <TR>
          <TD class=caption align=right>超时设置</TD>
          <TD class=cell><input name="setting[ftptimeout]" type="text" id="setting[ftptimeout]" value="<?php echo @$setting['ftptimeout']; ?>" size="50">
            秒</TD>
        </TR>
      </TBODY>
    </TABLE>
    <DIV class=header><a name="mail" id="member7"></a>邮件设置 </DIV>
    <table class="tab_01">
  <tr>
    <td colspan="2">邮件发送方式:</td>
  </tr>
  <tr class="noborder">
    <td colspan="2"><input class="radio" type="radio" name="mail[mailsend]" value="1" <?php echo $mail['mailsend'] == 1 ? 'checked' : ''; ?> onClick="_$('hidden1').style.display = 'none';_$('hidden2').style.display = 'none';">
通过 PHP 函数的 sendmail 发送(推荐此方式) <br>
<input class="radio" type="radio" name="mail[mailsend]" value="2" <?php echo $mail['mailsend'] == 2 ? 'checked' : ''; ?> onClick="_$('hidden1').style.display = '';_$('hidden2').style.display = '';">
      通过 SOCKET 连接 SMTP 服务器发送(支持 ESMTP 验证)<br>
      <input class="radio" type="radio" name="mail[mailsend]" value="3" <?php echo $mail['mailsend'] == 3 ? 'checked' : ''; ?> onClick="_$('hidden1').style.display = '';_$('hidden2').style.display = 'none';">
      通过 PHP 函数 SMTP 发送 Email(仅 Windows 主机下有效, 不支持 ESMTP 验证) </td>
    </tr>
  <tbody class="sub" id="hidden1" style="<?php echo $mail['mailsend'] == 1  ? 'display: none' : ''; ?>">
    <tr>
      <td colspan="2">SMTP 服务器:</td>
    </tr>
    <tr class="noborder">
      <td width="460"><input name="mail[server]" type="text" value="<?php echo @$mail['server']; ?>" size="40"/></td>
      <td width="328">设置 SMTP 服务器的地址</td>
    </tr>
    <tr>
      <td colspan="2">SMTP 端口:</td>
    </tr>
    <tr class="noborder">
      <td><input name="mail[port]" type="text" value="<?php echo @$mail['port']; ?>" size="40"/></td>
      <td>设置 SMTP 服务器的端口，默认为 25</td>
    </tr>
  </tbody>
  <tbody class="sub" id="hidden2" style="<?php echo @$mail['mailsend'] == 1 || $mail['mailsend'] == 3  ? 'display: none' : ''; ?>">
    <tr>
      <td colspan="2">SMTP 服务器要求身份验证:</td>
    </tr>
    <tr class="noborder">
      <td><input class="radio" type="radio" name="mail[auth]" value="1" checked>
        是
        <input class="radio" type="radio" name="mail[auth]" value="0" >
        否 </td>
      <td>如果 SMTP 服务器要求身份验证才可以发信，请选择“是”</td>
    </tr>
    <tr>
      <td colspan="2">发信人邮件地址:</td>
    </tr>
    <tr class="noborder">
      <td><input name="mail[from]" type="text" value="<?php echo @$mail['from']; ?>" size="40"/></td>
      <td>如果需要验证, 必须为本服务器的邮件地址。邮件地址中如果要包含用户名，格式为“username &lt;user@domain.com&gt;”</td>
    </tr>
    <tr>
      <td colspan="2">SMTP 身份验证用户名:</td>
    </tr>
    <tr class="noborder">
      <td><input name="mail[auth_username]" type="text" value="<?php echo @$mail['auth_username']; ?>" size="40"/></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2">SMTP 身份验证密码:</td>
    </tr>
    <tr class="noborder">
      <td><input name="mail[auth_password]" type="password" size="40" value="<?php echo $mail['auth_password']; ?>"/></td>
      <td></td>
    </tr>
  </tbody>
  <tr>
    <td colspan="2">邮件头的分隔符:</td>
  </tr>
  <tr class="noborder">
    <td><input class="radio" type="radio" name="mail[maildelimiter]" value="1" <?php echo @$mail['maildelimiter'] == 1 ? 'checked' : ''; ?> >
      使用 CRLF 作为分隔符(通常为 Windows 主机)
        <br>
        <input class="radio" type="radio" name="mail[maildelimiter]" value="0" <?php echo @$mail['maildelimiter'] == 0 ? 'checked' : ''; ?> >
      使用 LF 作为分隔符(通常为 Unix/Linux 主机)
      <br>
      <input class="radio" type="radio" name="mail[maildelimiter]" value="2" <?php echo @$mail['maildelimiter'] == 2 ? 'checked' : ''; ?> >
      使用 CR 作为分隔符(通常为 Mac 主机) </td>
    <td>请根据您邮件服务器的设置调整此参数</td>
  </tr>
  <tr>
    <td colspan="2">收件人地址中包含用户名:</td>
  </tr>
  <tr class="noborder">
    <td><input class="radio" type="radio" name="mail[mailusername]" value="1" <?php echo @$mail['mailusername'] == 1 ? 'checked' : ''; ?>>
      是
      <input class="radio" type="radio" name="mail[mailusername]" value="0" <?php echo @$mail['mailusername'] == 0 ? 'checked' : ''; ?>>
      否 </td>
    <td>选择“是”将在收件人的邮件地址中包含用户名</td>
  </tr>
  <tr>
    <td colspan="2">屏蔽邮件发送中的全部错误提示:</td>
  </tr>
  <tr class="noborder">
    <td><input class="radio" type="radio" name="mail[sendmail_silent]" value="1" <?php echo @$mail['sendmail_silent'] == 1 ? 'checked' : ''; ?>>
      是
      <input class="radio" type="radio" name="mail[sendmail_silent]" value="0" <?php echo @$mail['sendmail_silent'] == 0 ? 'checked' : ''; ?>>
      否 </td>
    <td></td>
  </tr>
</table>

    <DIV class=header><a name="other" id="member4"></a>其他设置 </DIV>
    <TABLE class=list_table cellSpacing=0 cellPadding=0 width="100%" border=0>
      <TBODY>
        <TR>
          <TD align=right class=caption>时区设置</TD>
          <TD align=right class=caption><div align="left">
            <input name="setting[timeoffset]" type="text" id="setting[timeoffset]" value="<?php echo @$setting['timeoffset']; ?>" size="20">
          </div></TD>
        </TR>
        <TR>
          <TD align=right class=caption>管理员帐号在线时间</TD>
          <TD align=right><div align="left">
            <input name="config[adminonline]" type="text" id="config[adminonline]" value="<?php echo @$config['adminonline']; ?>" size="20">
            单位：秒<br>
          设置后，在此单位内，管理员将不能再次登录。为空则不使用此功能 </div></TD>
        </TR>
        <TR>
          <TD align=right class=caption>记录管理员操作</TD>
          <TD align=left>            <input name="config[allowadminlog]" type="checkbox" id="config[allowadminlog]" value="1" <?php echo @$config['allowadminlog'] ? 'checked' : ''; ?>>          </TD>
        </TR>
        <TR>
          <TD width="17%" align=right class=caption>允许访问的IP列表</TD>
          <TD width="83%" align=left><div align="left"><span class="cell">
            <textarea name="config[ipaccess]" cols="45" rows="5" id="config[ipaccess]"><?php echo @$config['ipaccess']; ?></textarea>
          </span>多个IP时，一行一个IP地址</div></TD>
        </TR>
        <TR>
          <TD align=right class=caption>拒绝访问的IP列表</TD>
          <TD align=right class=caption><div align="left"><span class="cell">
            <textarea name="config[ipbanned]" cols="45" rows="5" id="config[ipbanned]"><?php echo @$config['ipbanned']; ?></textarea>
          </span></div></TD>
        </TR>
      </TBODY>
    </TABLE>
    <div align="center"><br>
      <input name="usage" type="hidden" id="usage" value="1">
      <input name="button" type="submit" class="button" id="button" value="提交">
      <br>
      <br>
    </div>
  </form>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
