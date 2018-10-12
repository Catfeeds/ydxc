<?php
/* Smarty version 3.1.30, created on 2017-09-08 18:54:57
  from "/data/www/ydxc/ydxc/template/default/show.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b27701524820_28165547',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f24c7c9831fd8839ad7bdd06e8dcf5e9c9a3da21' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/show.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:left.html' => 1,
    'file:ditu.html' => 1,
    'file:ditu2.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_59b27701524820_28165547 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/lib/smarty/plugins/modifier.nl2br.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitename'];?>
</title>
    <link href="css/zt.css" rel="stylesheet" type="text/css">
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.9.1.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/zt.js"><?php echo '</script'; ?>
>
	
	<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['keywords'];?>
"/>
	<meta name="description" content="<?php echo smarty_modifier_nl2br($_smarty_tpl->tpl_vars['_TCONFIG']->value['description']);?>
"/>
</head>
<body>
    <?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
    <div class="body">
        <div class="position">
            <div class="icon_postion">
                <a href="./"><img src="images/icon1.png" width="40" height="32"></a>
            </div>
            <div class="msg_position">
                > 重庆鼎吉驾校 > <?php echo $_smarty_tpl->tpl_vars['curr_class']->value;?>

            </div>
        </div>
        <div class="content">
			<?php $_smarty_tpl->_subTemplateRender("file:left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
            <div class="right">
                <div class="title_right">
                    <?php if ($_smarty_tpl->tpl_vars['newsshow']->value['name']) {
echo $_smarty_tpl->tpl_vars['newsshow']->value['name'];
} else {
echo $_smarty_tpl->tpl_vars['class_name']->value['name'];
}?>
                </div>
                <div class="content_right">
					<?php if ($_smarty_tpl->tpl_vars['class_id']->value == 15) {
$_smarty_tpl->_subTemplateRender("file:ditu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}?>
                   <p style="line-height: 30px;">
                       <?php echo smarty_modifier_nl2br($_smarty_tpl->tpl_vars['newsshow']->value['intro']);?>

                       <?php echo smarty_modifier_nl2br($_smarty_tpl->tpl_vars['newsshow']->value['content']);?>

                   </p>
				   <?php if ($_smarty_tpl->tpl_vars['class_id']->value == 15) {?>
						<?php $_smarty_tpl->_subTemplateRender("file:ditu2.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

						<br/>
						<p style="line-height: 30px;">陈家桥轻轨站报名点	大学城东路陈家桥轻轨站旁	023-67303999</p>
						<p style="line-height: 30px;">西永老街店	沙坪坝西永老街西永路252好	023-65612118</p>
						<p style="line-height: 30px;">医专院门店	沙坪坝区医药高等专科学校东门旁	</p>
						<p style="line-height: 30px;">城管校门店	沙坪坝区大学城城市管理学院内商业街	</p>
						<p style="line-height: 30px;">新桥报名店	重庆沙坪坝区新桥医院旁500米	</p>

				   
				   
				   <?php }?>
                </div>
				<!--教练风采加一个返回按钮-->
				<?php if ($_smarty_tpl->tpl_vars['class_id']->value == 3) {?>
					<div>
						<a href="index.php?do=intro&class_id=<?php echo $_smarty_tpl->tpl_vars['class_id']->value;?>
#miaodian"><input type="button" class="sub" value="返回"></a>
					</div>
				<?php }?>	
            </div>
        </div>
    </div>
	
    <?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</body>
</html><?php }
}
