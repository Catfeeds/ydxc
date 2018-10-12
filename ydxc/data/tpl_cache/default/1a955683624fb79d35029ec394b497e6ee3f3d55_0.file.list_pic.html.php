<?php
/* Smarty version 3.1.30, created on 2017-09-01 17:06:21
  from "/data/www/ydxc/ydxc/template/default/list_pic.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a9230d887538_05483683',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a955683624fb79d35029ec394b497e6ee3f3d55' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/list_pic.html',
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
function content_59a9230d887538_05483683 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.nl2br.php';
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
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['list']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
					<div class="jlfc">
						<p><a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
#miaodian"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"></a></p>
						<?php if ($_smarty_tpl->tpl_vars['class_id']->value == 3) {?><p align="center"><?php echo $_smarty_tpl->tpl_vars['_TGLOBAL']->value['setting']['kemu'][$_smarty_tpl->tpl_vars['item']->value['kemu']];?>
:<?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</p><?php }?>
					</div>
				<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                <!--<div class="jlfc">
                    <img src="images/5.png">
                </div>
                <div class="jlfc">
                    <img src="images/008.png">
                </div>
                <div class="jlfc">
                    <img src="images/7dd98d1001e93901df56c40079ec54e736d196bc.jpg">
                </div>
                <div class="jlfc">
                    <img src="images/006.png">
                </div>
                <div class="jlfc">
                    <img src="images/5.png">
                </div>
                <div class="jlfc">
                    <img src="images/008.png">
                </div>
                <div class="jlfc">
                    <img src="images/7dd98d1001e93901df56c40079ec54e736d196bc.jpg">
                </div>-->
            </div>
			<div class="page"><?php echo $_smarty_tpl->tpl_vars['multi']->value;?>
</div>
        </div>
    </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</body>
</html><?php }
}
