<?php /* Smarty version 2.6.22, created on 2017-08-17 12:00:02
         compiled from field.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<a class="map-k3" style="color: #FFFFFF;" href="/ydxc/index.php?do=xlc_map&k=3">科三</a>
					<a class="map-k2" style="color: #FFFFFF;" href="/ydxc/index.php?do=xlc_map&k=2">科二</a>
					<a class="map-tj" style="color: #FFFFFF;">体检</a>
					<a class="map-dh" style="color: #FFFFFF;" <?php if (! empty ( $this->_tpl_vars['cd_info']['id'] )): ?> href="/ydxc/index.php?do=go&id=<?php echo $this->_tpl_vars['cd_info']['id']; ?>
"<?php endif; ?>>
							<i class="iconfont icon-quzheli"></i>
							<p>到这里</p>
					</a>
				</div>	
			</div>
			<div class="row map" id="allmap">
				
			</div>
			
			<div style="height: 300px;background-color: #FFFFFF;">
				<div class="row location">
					<div class="col-xs-12">
						<h2><?php echo $this->_tpl_vars['cd_info']['title']; ?>
</h2>
						<p><?php echo $this->_tpl_vars['address_arr']['result']['formatted_address']; ?>
</p>
					</div>
				</div>
				
				<div class="row trainer">
					<div class="col-xs-12 trainer-name">
						<?php $_from = $this->_tpl_vars['coach']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
						<a href="/ydxc/index.php?do=coach_details&id=<?php echo $this->_tpl_vars['item']['id']; ?>
" class="col-xs-12">
							<div class="trainer-summary">
								<img src="<?php echo $this->_tpl_vars['item']['img']; ?>
"/>
								<div>
									<h3><?php echo $this->_tpl_vars['item']['xingming']; ?>
</h3><span><?php echo $this->_tpl_vars['item']['drive_type']; ?>
<?php if (empty ( $this->_tpl_vars['item']['kemu'] )): ?><?php else: ?>/科<?php echo $this->_tpl_vars['item']['kemu']; ?>
<?php endif; ?></span>
									<p><?php echo $this->_tpl_vars['cd_info']['title']; ?>
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
						<?php endforeach; endif; unset($_from); ?>
					</div>
				</div>	
				<?php if (count ( $this->_tpl_vars['coach'] ) > 2): ?>
				<div class="row see">
					<a href="/ydxc/index.php?do=xlc_map&id=<?php echo $this->_tpl_vars['cd_info']['id']; ?>
&p=2">查看更多</a>
				</div>
				<?php endif; ?>
			</div>
			
		</div>
		
	</body>
</html>
<script type="text/javascript">
		
		// 百度地图API功能
		var map = new BMap.Map("allmap");    // 创建Map实例
		var point = new BMap.Point(106.559614,29.567507);
		map.centerAndZoom("重庆", 11);  // 初始化地图,设置中心点坐标和地图级别
		map.addControl(new BMap.MapTypeControl());   //添加地图类型控件
		map.setCurrentCity("重庆");          // 设置地图显示的城市 此项是必须设置的
		map.enableScrollWheelZoom(true);     //开启鼠标滚轮缩放
		
		//创建图片
		<?php $_from = $this->_tpl_vars['newsshow']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
		var pt<?php echo $this->_tpl_vars['key']; ?>
 = new BMap.Point(<?php echo $this->_tpl_vars['item']['lng']; ?>
,<?php echo $this->_tpl_vars['item']['lat']; ?>
);
		var myIcon<?php echo $this->_tpl_vars['key']; ?>
 = new BMap.Icon("<?php echo $this->_tpl_vars['item']['img']; ?>
", new BMap.Size(50,50));
		var marker<?php echo $this->_tpl_vars['key']; ?>
 = new BMap.Marker(pt<?php echo $this->_tpl_vars['key']; ?>
,{icon:myIcon<?php echo $this->_tpl_vars['key']; ?>
});  // 创建标注
		marker<?php echo $this->_tpl_vars['key']; ?>
.addEventListener("click",getAttr<?php echo $this->_tpl_vars['key']; ?>
);
		function getAttr<?php echo $this->_tpl_vars['key']; ?>
(){
			window.location.href = "/ydxc/index.php?do=xlc_map&id=<?php echo $this->_tpl_vars['item']['id']; ?>
";
		}
		map.addOverlay(marker<?php echo $this->_tpl_vars['key']; ?>
);              // 将标注添加到地图中
		<?php endforeach; endif; unset($_from); ?>
    
</script>