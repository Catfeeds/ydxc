<?php
/* Smarty version 3.1.30, created on 2018-01-09 18:07:34
  from "/data/www/ydxc/ydxc/template/default/list_news.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5a5494667618c2_74497982',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a8eb9faca5a35d9aed4932b0967d12c74ae75ac' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/list_news.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:left.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5a5494667618c2_74497982 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.nl2br.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_date_format')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.date_format.php';
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
                <img src="images/icon1.png" width="40" height="32">
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
                    <?php echo $_smarty_tpl->tpl_vars['class_name']->value['name'];?>

                </div>
                <div class="content_right">
					<div>
						<ul>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>			 	
								<li>
									 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
#miaodian"><div><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['item']->value['title'],48);?>
 <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['item']->value['date'],"%Y-%m-%d");?>
</span></div>
								</li>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						</ul>
					</div>
					<div class="page"><?php echo $_smarty_tpl->tpl_vars['multi']->value;?>
</div>
                </div>
            </div>
        </div>
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</body>
</html><?php }
}
