<?php
/* Smarty version 3.1.30, created on 2017-09-11 17:25:17
  from "/data/www/ydxc/ydxc/template/default/news.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b6567d82a924_07156487',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4abb31dbd0f79c57dc35f90312c2c3c81168e438' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/news.html',
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
function content_59b6567d82a924_07156487 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.nl2br.php';
if (!is_callable('smarty_block_get')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/block.get.php';
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
                > 重庆鼎吉驾校 ><?php echo $_smarty_tpl->tpl_vars['curr_class']->value;?>

            </div>
        </div>
        <div class="content">
            <?php $_smarty_tpl->_subTemplateRender("file:left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
            <div class="right">
                <div class="title_right">
                    新闻中心
                </div>
                <div class="content_right">
                    <div>
                        <h3>行业动态</h3>
                        <div>
                            <ul>
								<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>6));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>6), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
#miaodian"><div><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],48);?>
 <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['date'],"%Y-%m-%d");?>
</span></div></a>
									</li>
								<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>6), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                            </ul>
                        </div>
                    </div>
                    <div>
                        <h3>最近公告</h3>
                        <div>
                            <ul>
								<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>6));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>6), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
#miaodian"><div><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],48);?>
 <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['date'],"%Y-%m-%d");?>
</span></div></a>
									</li>
								<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>6), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                            </ul>
                        </div>
                    </div>
                    <div>
                        <h3>媒体报道</h3>
                        <div>
                            <ul>
								<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>6));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>6), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
#miaodian"><div><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],48);?>
 <span><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['r']->value['date'],"%Y-%m-%d");?>
</span></div></a>
									</li>
								<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>6), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                            </ul>
                        </div>
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
