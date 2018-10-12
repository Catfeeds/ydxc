<?php
/* Smarty version 3.1.30, created on 2018-09-07 07:29:05
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/enlist_pay_success.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b9228c1cadeb0_59691532',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '93ea86502f19111c1bd8db7d513f8e3671715a71' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/enlist_pay_success.html',
      1 => 1536303258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b9228c1cadeb0_59691532 (Smarty_Internal_Template $_smarty_tpl) {
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
				<p class="col-xs-12">亲爱的学员您好！您已经成功报名，您的下一步操作是在首页“报名体检”页面内申请一个体检码，申请成功之后请根据提示进行下一步操作。学员QQ群：<u style="color: red;">681469774</u>，加入群内可咨询疑问以及交流，也可以拨打服务热线:400-689-8909，祝您学车愉快！</p>
				<div style="text-align: center;"><img width="110" height="150" src="/template/wap/img/WechatIMG3274.jpeg"></div>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row pay-btn">
				<div class="col-xs-6">
					<a href="/index.php?do=my_order">查看订单</a>
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
