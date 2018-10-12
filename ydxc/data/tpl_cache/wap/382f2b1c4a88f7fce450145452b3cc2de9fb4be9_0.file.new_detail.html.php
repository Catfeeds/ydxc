<?php
/* Smarty version 3.1.30, created on 2018-10-10 09:11:56
  from "E:\hua\phpStudy\WWW\ydxctrue\ydxc\template\wap\new_detail.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5bbdc25cec9812_32913981',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '382f2b1c4a88f7fce450145452b3cc2de9fb4be9' => 
    array (
      0 => 'E:\\hua\\phpStudy\\WWW\\ydxctrue\\ydxc\\template\\wap\\new_detail.html',
      1 => 1539140310,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5bbdc25cec9812_32913981 (Smarty_Internal_Template $_smarty_tpl) {
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
