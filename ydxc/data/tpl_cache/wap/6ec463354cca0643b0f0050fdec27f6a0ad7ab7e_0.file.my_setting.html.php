<?php
/* Smarty version 3.1.30, created on 2017-10-18 17:37:23
  from "/data/www/ydxc/ydxc/template/wap/my_setting.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59e720d3623975_12497142',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ec463354cca0643b0f0050fdec27f6a0ad7ab7e' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/my_setting.html',
      1 => 1508319432,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59e720d3623975_12497142 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
				<div class="row data">
					<div class="col-xs-12">
						<div>
							<label for="">
								<input type="text" name="data[uname]" id="uname"  value="<?php echo $_smarty_tpl->tpl_vars['name']->value;?>
" placeholder="请输入姓名" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[phone]" id="phone"  value="<?php echo $_smarty_tpl->tpl_vars['phone']->value;?>
" placeholder="请输入手机号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[card_id]" id="card_id"  value="<?php echo $_smarty_tpl->tpl_vars['card_id']->value;?>
" placeholder="请输入身份证号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[shcool]" id="shcool"  value="<?php echo $_smarty_tpl->tpl_vars['shcool']->value;?>
" placeholder="请输入详细地址（学校）" />
							</label>
						</div>
					</div>
				</div>
				
				<div class="row application-btn">
					<a class="col-xs-12" id="form_submit" onclick="dr_submit()">提交</a>
				</div>
		</div>
		
	</body>
    <?php echo '<script'; ?>
 src="/client/public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
		
		function dr_submit() {
			var name = $('#uname').val().trim();
			var phone =  $('#phone').val().trim();
			var card_id = $('#card_id').val().trim();
			var shcool = $('#shcool').val().trim();
			
			if(name==null||name==''||phone==null||phone==''||card_id==null||card_id==''){
				alert("请填写完整");
			} else {
				$.ajax({
					type:"post",
					url:"/ydxc/index.php?do=setting_submit&action=update",
					async:true,
					data:{name:name,phone:phone,card_id:card_id,shcool:shcool},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							alert("操作成功");
							window.location.href = "/ydxc/index.php?do=center";
						} else if(data.status==2) {
							alert(data.code);
						} else {
							alert("操作失败");
						}
					}
				});
			}
		}
	<?php echo '</script'; ?>
>
</html>
<?php }
}
