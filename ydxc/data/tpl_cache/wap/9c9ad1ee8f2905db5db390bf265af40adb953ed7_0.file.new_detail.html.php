<?php
/* Smarty version 3.1.30, created on 2018-08-27 05:36:56
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/new_detail.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b838df8736419_02625903',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9c9ad1ee8f2905db5db390bf265af40adb953ed7' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/new_detail.html',
      1 => 1534741554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b838df8736419_02625903 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
	<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->	
	<div class="container">
		<?php ob_start();
echo $_smarty_tpl->tpl_vars['value']->value['img1'];
$_prefixVariable1=ob_get_clean();
if (!empty($_prefixVariable1)) {?>
		<div class="row banner">
			<img src="<?php echo $_smarty_tpl->tpl_vars['value']->value['img1'];?>
"/>
		</div>
		<?php }?>
		
		<div  class="row new-text">
			<div class="col-xs-12">
					<?php echo $_smarty_tpl->tpl_vars['value']->value['content'];?>
	
			</div>

		</div>
		
	</div>	
		
	</body>
</html>
<?php }
}
