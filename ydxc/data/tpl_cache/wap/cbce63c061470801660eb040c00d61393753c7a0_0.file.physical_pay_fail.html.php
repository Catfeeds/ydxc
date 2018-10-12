<?php
/* Smarty version 3.1.30, created on 2018-08-24 03:22:29
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/physical_pay_fail.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7f79f590b247_32861120',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbce63c061470801660eb040c00d61393753c7a0' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/physical_pay_fail.html',
      1 => 1535079117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b7f79f590b247_32861120 (Smarty_Internal_Template $_smarty_tpl) {
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
					<a href="/index.php?do=xlc_map">重新支付</a>
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
