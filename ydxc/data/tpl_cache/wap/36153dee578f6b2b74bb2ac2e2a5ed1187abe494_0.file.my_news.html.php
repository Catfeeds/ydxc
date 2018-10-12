<?php
/* Smarty version 3.1.30, created on 2018-09-07 08:10:10
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/my_news.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b9232627dece4_86805374',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '36153dee578f6b2b74bb2ac2e2a5ed1187abe494' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/my_news.html',
      1 => 1536233056,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b9232627dece4_86805374 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['baoming_news']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<div class="row info">
				<p class="col-xs-12"><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['item']->value['inputtime']);?>
</p>
				<div class="col-xs-12">
					<h4>	学车报名</h4>
					<p><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</p>
				</div>
			</div>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tj_news']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<div class="row info">
				<p class="col-xs-12"><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['item']->value['inputtime']);?>
</p>
				<div class="col-xs-12">
					<h4>	体检申请</h4>
					<p><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</p>
				</div>
			</div>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</div>
		
	</body>
</html>
<?php }
}
