<?php
/* Smarty version 3.1.30, created on 2017-08-18 00:47:05
  from "/data/www/ydxcnew/ydxc/template/wap/my.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995c889b91bc9_79149624',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3d48272000bf3ace8aed5ee06dbb0877d391092' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/my.html',
      1 => 1502988420,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5995c889b91bc9_79149624 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mine">
				<img src="/ydxc/template/wap/public/css/self/image/demo_2.jpg" id="my_model"/>
				<h1>123木头人</h1>
			</div>
			
			<div class="row manage">
				<a class="col-xs-12" href="my_order.html">
					<i class="iconfont icon-iconfontwodedingdan"></i>
					<p>我的订单</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/ydxc/template/wap/my_news.html">
					<i class="iconfont icon-tubiaozhizuomoban"></i>
					<p>我的消息</p>
					<span></span>
				</a>
				<a class="col-xs-12">
					<i class="iconfont icon-xinfeng"></i>
					<p>我的建议</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/ydxc/index.php?do=comment">
					<i class="iconfont icon-xiaoxi"></i>
					<p>教练评价</p>
					<span></span>
				</a>
			</div>
			
			<div class="row kong"></div>
			
			<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

		</div>
		
		<div class="container" id="model">
			<div class="row">
				<div class="modal-body">
					<div>
						<h1>请输入你的手机号</h1>
						<input type="text" name="phone" />
						<input id="btnSendCode" type="button" value="发送验证码" onclick="sendMessage()" />
					</div>
					<div>
						<h1>请输入你的验证码</h1>
						<input type="text" name="phone" />
					</div>
				</div>
				<div class="modal-btn">
					<a id="banck">返回</a>
					<a>确定</a>
				</div>
			</div>
		</div>
	</body>
</html>
<?php }
}
