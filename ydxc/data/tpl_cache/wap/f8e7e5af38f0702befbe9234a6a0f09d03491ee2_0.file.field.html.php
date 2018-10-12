<?php
/* Smarty version 3.1.30, created on 2018-08-24 03:22:03
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/field.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7f79db805e38_90859807',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f8e7e5af38f0702befbe9234a6a0f09d03491ee2' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/field.html',
      1 => 1535079158,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b7f79db805e38_90859807 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row map-wrap">
				<div class="col-xs-12">
					<a class="map-k3" style="color: #FFFFFF;<?php if ($_smarty_tpl->tpl_vars['k']->value == 3) {?>background: #d81e06;<?php }?>" href="/index.php?do=xlc_map&k=3">科三</a>
					<a class="map-k2" style="color: #FFFFFF;<?php if ($_smarty_tpl->tpl_vars['k']->value == 2) {?>background: #d81e06;<?php }?>" href="/index.php?do=xlc_map&k=2">科二</a>
					<a class="map-tj" style="color: #FFFFFF;<?php if ($_smarty_tpl->tpl_vars['tj']->value == 1) {?>background: #d81e06;<?php }?>" href="/index.php?do=xlc_map&tj=1">体检</a>
					<!--<a class="map-dh" style="color: #FFFFFF;" <?php if (!empty($_smarty_tpl->tpl_vars['cd_info']->value['id'])) {?> href="/index.php?do=go&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
"<?php }?>>
							<i class="iconfont icon-quzheli"></i>
							<p>到这里</p>
					</a>-->
				</div>	
			</div>
			<div class="row map" id="allmap">
			</div>
			
			<div id="info"></div>
			
		</div>
		
	</body>
</html>
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
				        
				        // 百度地图API功能
						var map = new BMap.Map("allmap");    // 创建Map实例
						var point = new BMap.Point(longitude, latitude);  //当前位置
						
						map.centerAndZoom(new BMap.Point(longitude, latitude), 11);  // 初始化地图,设置中心点坐标和地图级别
						map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
						map.setCurrentCity("重庆");          // 设置地图显示的城市 此项是必须设置的
						map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
						
						var mapType1 = new BMap.MapTypeControl({mapTypes: [BMAP_NORMAL_MAP,BMAP_HYBRID_MAP]});
						map.removeControl(mapType1);
						var mapType2 = new BMap.MapTypeControl({anchor: BMAP_ANCHOR_TOP_LEFT});
						map.removeControl(mapType2);   //移除地图，三维，卫星图
						
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
						<?php if ($_smarty_tpl->tpl_vars['item']->value['class_id'] == 5) {?>
						var myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Icon("/template/wap/img/drive.png", new BMap.Size(20,20));
						<?php } else { ?>
						var myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Icon("/template/wap/img/hospital.png", new BMap.Size(20,20));
						<?php }?>
						myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
.imageSize = new BMap.Size(20,20);
						var marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
 = new BMap.Marker(pt<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
,{icon:myIcon<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
});  // 创建标注
						marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
.addEventListener("click",getAttr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
);
						function getAttr<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
(){
							<?php if ($_smarty_tpl->tpl_vars['item']->value['class_id'] == 5) {?>
							$.ajax({
								url:'/index.php?do=xlc_map_ajax&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&tj=<?php echo $_smarty_tpl->tpl_vars['tj']->value;?>
',
								type:'get',
								data:'loca='+latitude+','+longitude,
								dataType:'html',
								error: function() {
									alert('error');
								},
								success: function(data) {
									$('#info').html(data);
								}
							});
//							window.location.href = "/index.php?do=physical&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&tj=<?php echo $_smarty_tpl->tpl_vars['tj']->value;?>
";
//							$.ajax({
//								url:'/index.php?do=xlc_map_ajax&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&tj=<?php echo $_smarty_tpl->tpl_vars['tj']->value;?>
',
//								type:'get',
//								dataType:'html',
//								error: function() {
//									alert('error');
//								},
//								success: function(data) {
//									alert('success');
//									//$('#div').html(data);
//								}
//							});
							<?php } else { ?>
//							window.location.href = "/index.php?do=xlc_map&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&tj=<?php echo $_smarty_tpl->tpl_vars['tj']->value;?>
";
							$.ajax({
								url:'/index.php?do=physical&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
&k=<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
&tj=<?php echo $_smarty_tpl->tpl_vars['tj']->value;?>
',
								type:'get',
								dataType:'html',
								error: function() {
									alert('error');
								},
								success: function(data) {
									$('#info').html(data);
								}
							});
							<?php }?>
						}
						map.addOverlay(marker<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
);              // 将标注添加到地图中
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						
						//坐标转换完之后的回调函数
					    translateCallback = function (data){
					      if(data.status === 0) {
					        map.setCenter(data.points[0]);
							var d_json = data.points;
							var d_str = JSON.stringify(d_json);
							var l = jQuery.parseJSON(d_str);
							var my_lng = l[0].lng;
							var my_lat = l[0].lat;
							var my_loc = new BMap.Point(my_lng, my_lat);
							var myIc = new BMap.Icon("/template/wap/img/dw.png", new BMap.Size(30,30));
							myIc.imageSize = new BMap.Size(30,30);
							var my_marker = new BMap.Marker(my_loc,{icon:myIc});
							map.addOverlay(my_marker);
					      }
					    }
					    setTimeout(function(){
					        var convertor = new BMap.Convertor();
					        var pointArr = [];
					        pointArr.push(point);
					        convertor.translate(pointArr, 1, 5, translateCallback)
					    }, 1000);
				    }
				});
			});
	});
<?php echo '</script'; ?>
>
<?php }
}
