<?php
/* Smarty version 3.1.30, created on 2018-10-10 06:07:30
  from "E:\hua\phpStudy\WWW\ydxctrue\ydxc\template\default\showmessage_admin.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5bbd972223ab79_17670308',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '05d7c7acf7312e8f74f018267b2198d6c08d39e8' => 
    array (
      0 => 'E:\\hua\\phpStudy\\WWW\\ydxctrue\\ydxc\\template\\default\\showmessage_admin.html',
      1 => 1539140354,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5bbd972223ab79_17670308 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<title>智能后台</title>
</head>
<body>
<div class="showmessage" align="center">
  <div class="ye_r_t">
    <div class="ye_l_t">
      <div class="ye_r_b">
        <div class="ye_l_b">
          <caption>
          <h2>信息提示</h2>
          </caption>
          <p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
          <p class="op"> <?php if ($_smarty_tpl->tpl_vars['url_forward']->value) {?> <a href="<?php echo $_smarty_tpl->tpl_vars['url_forward']->value;?>
">页面跳转中...</a> <?php } else { ?> <a href="javascript:history.back();">返回上一页</a> | <a href="module.php?ac=system&mod=admin">返回首页</a> <?php }?> </p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
<?php }
}
