<?php
/* Smarty version 3.1.30, created on 2017-09-28 17:20:56
  from "/data/www/ydxc/ydxc/template/wap/coach.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59ccbef88b92c2_39549510',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '98e0dfa174ff10f291eea6e0dbf417c1f8ba63d9' => 
    array (
      0 => '/data/www/template/wap/coach.html',
      1 => 1506590434,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59ccbef88b92c2_39549510 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row item" id="coach_list">
				<div style="height: 100%; width: 100%; display:flex;justify-content:center;align-items:center;">页面加载中...</div>
			</div>
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
				        
				        $.ajax({
							url: '/index.php?do=coach_list_ajax',
							type: 'get',
							dataType: 'json',
							data: 'loca='+latitude+','+longitude,
							error: function() {
								//alert('error');
							},
							success: function(coach){
								data = eval(coach);
								var len=data.length;
								var str = "";
								
								for(var i=0;i<len;i++){
									str += '<div class="col-xs-6">'+
												'<a class="coach-item" href="/index.php?do=coach_details&id='+ data[i].id +'">'+
													'<div class="coach-avatar">'+
														'<img src="'+ data[i].img +'" style="width: 145px;height: 145px;"/>'+
													'</div>'+
													'<div class="coach-name">'+ data[i].xingming +'</div>'+
													'<div class="coach-place" style="width: 145px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;">'+data[i].sscd+'</div>';
													if(data[i].avg==0){
														str += '<div class="coach-place">暂无学员打分</div>';
													} else {
														str +='<div class="coach-star coach-star-'+ data[i].avg +'"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>';
													}
													str +='<div class="coach-course">';
													if(data[i].kemu==0){
														str += '科目未知';
													} else {
														str += '科目'+ data[i].kemu;
													}
													str +='</div>';
										str	+=	'</a>'+
										   '</div>';
								}
								$("#coach_list").html(str);
							},
						});
				   	}
				});
			});
		});
<?php echo '</script'; ?>
><?php }
}
