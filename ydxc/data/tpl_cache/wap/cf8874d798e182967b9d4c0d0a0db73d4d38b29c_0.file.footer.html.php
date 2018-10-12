<?php
/* Smarty version 3.1.30, created on 2018-08-24 09:55:40
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/footer.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7fd61c8765a1_27660836',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cf8874d798e182967b9d4c0d0a0db73d4d38b29c' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/footer.html',
      1 => 1535104536,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b7fd61c8765a1_27660836 (Smarty_Internal_Template $_smarty_tpl) {
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
			</div>
<?php }
}
