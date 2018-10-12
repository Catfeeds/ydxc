<?php
/* Smarty version 3.1.30, created on 2017-08-31 23:42:19
  from "/data/www/ydxc/ydxc/template/wap/go.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a82e5bcf2ce1_05512213',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '288b0ecd86c495a79750cbd4751a6bb0917a1eb5' => 
    array (
      0 => '/data/www/ydxc/template/wap/go.html',
      1 => 1504194078,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59a82e5bcf2ce1_05512213 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<style type="text/css">
		#r-result,#r-result table{width:100%;}
	</style>
	
	<?php echo '<script'; ?>
>
		$(function () {
		
			wx.ready(function(){
				wx.getLocation({
				    type: 'wgs84', // 默认为wgs84的gps坐标，如果要返回直接给openLocation用的火星坐标，可传入'gcj02'
				    success: function (res) {
				        var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
				        var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
				        var speed = res.speed; // 速度，以米/每秒计
				        var accuracy = res.accuracy; // 位置精度
				        
				        // 百度地图API功能
						var map = new BMap.Map("allmap");    // 创建Map实例
						var point = new BMap.Point(longitude, latitude);  //当前位置
						
						//坐标转换完之后的回调函数
					    translateCallback = function (data){
					      if(data.status === 0) {
					        map.setCenter(data.points[0]);
							map.centerAndZoom(new BMap.Point(106.559614,29.567507), 12);  // 初始化地图,设置中心点坐标和地图级别
							var p1 = data.points[0];						//起点
							var p2 = new BMap.Point(<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lng'];?>
,<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lat'];?>
);//终点
							var driving = new BMap.TransitRoute(map, {renderOptions:{map: map, panel: "r-result"}});
							driving.search(p1, p2);
					      }
					    }
					
					    setTimeout(function(){
					        var convertor = new BMap.Convertor();
					        var pointArr = [];
					        pointArr.push(point);
					        convertor.translate(pointArr, 1, 5, translateCallback)
					    }, 1000);
						
//						map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
//						map.setCurrentCity("重庆");          // 设置地图显示的城市 此项是必须设置的
						map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
				    }
				});
			});
		
//			        // 百度地图API功能
//					var map = new BMap.Map("allmap");    // 创建Map实例
//					var point = new BMap.Point(106.559614,29.567507);  //当前位置
//					
//					map.centerAndZoom(new BMap.Point(point), 12);  // 初始化地图,设置中心点坐标和地图级别
//					var p1 = new BMap.Point(106.559614,29.567507);						//起点
//					var p2 = new BMap.Point(<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lng'];?>
,<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['lat'];?>
);//终点
//					var driving = new BMap.TransitRoute(map, {renderOptions:{map: map, panel: "r-result"}});
//					driving.search(p1, p2);
//				
//					map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放

		});
	<?php echo '</script'; ?>
>


	<body>
		<div id="allmap" style="width: 100%; height: 300px;"></div>
		<div id="r-result"></div>
	</body>
</html>
<?php }
}
