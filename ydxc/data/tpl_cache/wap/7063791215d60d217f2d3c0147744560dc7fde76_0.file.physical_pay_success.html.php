<?php
/* Smarty version 3.1.30, created on 2018-09-07 07:39:02
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/physical_pay_success.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b922b16c13e73_50624608',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7063791215d60d217f2d3c0147744560dc7fde76' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/physical_pay_success.html',
      1 => 1536233056,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b922b16c13e73_50624608 (Smarty_Internal_Template $_smarty_tpl) {
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
				<p class="col-xs-12">您已经成功申请体检码，请带上手机、身份证原件到所选择体检站进行体检。</p>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row pay-btn">
				<div class="col-xs-6">
					<a href="/index.php?do=my_tj_code">查看体检码</a>
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
