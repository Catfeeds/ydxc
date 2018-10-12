<?php
/* Smarty version 3.1.30, created on 2018-08-23 08:05:49
  from "/usr/share/nginx/html/ydxc/ydxc/template/default/index_news.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7e6add9ef0f8_23555690',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3b924b970375105a5daf5e8dbc42cbde01b3fc8' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/template/default/index_news.html',
      1 => 1534741554,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:ditu2.html' => 1,
  ),
),false)) {
function content_5b7e6add9ef0f8_23555690 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_block_get')) require_once '/usr/share/nginx/html/ydxc/ydxc/lib/smarty/plugins/block.get.php';
if (!is_callable('smarty_modifier_truncate')) require_once '/usr/share/nginx/html/ydxc/ydxc/lib/smarty/plugins/modifier.truncate.php';
?>
    <div class="bottom">
        <div class="bottom_left">
            <div class="bottom_jj">
                <!--<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"select * from ctb_news where class_id=2",'row'=>1,'return'=>"jianjie"));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"select * from ctb_news where class_id=2",'row'=>1,'return'=>"jianjie"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>

					<?php $_smarty_tpl->_assignInScope('get_all_pic', preg_match_all('/(<img[^>]+alt\s*=\s*"?([^>"\s]+)"?[^>]*[^>]+src\s*=\s*"?([^>"\s]+)"?[^>]*>)/im','',$_smarty_tpl->tpl_vars['jianjie']->value['content']));
?>
					<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['get_all_pic']->value,780);?>

					<a href="index.php?do=intro&class_id=2">查看详情》</a>
				<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"select * from ctb_news where class_id=2",'row'=>1,'return'=>"jianjie"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>
-->
				<?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['content']->value,780);?>
<a href="index.php?do=intro&class_id=2">查看详情》</a>
            </div>
            <div>
                <img src="images/jxdz.png" width="397" height="89">
            </div>
            <div width="754" height="746">
                <!--<img src="images/dizhi.png" width="754" height="746">-->
				<?php $_smarty_tpl->_subTemplateRender("file:ditu2.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            </div>
            <div style="height:20px;"></div>
        </div>
        <div class="bottom_right">
            <div>
                <h3>行业资讯 <span>news</span></h3><span><a href="index.php?do=intro&class_id=20">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
                <div>
					<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>

						<a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['new1']->value['id'];?>
"><img src="<?php echo getthumbimg($_smarty_tpl->tpl_vars['new1']->value['img']);?>
" width="374" height="123"></a>
					<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                </div>
                <div class="list">
                    <ul>
                        <!--<li>长城汽车不走高端很快会死</li>
                        <li>抢先买拍猎豹CS10 霸气时尚2.0T涡轮增压</li>
                        <li>买房还是炒股，2015买房无法拒绝的五大理由</li>
                        <li>长城汽车不走高端很快会死</li>
                        <li>抢先买拍猎豹CS10 霸气时尚2.0T涡轮增压</li>-->
						<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>5));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>5), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],40);?>
</a>
							</li>
						<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows'=>5), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                    </ul>
                </div>
            </div>
            <div>
                <h3>最新公告 <span>news</span></h3><span><a href="index.php?do=intro&class_id=21">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
					<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>

						<a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['new1']->value['id'];?>
"><img src="<?php echo getthumbimg($_smarty_tpl->tpl_vars['new1']->value['img']);?>
" width="374" height="123"></a>
					<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                <div class="list">
                    <ul>
						<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>5));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>5), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],40);?>
</a>
							</li>
						<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows'=>5), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                    </ul>
                </div>
            </div>
            <div>
                <h3>媒体报道 <span>news</span></h3><span><a href="index.php?do=intro&class_id=23">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
                <div>
					<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>

						<a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['new1']->value['id'];?>
"><img src="<?php echo getthumbimg($_smarty_tpl->tpl_vars['new1']->value['img']);?>
" width="374" height="123"></a>
					<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, img FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>1,'return'=>"new1"), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                </div>
                <div class="list">
                    <ul>
						<?php $_smarty_tpl->smarty->_cache['_tag_stack'][] = array('get', array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>5));
$_block_repeat1=true;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>5), null, $_smarty_tpl, $_block_repeat1);
while ($_block_repeat1) {
ob_start();
?>
			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['r']->value['id'];?>
"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['r']->value['title'],40);?>
</a>
							</li>
						<?php $_block_repeat1=false;
echo smarty_block_get(array('sql'=>"SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows'=>5), ob_get_clean(), $_smarty_tpl, $_block_repeat1);
}
array_pop($_smarty_tpl->smarty->_cache['_tag_stack']);?>

                    </ul>
                </div>
            </div>

        </div>
    </div><?php }
}
