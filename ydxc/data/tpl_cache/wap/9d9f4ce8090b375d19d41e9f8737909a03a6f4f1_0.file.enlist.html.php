<?php
/* Smarty version 3.1.30, created on 2018-08-26 07:27:30
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b8256627deb36_61404179',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d9f4ce8090b375d19d41e9f8737909a03a6f4f1' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist.html',
      1 => 1535267968,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b8256627deb36_61404179 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mold">
				<h1 class="col-xs-12">班别选择</h1>
				<div class="col-xs-12">
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['course']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
					<div class="col-xs-12">
						<label for="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
							<div>
							<input type="radio" name="class" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" /><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>


						<span class="right">
							<?php echo $_smarty_tpl->tpl_vars['item']->value['zd_price'];?>

						</span>
						</div>
						</label>
						
					</div>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

				</div>				
			</div>
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<a href="tel:400-689-8909">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线<?php echo $_smarty_tpl->tpl_vars['course']->value['coach'];?>
</p>	             
					<p>400-689-8909</p>
				</div>
				</a>
				<a class="col-xs-8 enroll-btn" href="javascript:void(0);" id="next">下一步</a>
			</div>
			
		</div>
		
	</body>
	<?php echo '<script'; ?>
>
			 $(function(){
				  $(":radio").click(function(){
				   		var id = $(this).val();
				   		var href = "/index.php?do=enlist_details&coach=<?php echo $_smarty_tpl->tpl_vars['coach']->value;?>
&id="+id;
				   		$("#next").attr("href",href);
				  });
				  
				  $("#next").click(function(){
				  		if($('input:radio[name="class"]:checked').val()==null){
				  			alert("请选择一个班级");
				  		}
				  });
				  
			 });
	<?php echo '</script'; ?>
>
</html>
<?php }
}
