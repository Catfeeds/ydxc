<?php
/* Smarty version 3.1.30, created on 2017-08-25 11:28:43
  from "/data/www/ydxc/ydxc/template/wap/coach_confirm.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599f996b3fac41_24048746',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e78d213b645e3714a8f2df777f453e49cb68f296' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/coach_confirm.html',
      1 => 1503631718,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_599f996b3fac41_24048746 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<!--<div class="row video">
				<img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg"/>
			</div>-->
			
			<div class="row assess">
				<h1 class="col-xs-12">科三教练</h1>
				<div class="col-xs-12 assess-nav">
					<div class="col-xs-12">
						<span style="float: left; font-size: initial;"><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['xingming'];?>
</span>
						<span style="float: right;font-size: initial;"><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['coach_phone'];?>
</span>
					</div>
				</div>
			</div>
			
			<div class="row site">
				<h1 class="col-xs-12">场地地址</h1>
				<div class="col-xs-12">
					<h2><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['sscd_name'];?>
</h2>
					<p><?php echo $_smarty_tpl->tpl_vars['address_arr']->value['result']['formatted_address'];?>
</p>
				</div>
			</div>
			
			<div class="kong row"></div>
			
	</body>
</html>
<?php }
}
