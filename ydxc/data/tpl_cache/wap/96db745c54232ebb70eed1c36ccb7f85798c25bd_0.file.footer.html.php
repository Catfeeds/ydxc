<?php
/* Smarty version 3.1.30, created on 2017-08-25 11:23:23
  from "/data/www/ydxc/ydxc/template/wap/footer.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_599f982b3845f7_24590962',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '96db745c54232ebb70eed1c36ccb7f85798c25bd' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/footer.html',
      1 => 1503627938,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_599f982b3845f7_24590962 (Smarty_Internal_Template $_smarty_tpl) {
?>
			<div class="footer">
				<a <?php if (($_smarty_tpl->tpl_vars['_GET']->value['do'] == '')) {?>class="col-xs-4 active"<?php } else { ?>class="col-xs-4"<?php }?> href="/index.php">
					<i class="iconfont icon-fangxiangpan"></i>
					<p>首页</p>
				</a>
				<a <?php if (($_smarty_tpl->tpl_vars['_GET']->value['do'] == 'xlc_map')) {?>class="col-xs-4 active"<?php } else { ?>class="col-xs-4"<?php }?> <?php if ($_smarty_tpl->tpl_vars['user_info']->value['k2_status'] == 2 && $_smarty_tpl->tpl_vars['comment_num']->value == 0) {?>onclick="cancel_turn();return false"<?php }?> href="/index.php?do=xlc_map&k=2">
					<i class="iconfont icon-baoming"></i>
					<p>报名</p>
				</a>
				<a <?php if (($_smarty_tpl->tpl_vars['_GET']->value['do'] == 'center')) {?>class="col-xs-4 active"<?php } else { ?>class="col-xs-4"<?php }?> href="/index.php?do=center">
					<i class="iconfont icon-wode"></i>
					<p>我的</p>
				</a>
			</div><?php }
}
