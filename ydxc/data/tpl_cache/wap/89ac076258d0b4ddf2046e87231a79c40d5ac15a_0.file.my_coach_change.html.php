<?php
/* Smarty version 3.1.30, created on 2018-08-24 04:06:16
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/my_coach_change.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b7f8438f38f17_51063183',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89ac076258d0b4ddf2046e87231a79c40d5ac15a' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/my_coach_change.html',
      1 => 1535078611,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b7f8438f38f17_51063183 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="data">
				
			
			<div class="info-text">
				<textarea name="content" id="content" rows="6" style="width: 90%;" placeholder="请填写想更换的教练和理由"></textarea>
			</div>
			
			<div class="kong"></div>
			
			<div class="application-btn" style="margin: 0px; padding: 0px;">
				<a href="javascript:dr_submit();" class="col-xs-12">提交</a>
			</div>
			
		</div>
	<?php echo '<script'; ?>
>
		function dr_submit() {
			var content = $('#content').val().trim();
			if(content==null||content==''){
				alert('内容不能为空');
			} else {
				$.ajax({
					type:"post",
					url:"/index.php?do=coach_change&action=add",
					async:true,
					data:{content:content},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							alert("操作成功");
							window.location.href = "/index.php?do=center";
						} else if(data.status==2){
							alert(data.code);
						} else{
							alert("操作失败");
						}
					}
				});
			}
		}
	<?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
