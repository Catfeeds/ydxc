<?php
/* Smarty version 3.1.30, created on 2017-08-17 22:14:33
  from "/data/www/ydxcnew/ydxc/template/wap/field.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995a4c9826128_54889881',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '10efaa686507a5264138b870a754d036b88bb74d' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/field.html',
      1 => 1502979258,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995a4c9826128_54889881 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<a class="map-k3" style="color: #FFFFFF;" href="/ydxc/index.php?do=xlc_map&k=3">科三</a>
					<a class="map-k2" style="color: #FFFFFF;" href="/ydxc/index.php?do=xlc_map&k=2">科二</a>
					<a class="map-tj" style="color: #FFFFFF;" href="/ydxc/index.php?do=xlc_map&tj=1">体检</a>
					<a class="map-dh" style="color: #FFFFFF;" <?php if (!empty($_smarty_tpl->tpl_vars['cd_info']->value['id'])) {?> href="/ydxc/index.php?do=go&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
"<?php }?>>
							<i class="iconfont icon-quzheli"></i>
							<p>到这里</p>
					</a>
				</div>	
			</div>
			<div class="row map" id="allmap">
				
			</div>
			
			<div style="height: 300px;background-color: #FFFFFF;">
				<div class="row location">
					<!--<a <?php if ($_smarty_tpl->tpl_vars['cd_info']->value['class_id'] == 25) {?>href="/ydxc/index.php?do=physical&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
"<?php }?>>-->
						<div class="col-xs-12">
							<h2><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
</h2>
							<p><?php echo $_smarty_tpl->tpl_vars['address_arr']->value['result']['formatted_address'];?>
</p>
						</div>
					<!--</a>-->
				</div>
				
				<div class="row trainer">
					<div class="col-xs-12 trainer-name">
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['coach']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
						<a href="/ydxc/index.php?do=coach_details&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="col-xs-12">
							<div class="trainer-summary">
								<img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"/>
								<div>
									<h3><?php echo $_smarty_tpl->tpl_vars['item']->value['xingming'];?>
</h3><span><?php echo $_smarty_tpl->tpl_vars['item']->value['drive_type'];
if (empty($_smarty_tpl->tpl_vars['item']->value['kemu'])) {
} else { ?>/科<?php echo $_smarty_tpl->tpl_vars['item']->value['kemu'];
}?></span>
									<p><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
</p>
								</div>
							</div>
							
							<div class="coach-star coach-star-4 right">
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
										<i class="iconfont icon-xing"></i>
							</div>
						</a>	
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					</div>
				</div>	
				<?php if (count($_smarty_tpl->tpl_vars['coach']->value) > 2) {?>
				<div class="row see">
					<a href="/ydxc/index.php?do=xlc_map&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
&p=2">查看更多</a>
				</div>
				<?php }?>
			</div>
			
		</div>
		
	</body>
</html>
<?php echo '<script'; ?>
 type="text/javascript">
		
		// 百度地图API功能
		var map = new BMap.Map("allmap");    // 创建Map实例
		var point = new BMap.Point(106.559614,29.567507);
		map.centerAndZoom("重庆", 11);  // 初始化地图,设置中心点坐标和地图级别
		map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
		map.setCurrentCity("重庆");          // 设置地图显示的城市 此项是必须设置的
		map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
		
		//创建图片
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newsshow']->value, 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
		var pt<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Point(<?php echo $_smarty_tpl->tpl_vars['item']->value['lng'];?>
,<?php echo $_smarty_tpl->tpl_vars['item']->value['lat'];?>
);
		var myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Icon("<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
", new BMap.Size(50,50));
		var marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Marker(pt<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,{icon:myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
});  // 创建标注
		marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
.addEventListener("click",getAttr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
);
		function getAttr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
(){
			<?php if ($_smarty_tpl->tpl_vars['item']->value['class_id'] == 25) {?>
			window.location.href = "/ydxc/index.php?do=physical&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
";
			<?php } else { ?>
			window.location.href = "/ydxc/index.php?do=xlc_map&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
";
			<?php }?>
		}
		map.addOverlay(marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
);              // 将标注添加到地图中
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    
<?php echo '</script'; ?>
><?php }
}
