<?php
/* Smarty version 3.1.30, created on 2018-08-24 02:57:35
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/my_order.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7f741f8076a1_20841013',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7f054b350a3d4cb3bd7e32088e4381ef4becc368' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/my_order.html',
      1 => 1534741554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b7f741f8076a1_20841013 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['orders']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
			<div class="row order">
				<div class="col-xs-12 order-number">
					<p>订单编号：<span><?php echo $_smarty_tpl->tpl_vars['item']->value['sn'];?>
</span></p>
				</div>
				<div class="col-xs-12 order-detail">
					<p>学车类型：<span><?php echo $_smarty_tpl->tpl_vars['item']->value['class_name'];?>
</span></p>
					<p>学车场地：<span><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</span></p>
					<p>陪练教练：<span><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</span></p>
					<p>下单时间：<span><?php echo date("Y-m-d H:i:s",$_smarty_tpl->tpl_vars['item']->value['paydate']);?>
</span></p>
				</div>
				<div class="col-xs-12 order-price">
					<div class="right">价格 <span>￥<?php echo $_smarty_tpl->tpl_vars['item']->value['money'];?>
</span></div>
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
