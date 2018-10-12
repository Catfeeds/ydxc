<?php
/* Smarty version 3.1.30, created on 2017-09-07 16:30:51
  from "/data/www/ydxc/ydxc/template/wap/advise.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b103bba5c7a8_01097342',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '8e890f77fa0b97cb271aba2c228b8f3d53cd3bae' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/wap/advise.html',
      1 => 1504773045,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59b103bba5c7a8_01097342 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="data">
				
			
			<div class="info-text">
				<textarea name="content" id="content" rows="6" style="width: 90%;" placeholder="请填入您的建议"></textarea>
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
					url:"/ydxc/index.php?do=advise&action=add",
					async:true,
					data:{content:content},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							alert("操作成功");
							window.location.href = "/ydxc/index.php?do=center";
						}else{
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
