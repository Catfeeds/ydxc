<?php
/* Smarty version 3.1.30, created on 2018-08-29 05:12:49
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/pxxy.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b862b51882bd5_15258251',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b0c54064ffcbdb56efd7d89bda0f3d1d3562ce2b' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/pxxy.html',
      1 => 1534741554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b862b51882bd5_15258251 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container" style="font-size: initial; text-align: center; padding: 20px;">
			<?php echo $_smarty_tpl->tpl_vars['pxxy']->value['content'];?>

		</div>
	</body>
</html>
<?php }
}
