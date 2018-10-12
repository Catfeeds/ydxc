<?php /* Smarty version 2.6.22, created on 2017-08-16 23:07:30
         compiled from my.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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
				<a class="col-xs-12">
					<i class="iconfont icon-xiaoxi"></i>
					<p>学习中心</p>
					<span></span>
				</a>
			</div>
			
			<div class="row kong"></div>
			
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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