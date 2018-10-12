<?php
/* Smarty version 3.1.30, created on 2017-08-17 22:20:13
  from "/data/www/ydxcnew/ydxc/template/wap/enlist_details.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995a61de07510_12446551',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dc2b5bf96e80060927aeb7bdfb251c35f7ee148e' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/enlist_details.html',
      1 => 1502631801,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995a61de07510_12446551 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mold-on">
				<label for="">
					<input type="radio" name="class" value="1" checked="checked"/><?php echo $_smarty_tpl->tpl_vars['courseshow']->value['name'];?>

				</label>
				<span class="right">
					<?php if ($_smarty_tpl->tpl_vars['courseshow']->value['id'] == 4) {
echo $_smarty_tpl->tpl_vars['courseshow']->value['sd_price'];
} elseif ($_smarty_tpl->tpl_vars['courseshow']->value['id'] == 5) {
echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];
} elseif ($_smarty_tpl->tpl_vars['courseshow']->value['id'] == 6) {
echo $_smarty_tpl->tpl_vars['courseshow']->value['sd_price'];
} elseif ($_smarty_tpl->tpl_vars['courseshow']->value['id'] == 7) {
echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];
}?>
				</span>
			</div>
			
			<div class="row notice">
				<h1 class="col-xs-12">班级说明</h1>
				<div class="col-xs-12">
					<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['intro'];?>

				</div>
			</div>
			
			
			<div class="row notice">
				<h1 class="col-xs-12">学车须知</h1>
				<div class="col-xs-12">
					<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['liucheng'];?>

				</div>
			</div>
			
			<div class="row kong"></div>
			
			
			<div class="row enroll">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-6898-909</p>	
				</div>
				<a class="col-xs-8 enroll-btn" href="/ydxc/index.php?do=enlist_order&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&coach=<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['coach'];?>
">确认报名</a>
			</div>
			
		</div>
		
	</body>
</html>
<?php }
}
