<?php
/* Smarty version 3.1.30, created on 2017-09-16 17:36:18
  from "/data/www/ydxc/ydxc/template/default/ditu.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59bcf0929c8056_38599320',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0e74460779e39d88d6bff90ded554fa82a311dbf' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/ditu.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59bcf0929c8056_38599320 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!--头部文件-->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--百度地图密钥-->
<?php echo '<script'; ?>
 type="text/javascript" src="http://api.map.baidu.com/api?v=1.5&ak=173efa7b4d9760ef6a81f27efa9aa63e"><?php echo '</script'; ?>
>
</head>


<body>
<!--地图div-->
<div style="width:754px;height:600px;margin:0 auto" id="allmap"></div>


<!--地图标志-->
<?php echo '<script'; ?>
 type="text/javascript">
    var map = new BMap.Map("allmap");    
	//修改经度纬度
    var point = new BMap.Point(106.334763,29.614369);  // 需要标注的位置的经纬度  
    map.centerAndZoom(point, 15);  // 中心位置和缩放倍数
    map.enableScrollWheelZoom();   // 添加滚动轴
    map.addControl(new BMap.NavigationControl());   // 添加左上角的标尺工具
    map.addControl(new BMap.NavigationControl());    
    map.addControl(new BMap.ScaleControl());    
    map.addControl(new BMap.OverviewMapControl());    
    map.addControl(new BMap.MapTypeControl());    
	//修改城市，不影响展示
    map.setCurrentCity("成都"); 
    
	//修改信息窗口大小
    var opts = {    
        width : 340,     // 信息窗口宽度    
        height: 15,     // 信息窗口高度    
		//修改信息窗口标题
        title : "鼎吉驾校"  // 信息窗口标题   
    }
	
	//修改公司名
    var infoWindow = new BMap.InfoWindow("陈家桥轻轨站1号出口出站即到 023-67303999", opts);  // 创建信息窗口对象 
		
    map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口 
    //var marker = new BMap.Marker(point);        // 创建标注,即地图上的小红点    
    //map.addOverlay(marker);      


	
	
	/**/var point = new BMap.Point(106.334763,29.614369);
	addMarker(point); // 创建小红点
    var infoWindow = new BMap.InfoWindow("重庆沙坪坝区新桥医院旁500米", opts);  // 创建信息窗口对象 
	//map.openInfoWindow(infoWindow, map.getCenter());      // 打开信息窗口 	
		
	// 编写自定义函数,创建标注
	function addMarker(point){
	  var marker = new BMap.Marker(point);
	  map.addOverlay(marker);
	}

	
<?php echo '</script'; ?>
>




<?php }
}
