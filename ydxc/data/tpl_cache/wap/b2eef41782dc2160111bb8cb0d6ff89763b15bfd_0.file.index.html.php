<?php
/* Smarty version 3.1.30, created on 2017-08-18 01:07:51
  from "/data/www/ydxcnew/ydxc/template/wap/index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995cd670f11e9_81717069',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b2eef41782dc2160111bb8cb0d6ff89763b15bfd' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/index.html',
      1 => 1502989663,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5995cd670f11e9_81717069 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


    <body>
        <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->

        <div class="container">

            <div class="row banner">
                <img src="/ydxc/template/wap/public/css/self/image/banner_1.jpg" />
            </div>

            <div class="row nav-bar">
                <div class="col-xs-3 nav-bar-item">
                    <a href="/ydxc/index.php?do=coach_list"><img src="/ydxc/template/wap/public/css/self/icon/icon_1.png" /><i>全部教练</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/ydxc/index.php?do=xlc_map"><img src="/ydxc/template/wap/public/css/self/icon/icon_2.png" /><i>全部场地</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/ydxc/template/wap/new_detail.html"><img src="/ydxc/template/wap/public/css/self/icon/icon_3.png" /><i>优势服务</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/ydxc/index.php?do=partner"><img src="/ydxc/template/wap/public/css/self/icon/icon_4.png" /><i>合伙人申请</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="###"><img src="/ydxc/template/wap/public/css/self/icon/icon_5.png" /><i>VR学车</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="###"><img src="/ydxc/template/wap/public/css/self/icon/icon_6.png" /><i>学车流程</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="###"><img src="/ydxc/template/wap/public/css/self/icon/icon_7.png" /><i>学车保障</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/ydxc/index.php?do=xlc_map&tj=1"><img src="/ydxc/template/wap/public/css/self/icon/icon_8.png" /><i>报名体检</i></a>
                </div>
            </div>

            <div class="row news">
                <div class="col-xs-12 news-item">
                    <a href="/ydxc/template/wap/new_detail.html">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题</h2>
                        <p>描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述</p>
                    </a>
                </div>
                <div class="col-xs-12 news-item">
                    <a href="/ydxc/template/wap/new_detail.html">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题标题标题标题标题标题标题标题标题标题标题标题标题标题标题标题标题</h2>
                        <p>描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述</p>
                    </a>
                </div>
                <div class="col-xs-12 news-item">
                    <a href="/ydxc/template/wap/new_detail.html">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题</h2>
                        <p>描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述描述</p>
                    </a>
                </div>
            </div>

            <div class="row coach">
                <div class="p-hd">
                    <h2>优质教练</h2>
                    <p>我们有全城最优质的教练为你悉心教学</p>
                </div>
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                    		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teachers']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                        <div class="swiper-slide coach-item">
                        		<a href="/ydxc/index.php?do=coach_details&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
	                            <div class="coach-avatar">
	                                <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="130" height="130" />
	                            </div>
	                            <div class="coach-name"><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</div>
	                            <div class="coach-place"><?php echo $_smarty_tpl->tpl_vars['item']->value['sscd'];?>
</div>
	                            <div class="coach-star coach-star-1"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>
	                            <div class="coach-course"><?php echo $_smarty_tpl->tpl_vars['item']->value['drive_type'];?>

	                            <?php if ($_smarty_tpl->tpl_vars['item']->value['kemu'] == 0) {?> 科目未知<?php } else { ?> 科目<?php echo $_smarty_tpl->tpl_vars['item']->value['kemu'];
}?>
	                            </div>
                            </a>
                        </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </div>
            </div>

            <div class="row activity">
                <div class="p-hd">
                    <h2>最新活动</h2>
                    <p>易点学车是一家高度融合互联网+实体驾校的创新型互联网品牌</p>
                </div>
                <div class="col-xs-12 activity-item">
                    <a href="###">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题标题标题标题标题标题标题标题标题标题标题标题标题</h2>
                    </a>
                </div>
                <div class="col-xs-12 activity-item">
                    <a href="###">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题</h2>
                    </a>
                </div>
                <div class="col-xs-12 activity-item">
                    <a href="###">
                        <img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg" />
                        <h2>标题标题</h2>
                    </a>
                </div>
            </div>
            
            <div class="row kong"></div>
			
			<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


        </div>

        <?php echo '<script'; ?>
 src="/ydxc/template/wap/public/js/libs/swiper-3.4.1.jquery.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
            var swiper = new Swiper('.swiper-container', {
                spaceBetween: 10,
                slidesPerView: 2.4,
                slidesOffsetBefore: 15,
                slidesOffsetAfter: 15,
            });
        <?php echo '</script'; ?>
>
    </body>

</html><?php }
}
