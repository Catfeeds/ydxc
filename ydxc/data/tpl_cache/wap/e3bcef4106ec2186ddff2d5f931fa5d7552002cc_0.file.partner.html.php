<?php
/* Smarty version 3.1.30, created on 2017-08-18 00:59:06
  from "/data/www/ydxcnew/ydxc/template/wap/partner.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995cb5ad8e107_86183923',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e3bcef4106ec2186ddff2d5f931fa5d7552002cc' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/partner.html',
      1 => 1502989117,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995cb5ad8e107_86183923 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
	<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->	
	<div class="container">
			
		<div class="row video">
			<img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['img'];?>
"/>
		</div>
		<!--<div class="row img">
			<img src="public/css/self/image/demo_1.jpg"/>
		</div>-->
		
		
		<div class="row partner-text">
			<div class="col-xs-12">
				<h1>活动规则</h1>
				<p class="danger">(请仔细阅读以下活动规则)</p>
			</div>
			<div class="col-xs-12">
				<h2>	一、活动主题</h2>
				<p><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
</p>
			</div>
			<div class="col-xs-12">
				<h2>二、报名时间</h2>
				<p>报名时间：<span><?php echo $_smarty_tpl->tpl_vars['value']->value['signup_time'];?>
起</span></p>
			</div>
			<div class="col-xs-12">
				<h2>	三、活动规则</h2>
				<?php echo $_smarty_tpl->tpl_vars['value']->value['rules'];?>

			</div>
		</div>
		
		<form action="/index.php?do=partner&action=post" method="post" id="myform">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" name="data[actid]" />
		<div class="row data">
				<div class="col-xs-12">
					<div>
						<label for="">
							<input type="text" name="data[username]"  value="" placeholder="请输入姓名" />
						</label>
					</div>
					<div>
						<label for="">
							<input type="text" name="data[phone]"  value="" placeholder="请输入手机号" />
						</label>
					</div>
					<div>
						<label for="">
							<input type="text" name="data[school]"  value="" placeholder="请输入所在学校（选填）" />
						</label>
					</div>
				</div>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-6898-909</p>	
				</div>
				<a class="col-xs-8 enroll-btn" href="javascript:dr_submit()">提交报名</a>
			</div>
			</form>
	</div>	
		
		
		
		
		
		
		
	<?php echo '<script'; ?>
 src="public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="public/js/libs/swiper-3.4.1.jquery.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
    		function dr_submit() {
    			$.ajax({
    				type:"post",
    				url:"/index.php?do=partner&action=post",
    				async:true,
    				data:$("#myform").serialize(),
    				dataType:"json",
    				success:function(data) {
    					alert(data.code);
    					if(data.status==1) {
    						window.location.href = "/index.php";
    					}
    				}
    			});
    		}
    <?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
