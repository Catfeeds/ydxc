<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: lang_showmessage.php 2009-4-18 11:08:18 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$_TGLOBAL['msglang'] = array(

	//common
	'do_success' => '进行的操作完成了',
	'no_privilege' => '您目前没有权限进行此操作',
	'no_privilege_realname' => '您需要填写真实姓名后才能继续操作，<a href="cp.php?ac=profile">点这里设置真实姓名</a>',
	'is_blacklist' => '受对方的隐私设置影响，您目前没有权限进行本操作',
	'no_privilege_newusertime' => '您目前处于见习期间，需要等待 \\1 小时后才能进行本操作',
	'no_privilege_avatar' => '您需要设置自己的头像后才能进行本操作，<a href="cp.php?ac=avatar">点这里设置</a>',
	'no_privilege_friendnum' => '您需要添加 \\1 个好友之后，才能进行本操作，<a href="cp.php?ac=friend&op=find">点这里添加好友</a>',
	'no_privilege_email' => '您需要验证激活自己的邮箱后才能进行本操作，<a href="cp.php?ac=password">点这里激活邮箱</a>',
	'authnumcode_is_wrong' => '检验码输入错误,请返回重新输入',

	//source/function_common.php
	'site_temporarily_closed' => '站点暂时关闭',
	'ip_is_not_allowed_to_visit' => '不能访问，您当前的IP不在站点允许访问的范围内。',
	'no_data_pages' => '指定的页面已经没有数据了',
	'length_is_not_within_the_scope_of' => '分页数不在允许的范围内',

	//source/function_block.php
	'page_number_is_beyond' => '页数是否超出范围',

	//source/cp_login.php
	'users_were_not_empty_please_re_login' => '对不起，用户名不存在，请重新登录',
	'login_failure_please_re_login' => '对不起,登录失败,请重新登录',
	'login_success' => '登录成功了，现在引导您进入登录前页面',
	'to_login' => '你必须登录后，才能进行此操作',

	//source/cp_newreg.php
	'registered' => '注册成功了，进入网站  \\1',
	'password_inconsistency' => '两次输入的密码不一致',
	'profile_passwd_illegal' => '密码空或包含非法字符，请重新填写。',
	'profile_email_illegal' => '用户名不合法',
	'user_name_already_exists' => '用户名已经存在',
	'email_format_is_wrong' => 'Email 格式有误',
	'email_not_registered' => 'Email 不允许注册',
	'email_has_been_registered' => 'Email 已经被注册',
	'exists_reg' => '你已经是注册用户，请不要重复注册',
	'deny_newuser_reg' => '禁止新用户注册，请稍后再来',
	'email_has_error_1' => '用户名不合法',
	'email_has_error_2' => '包含不允许注册的词语',
	'email_has_error_3' => '用户名已经存在',
	'email_has_error_4' => 'Email 格式有误',
	'email_has_error_5' => 'Email 不允许注册',
	'email_has_error_6' => '该 Email 已经被注册',
	'email_has_error_7' => '未定义',

	//source/cp_profile.php
	'modify_success' => '你的资料更新成功',
	'nickname_is_exists' => '你的昵称已经被别人使用了，请重新填写',

	//source/cp_password.php
	'password_is_not_passed' => '输入的登录密码不正确,请返回重新确认',
	'oldpassword_is_wrong' => '旧密码输入错误,请返回重新确认',
	'password_is_success' => '密码修改成功，请牵记你的密码',

	//source/cp_logout.php \\1
	'logout_is_success' => '成功退出，正在返回  ',

	//source/cp_sendmail.php
	'email_input' => '您还没有设置邮箱，请在<a href="cp.php?ac=password">账号设置</a>中准确填写您的邮箱',
	'email_check_sucess' => '您输入的链接通过验证，邮件激活完成',
	'email_check_error' => '邮箱激活失败，请检查您输入的链接地址是否正确',
	'email_check_send' => '验证邮箱的激活链接已经发送到您刚才填写的邮箱,您会在几分钟之内收到激活邮件，请注意查收。',
	'email_error' => '填写的邮箱格式错误,请重新填写',


	//source/do_login.php
	'not_open_registration' => '非常抱歉，本站目前暂时不开放注册',
	'not_open_registration_invite' => '非常抱歉，本站目前暂时不允许用户直接注册，需要有好友邀请链接才能注册',
	'users_were_close_please_re_login' => '账户已禁用,请尽快联系客服微信:ddnkf-yuan   ddnkf-lili   ddnkf-taotao  ddnkf-xiaoqiang ',

	//source/cp_profile.php
	'store_name_is_exists' => '你输入的公司名称已经存在,请返回重新确认',


);

?>