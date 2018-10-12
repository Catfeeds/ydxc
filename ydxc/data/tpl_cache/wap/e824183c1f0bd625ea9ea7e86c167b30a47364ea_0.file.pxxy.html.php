<?php
/* Smarty version 3.1.30, created on 2017-08-31 13:23:16
  from "/data/www/ydxc/ydxc/template/wap/pxxy.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a79d44e44098_79440025',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e824183c1f0bd625ea9ea7e86c167b30a47364ea' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/pxxy.html',
      1 => 1504155684,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59a79d44e44098_79440025 (Smarty_Internal_Template $_smarty_tpl) {
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
