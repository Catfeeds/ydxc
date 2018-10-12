<?php /* Smarty version 2.6.22, created on 2017-08-16 23:35:41
         compiled from go.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<style type="text/css">
		#r-result,#r-result table{width:100%;}
	</style>
	


	<body>
		<div id="allmap" style="width: 100%; height: 300px;"></div>
		<div id="r-result"></div>
	</body>
</html>

	<script>
			        
			        // 百度地图API功能
					var map = new BMap.Map("allmap");    // 创建Map实例
					var point = new BMap.Point(106.559614,29.567507);  //当前位置
					
					map.centerAndZoom(new BMap.Point(106.559614,29.567507), 12);  // 初始化地图,设置中心点坐标和地图级别
					var p1 = new BMap.Point(106.578910,29.591646);						//起点
					var p2 = new BMap.Point(106.565843,29.538936);//终点
					var driving = new BMap.TransitRoute(map, {renderOptions:{map: map, panel: "r-result"}});
					driving.search(p1, p2);
				
					map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
	</script>