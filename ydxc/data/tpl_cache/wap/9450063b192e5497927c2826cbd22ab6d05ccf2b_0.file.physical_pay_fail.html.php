<?php
/* Smarty version 3.1.30, created on 2017-09-05 10:21:28
  from "/data/www/ydxc/ydxc/template/wap/physical_pay_fail.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59ae0a28bd1d14_31316797',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9450063b192e5497927c2826cbd22ab6d05ccf2b' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/physical_pay_fail.html',
      1 => 1504177887,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59ae0a28bd1d14_31316797 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		
		<div class="container">
			<div class="row success">
				<div class="col-xs-12">
					<i class="no"></i>
					<h1>支付失败，请重新支付</h1>
				</div>
			</div>
			
			<div class="row cue">
				<h1 class="col-xs-12">提示</h1>
				<p class="col-xs-12">支付未完成，请重新填写信息支付。</p>
			</div>
			
			<div class="kong row"></div>
			
			<div class="row pay-btn">
				<div class="col-xs-6">
					<a href="/ydxc/index.php?do=xlc_map">重新支付</a>
				</div>
				<div class="col-xs-6">
					<a href="./">返回首页</a>
				</div>
			</div>
		</div>
		
	</body>
</html>

<?php }
}
