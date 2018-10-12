<?php
/* Smarty version 3.1.30, created on 2018-09-07 07:24:04
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/pxxy.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b9227941743e2_88986737',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2c61db3ef58477fb9f460f34f8b590ccacf67b75' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/pxxy.html',
      1 => 1536233056,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b9227941743e2_88986737 (Smarty_Internal_Template $_smarty_tpl) {
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
