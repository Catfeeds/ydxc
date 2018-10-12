<?php
/* Smarty version 3.1.30, created on 2017-08-17 23:14:26
  from "/data/www/ydxcnew/ydxc/template/wap/physical.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995b2d23e2e64_67190242',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '20f11ba17efb31ffd681ab3f95756d339c9a187d' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/physical.html',
      1 => 1502982861,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995b2d23e2e64_67190242 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<form action="/ydxc/index.php?do=tj_code_apply" method="post" name="tj_code_form" onsubmit="return check();">
		<div class="container   ">
				<div class="row data">
					<div class="col-xs-12">
						<div>
							<label for="">
								<input type="text" name="data[uname]" id="uname"  value="" placeholder="请输入姓名" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[phone]" id="phone"  value="" placeholder="请输入手机号" />
							</label>
						</div>
						<div>
							<a>
								<p><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
 <?php echo $_smarty_tpl->tpl_vars['address_arr']->value['result']['formatted_address'];?>
</p>
								<input type="hidden" name="data[tjz_id]" id="tjz_id" value="<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
" />
								<!--<i></i>-->
							</a>
						</div>
					</div>
				</div>

			
			<div class="row explain">
				<p class="col-xs-12">*说明：申请后您会收到体检码，请携带体检码和身份证到所选择的体检站进行体检</p>
			</div>
			
			<div class="kong row"></div>
			
				<!--<a href="physical_pay_success.html" class="col-xs-12">申请体检</a>-->
				<input type="submit" class="row application-btn" value="申请体检" style="border: 0;background-color: #22A7F0;color: #ffffff;" />
			
		</div>                      
		</form>
		
	</body>
	<?php echo '<script'; ?>
 type="text/javascript">
		function check(){
			var uname = $("#uname").val().trim();
			var phone = $("#phone").val().trim();
			var tjz_id = $("#tjz_id").val();
			if((null==uname||undefined==uname||''==uname
			||null==phone||undefined==phone||''==phone
			||null==tjz_id||undefined==tjz_id||''==tjz_id)){
				alert("请填写完整");
				return false;
			}
		}
	<?php echo '</script'; ?>
>
</html>
<?php }
}
