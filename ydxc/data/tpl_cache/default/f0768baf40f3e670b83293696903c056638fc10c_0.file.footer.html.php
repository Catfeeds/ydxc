<?php
/* Smarty version 3.1.30, created on 2017-08-18 01:28:42
  from "/data/www/ydxc/ydxc/template/default/footer.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995d24ac7eaa9_96039736',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f0768baf40f3e670b83293696903c056638fc10c' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/footer.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5995d24ac7eaa9_96039736 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="footer">
    <!--分割线-->
    <div class="bg3"></div>
    <div class="footer_body">
        <div class="footer_left">
            <div class="footer_img">
                <!--<img src="images/icon6.png" width="365" height="125">-->
                <img src="images/logo_03.png" width="332" height="103">
            </div>
            <div class="footer_msg">
                <div style="margin: 0px 0px 5px 20px">更多咨询服务请致电</div>
                <div class="footer_phone"><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitetel'];?>
</div>
            </div>
        </div>
        <div class="footer_right">
            <!--<ul>
                <span>关于我们</span>
                <li>公司简介</li>
                <li>教练风采</li>
                <li>代理中心</li>
                <li>新闻中心</li>
            </ul>
            <ul>
                <span>场地实景</span>
                <li>车辆图片</li>
                <li>场地图片</li>
                <li>场地位置</li>
            </ul>
            <ul>
                <span>接送班车</span>
                <li>班车接送安排</li>
            </ul>
            <ul>
                <span>班级价格</span>
                <li>品质班</li>
                <li>快速版</li>
                <li>实惠班</li>
                <li>分期班</li>
            </ul>
            <ul>
                <span>模拟题库</span>
                <li>科目一</li>
                <li>科目二</li>
                <li>科目三</li>
                <li>科目四</li>
            </ul>
			-->
			
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['tree_news_class'], 'item', false, 'key', 'class', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
		
			<?php if ($_smarty_tpl->tpl_vars['item']->value['pid'] == 0 && $_smarty_tpl->tpl_vars['key']->value < 16) {?>
				<ul>
					<span><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</span>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['tree_news_class'], 'vv');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->value) {
?>
						<?php if ($_smarty_tpl->tpl_vars['vv']->value['pid'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>
							<li><a href="<?php if ($_smarty_tpl->tpl_vars['vv']->value['jumpto']) {
echo $_smarty_tpl->tpl_vars['vv']->value['jumpto'];?>
#miaodian<?php } else { ?>index.php?do=intro&class_id=<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];?>
#miaodian<?php }?>"<?php if ($_smarty_tpl->tpl_vars['vv']->value['isnew']) {?>target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</a></li>
						<?php }?>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 
				</ul>	
			<?php }?>
		
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

			
        </div>
    </div>
    <div class="footer_fg"></div>
    <div class="footer_address">
		公司地址：<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['siteaddress'];?>
  <?php if ($_smarty_tpl->tpl_vars['_TCONFIG']->value['sitefax']) {?>传真：<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitefax'];
}?>  <br/>
		<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['siteicpno'];?>
 <?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['statcode'];?>

    </div>
</div><?php }
}
