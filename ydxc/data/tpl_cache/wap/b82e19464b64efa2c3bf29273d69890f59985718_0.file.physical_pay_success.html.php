<?php
/* Smarty version 3.1.30, created on 2017-08-18 00:38:50
  from "/data/www/ydxcnew/ydxc/template/wap/physical_pay_success.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995c69ae15299_32298807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b82e19464b64efa2c3bf29273d69890f59985718' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/physical_pay_success.html',
      1 => 1502987924,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995c69ae15299_32298807 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		
		<div class="container">
			<div class="row success">
				<div class="col-xs-12">
					<i class="ok"></i>
					<h1>支付成功</h1>
				</div>
			</div>
			
			<div class="row cue">
				<h1 class="col-xs-12">提示</h1>
				<p class="col-xs-12">有任何疑问请拨打：400-6898-909</p>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row pay-btn">
				<div class="col-xs-6">
					<a href="">查看体检码</a>
				</div>
				<div class="col-xs-6">
					<a href="./">返回首页</a>
				</div>
			</div>
		</div>
		
		
		
		
		
		
		<?php echo '<script'; ?>
 src="public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
