<?php
/* Smarty version 3.1.30, created on 2017-08-29 14:15:58
  from "/data/www/ydxc/ydxc/template/wap/my.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a5069e2300b1_18727083',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a7f2595c9c84ca7c251a5993bcf25a371ac27bce' => 
    array (
      0 => '/data/www/ydxc/template/wap/my.html',
      1 => 1503987345,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_59a5069e2300b1_18727083 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mine">
				<img src="<?php echo $_smarty_tpl->tpl_vars['userwxinfo']->value['headimgurl'];?>
" id="my_model"/>
				<h1><?php echo $_smarty_tpl->tpl_vars['userwxinfo']->value['nickname'];?>
</h1>
			</div>
			
			<div class="row manage">
				<a class="col-xs-12" href="/index.php?do=my_order">
					<i class="iconfont icon-iconfontwodedingdan"></i>
					<p>我的订单</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=my_news">
					<i class="iconfont icon-tubiaozhizuomoban"></i>
					<p>我的消息</p>
					<span></span>
				</a>
				<a class="col-xs-12"href="/index.php?do=advise">
					<i class="iconfont icon-xinfeng"></i>
					<p>我的建议</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=my_setting">
					<i class="iconfont icon-tubiaozhizuomoban"></i>
					<p>个人设置</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=comment">
					<i class="iconfont icon-xiaoxi"></i>
					<p>学习中心</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=myewm">
					<img src="/template/wap/img/qrcode1.png" width="20" height="20" />
					<p>我的二维码</p>
					<span></span>
				</a>
				<a class="col-xs-12"href="/index.php?do=coach_change">
					<i class="iconfont icon-xinfeng"></i>
					<p>教练更换申请</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=new_detail&id=10">
					<img src="/template/wap/img/czzn_icon.png" width="20" height="20" />
					<p>平台操作指南</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=new_detail&id=11">
					<img src="/template/wap/img/lilun_icon.png" width="20" height="20" />
					<p>理论预约流程</p>
					<span></span>
				</a>
				<a class="col-xs-12" href="/index.php?do=new_detail&id=12">
					<img src="/template/wap/img/ks_icon.png" width="20" height="20" />
					<p>约考缴费流程</p>
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
