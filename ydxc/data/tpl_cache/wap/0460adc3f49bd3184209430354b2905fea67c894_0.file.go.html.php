<?php
/* Smarty version 3.1.30, created on 2017-08-17 22:09:56
  from "/data/www/ydxcnew/ydxc/template/wap/go.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995a3b4b99066_04353341',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0460adc3f49bd3184209430354b2905fea67c894' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/go.html',
      1 => 1502978987,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995a3b4b99066_04353341 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<style type="text/css">
		#r-result,#r-result table{width:100%;}
	</style>
	


	<body>
		<div id="allmap" style="width: 100%; height: 300px;"></div>
		<div id="r-result"></div>
	</body>
</html>

	<?php echo '<script'; ?>
>
		
			        // 百度地图API功能
					var map = new BMap.Map("allmap");    // 创建Map实例
					var point = new BMap.Point(106.559614,29.567507);  //当前位置
					
					map.centerAndZoom(new BMap.Point(point), 12);  // 初始化地图,设置中心点坐标和地图级别
					var p1 = new BMap.Point(106.559614,29.567507);						//起点
					var p2 = new BMap.Point(<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lng'];?>
,<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lat'];?>
);//终点
					var driving = new BMap.TransitRoute(map, {renderOptions:{map: map, panel: "r-result"}});
					driving.search(p1, p2);
				
					map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	<?php echo '</script'; ?>
><?php }
}
