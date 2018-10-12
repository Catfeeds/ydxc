<?php
/* Smarty version 3.1.30, created on 2018-10-10 08:45:05
  from "E:\hua\phpStudy\WWW\ydxctrue\ydxc\template\wap\index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5bbdbc11629c95_80924020',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'db5c54f0897e020bd478e29cae6145416b3e6ecd' => 
    array (
      0 => 'E:\\hua\\phpStudy\\WWW\\ydxctrue\\ydxc\\template\\wap\\index.html',
      1 => 1539161098,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5bbdbc11629c95_80924020 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<style type="text/css">
	html,body{
		overflow-x:hidden;
	}
</style>

    <body>
        <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->

        <div class="container">

            <div class="row banner">
                <!--<img src="/template/wap/public/css/self/image/banner_1.jpg" />-->
                <link rel="stylesheet" href="/template/wap/public/css/ydui.css?rev=a4b9d6e8c9c1cae7ea4676f911682af7"/>
                <section class="g-flexview">


                    <div class="m-slider" data-ydui-slider>
                        <div class="slider-wrapper">
                            <div class="slider-item">
                                <a href="">
                                    <img src="/template/wap/public/css/self/image/banner_1.jpg">
                                </a>
                            </div>
                            <div class="slider-item">
                                <a href="">
                                    <img src="/template/wap/public/css/self/image/banner_2.jpg">
                                </a>
                            </div>
                            <div class="slider-item">
                                <a href="">
                                    <img src="/template/wap/public/css/self/image/banner_1.jpg">
                                </a>
                            </div>
                        </div>
                        <div class="slider-pagination"></div>
                    </div>

                </section>
                <?php echo '<script'; ?>
 src="/template/wap/public/js/ydui.js"><?php echo '</script'; ?>
>





            </div>

            <div class="row nav-bar">
            	    <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=new_detail&id=4"><img src="/template/wap/public/css/self/icon/vrxc.png" /><i>VR学车</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=coach_list" <?php if ($_smarty_tpl->tpl_vars['user_info']->value['k2_status'] == 2 && $_smarty_tpl->tpl_vars['comment_num']->value == 0) {?>onclick="cancel_turn();return false"<?php }?>><img src="/template/wap/public/css/self/icon/qbjl.png" /><i>全部教练</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=new_detail&id=3"><img src="/template/wap/public/css/self/icon/fwys.png" /><i>优势服务</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=xlc_map" <?php if ($_smarty_tpl->tpl_vars['user_info']->value['k2_status'] == 2 && $_smarty_tpl->tpl_vars['comment_num']->value == 0) {?>onclick="cancel_turn();return false"<?php }?>><img src="/template/wap/public/css/self/icon/qbcd.png" /><i>全部场地</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=partner&id=9"><img src="/template/wap/public/css/self/icon/hhrsq.png" /><i>合伙人申请</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=new_detail&id=5"><img src="/template/wap/public/css/self/icon/sqtj.png" /><i>学车流程</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=new_detail&id=6"><img src="/template/wap/public/css/self/icon/xcbz.png" /><i>学车保障</i></a>
                </div>
                <div class="col-xs-3 nav-bar-item">
                    <a href="/index.php?do=xlc_map&tj=1" <?php if ($_smarty_tpl->tpl_vars['user_info']->value['k2_status'] == 2 && $_smarty_tpl->tpl_vars['comment_num']->value == 0) {?>onclick="cancel_turn();return false"<?php }?>><img src="/template/wap/public/css/self/icon/bmtj.png" /><i>报名体检</i></a>
                </div>
            </div>

            <div class="row news">
            		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['activity']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <div class="col-xs-12 news-item">
                    <a href="/index.php?do=new_detail&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                        <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" />
                        <h2><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</h2>
                        <p><?php echo $_smarty_tpl->tpl_vars['item']->value['description'];?>
</p>
                    </a>
                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>

            <div class="row coach">
                <div class="p-hd">
                    <h2>优质教练</h2>
                    <p>我们有全城最优质的教练为你悉心教学</p>
                </div>
                <div class="swiper-container swiper-container-horizontal" style="padding-bottom: 10px;">
                    <div class="swiper-wrapper" id="good_coach">
                    		<!--<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teachers']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                        <div class="swiper-slide coach-item">
                        		<a href="/index.php?do=coach_details&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
	                            <div class="coach-avatar">
	                                <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="130" height="130" />
	                            </div>
	                            <div class="coach-name"><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</div>
	                            <div class="coach-place" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;"><?php echo $_smarty_tpl->tpl_vars['item']->value['sscd'];?>
</div>
	                            <?php if ($_smarty_tpl->tpl_vars['item']->value['avg'] == 0) {?>
	                            <div class="coach-place">暂无评分</div>
	                            <?php } else { ?>
	                            <div class="coach-star coach-star-<?php echo $_smarty_tpl->tpl_vars['item']->value['avg'];?>
"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>
	                            <?php }?>
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
-->
                </div>
            </div>

            <div class="row activity">
                <div class="p-hd" style="background-color: #0C0A0B;margin-right: 0px;margin-left: 0px;">
                    <h2 style="color: #FFFFFF; margin-left: 15px;margin-right: 15px;">最新活动</h2>
                    <p style="color: #FFFFFF; margin-left: 15px;margin-right: 15px;">易点学车丨让学车变得容易点</p>
                </div>
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['activity_new']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                 <div class="col-xs-12 activity-item">
                 	 <a href="/index.php?do=new_detail&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
	                 	 <img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
" width="100%" />
	                     <h2><?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
</h2>
	                   </a>
                </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            </div>
            
            <div class="row kong"></div>
			
			<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


        </div>
        <?php echo '<script'; ?>
 src="/template/wap/public/js/libs/swiper-3.4.1.jquery.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
        	
        		$(function () {
				wx.ready(function(){
					wx.getLocation({
						type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
					    success: function (res) {
					        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
					        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
					        var speed = res.speed; // 速度，以米/每秒计
					        var accuracy = res.accuracy; // 位置精度
					        
					        $.ajax({
								url: '/index.php?do=good_coach_ajax',
								type: 'get',
								dataType: 'json',
								data: 'loca='+latitude+','+longitude,
								error: function() {
									//alert('error');
								},
								success: function(coach) {
									data = eval(coach);
									var len=data.length;
									var str = "";
									
			                        for(var i=0;i<len;i++){
			                        		str += '<div class="swiper-slide coach-item">'+
			                        					'<a href="/index.php?do=coach_details&id='+data[i].id+'">'+
			                        						'<div class="coach-avatar">'+
			                        							'<img src="'+ data[i].img +'" width="130px" height="130px" />'+
			                        						'</div>'+
			                        						'<div class="coach-name">'+ data[i].xingming +'</div>'+
			                        						'<div class="coach-place" style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">'+ data[i].sscd +'</div>';
			                        						if(data[i].avg==0){
			                        							str += '<div class="coach-place">暂无评分</div>';
			                        						} else {
			                        							str += ' <div class="coach-star coach-star-'+ data[i].avg +'"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>';
			                        						}
			                        						str += '<div class="coach-course">'+ data[i].drive_type;
			                        						if(data[i].kemu==0){
			                        							str += '科目未知';
			                        						} else {
			                        							str += ' 科目'+data[i].kemu;
			                        						}
			                        						str += '</div>';
			                        			str += '</a>'+
			                        			   '</div>';
			                        }
			                        str += '<?php echo '<script'; ?>
 src="/template/wap/public/js/libs/swiper-3.4.1.jquery.min.js" type="text/javascript" charset="utf-8"><\/script>';
									$("#good_coach").html(str);
					        			swiper();
								}
							});
					    }
					});
				});
			});
        		
        		function cancel_turn(){
				var k2 = <?php echo $_smarty_tpl->tpl_vars['user_info']->value['k2_status'];?>
;
				if(k2==2){
					alert("请先到 “我的”-“学习中心” 评价教练");
					return false;
				}
			}
        		
        		function swiper(){
        			var swiper = new Swiper('.swiper-container', {
	                spaceBetween: 10,
	                slidesPerView: 2.4,
	                slidesOffsetBefore: 15,
	                slidesOffsetAfter: 15
	            });
        		}
        <?php echo '</script'; ?>
>
    </body>

</html>
<?php }
}
