<?php
/* Smarty version 3.1.30, created on 2018-03-05 18:51:50
  from "/data/www/ydxc/ydxc/template/wap/enlist_pay_success.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a9d2146c4dfc2_52644346',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8a356ca82952a0e2c6afe5f8f1fc8623f835d3ba' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/enlist_pay_success.html',
      1 => 1520238932,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5a9d2146c4dfc2_52644346 (Smarty_Internal_Template $_smarty_tpl) {
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
				<p class="col-xs-12">亲爱的学员您好！您已经成功报名，您的下一步操作是在首页“报名体检”页面内申请一个体检码，申请成功之后请根据提示进行下一步操作。学员QQ群：<u style="color: red;">681469774</u>，加入群内可咨询疑问以及交流，也可以拨打服务热线:4006898909，祝您学车愉快！</p>
				<div style="text-align: center;"><img width="110" height="150" src="/ydxc/template/wap/img/WechatIMG3274.jpeg"></div>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row pay-btn">
				<div class="col-xs-6">
					<a href="/ydxc/index.php?do=my_order">查看订单</a>
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
