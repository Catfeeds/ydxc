<?php
/* Smarty version 3.1.30, created on 2018-08-24 06:55:15
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/xlc_map_ajax.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7fabd3d17426_26518645',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '452f6f1302ca517a30c51edcce254ba5939cb1c1' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/xlc_map_ajax.html',
      1 => 1535079284,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b7fabd3d17426_26518645 (Smarty_Internal_Template $_smarty_tpl) {
?>
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<a class="map-dh" <?php if (!empty($_smarty_tpl->tpl_vars['cd_info']->value['id'])) {?> href="/index.php?do=go&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
"<?php }?>>
							<i class="iconfont icon-quzheli"></i>
							<p>到这里</p>
					</a>
				</div>
			</div>
			<div class="row location">
				<div class="col-xs-12">
					<h2><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
</h2>
					<p><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['cd_address'];?>
</p>
				</div>
			</div>
			
			<div class="row trainer">
					<div class="col-xs-12 trainer-name" style="height: 200px; overflow: scroll;">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['coach']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
						<a href="/index.php?do=coach_details&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="col-xs-12">
							<div class="trainer-summary">
								<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"/>
								<div>
									<h3 style="width: 64px;"><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</h3><span><?php echo $_smarty_tpl->tpl_vars['item']->value['drive_type'];
if (empty($_smarty_tpl->tpl_vars['item']->value['kemu'])) {
} else { ?>/科<?php echo $_smarty_tpl->tpl_vars['item']->value['kemu'];
}?></span>
									<p><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
</p>
								</div>
							</div>
							
							<?php if ($_smarty_tpl->tpl_vars['item']->value['avg'] == 0) {?>
							<h2 style="float: right;">暂无评分</h2>
							<?php } else { ?>
							<div class="coach-star coach-star-<?php echo $_smarty_tpl->tpl_vars['item']->value['avg'];?>
 right">
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
							</div>
							<?php }?>
						</a>	
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</div>
				</div>	
			
			<?php if (count($_smarty_tpl->tpl_vars['coach']->value) > 10) {?>
				<div class="row see">
					<a href="/index.php?do=xlc_map_ajax&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&p=2">查看更多</a>
				</div>
			<?php }?>
		</div>
<?php }
}
