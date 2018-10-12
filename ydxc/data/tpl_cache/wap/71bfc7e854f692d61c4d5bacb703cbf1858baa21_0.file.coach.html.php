<?php
/* Smarty version 3.1.30, created on 2017-08-17 20:29:46
  from "/data/www/ydxcnew/ydxc/template/wap/coach.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59958c3ace05e4_37874838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '71bfc7e854f692d61c4d5bacb703cbf1858baa21' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/coach.html',
      1 => 1502893610,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59958c3ace05e4_37874838 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row item">
				<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['coaches']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
				<div class="col-xs-6">
					<a class="coach-item" href="/ydxc/index.php?do=coach_details&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
						<div class="coach-avatar">
	                          <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" style="width: 145px;height: 145px;"/>
	                     </div>
	                     <div class="coach-name"><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</div>
	                     <div class="coach-place"><?php echo $_smarty_tpl->tpl_vars['item']->value['sscd'];?>
</div>
	                     <div class="coach-star coach-star-1"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>
	                     <div class="coach-course"><?php if ($_smarty_tpl->tpl_vars['item']->value['kemu'] == 0) {?> 科目未知<?php } else { ?> 科目<?php echo $_smarty_tpl->tpl_vars['item']->value['kemu'];
}?></div>
					</a>
				</div>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			</div>
		</div>
		
		
	</body>
</html>
<?php }
}
