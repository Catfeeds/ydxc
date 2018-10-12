<?php
/* Smarty version 3.1.30, created on 2018-09-07 08:09:43
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/my_study.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b923247619a67_92269185',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cb6593793817e013a7336db17e4db13d1a92e3d6' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/my_study.html',
      1 => 1536233056,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b923247619a67_92269185 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	
	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<form method="post" id="myform" action="/index.php?do=comment_submit">
			<div class="container">
				<div class="row my-info">
					<div class="col-xs-12">
						<p>班级信息</p>
						<h2><?php echo $_smarty_tpl->tpl_vars['class_title']->value;?>
</h2>
					</div>
					<div class="col-xs-12">
						<p>场地位置</p>
						<h2><?php echo $_smarty_tpl->tpl_vars['cd']->value['cd_address'];?>
</h2>
					</div>
					<div class="col-xs-12">
						<p>当前科目</p>
						<h2>科目<?php echo $_smarty_tpl->tpl_vars['kemu']->value;?>
</h2>
					</div>
					<div class="col-xs-12">
						<p>当前教练</p>
						<h2><?php echo $_smarty_tpl->tpl_vars['xingming']->value;?>
</h2>
					</div>
					<div class="col-xs-12">
						<p>教练电话</p>
						<h2><?php echo $_smarty_tpl->tpl_vars['coach_phone']->value;?>
</h2>
					</div>
				</div>
				
				<div class="row evaluate">
					<p class="col-xs-12">评价</p>
					<div class="col-xs-12">
						<span>评价打分</span>
						<div class="stars stars-example-css" style="display: inline-block; width: auto; padding: 0 16px 0 30px;">
							<div class="br-wrapper br-theme-css-stars">
								<select id="example-css" name="rating" style="display: none;">
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
						</div>
						<!--<span>3分</span>-->
					</div>
				</div>
				
				<div class="row info-text">
					<textarea name="content" rows="6" placeholder="请填入你对教练的评价"></textarea>
				</div>
				
				<input type="hidden" name="coach_id" value="<?php echo $_smarty_tpl->tpl_vars['coach_id']->value;?>
" />
				
				<div class="kong row"></div>
				
				<div class="row application-btn">
					<input  class="col-xs-12" id="form_submit" type="submit" value="提交" style="border: 0; color: #FFFFFF; background-color: #22A7F0;"  />
				</div>
				
			</div>
		</form>
		<?php echo '<script'; ?>
 src="/template/wap/public/js/jquery.barrating.js"><?php echo '</script'; ?>
>
		<?php echo '<script'; ?>
 src="/template/wap/public/js/examples.js"><?php echo '</script'; ?>
>
		
		<?php echo '<script'; ?>
>
			var k2_status = <?php echo $_smarty_tpl->tpl_vars['userwxinfo']->value['k2_status'];?>
;
			$('#form_submit').click(function(){
				if(2 == k2_status){
					alert("评论提交成功");
				} else {
					alert("未通过考试，不能评论");
				}
			});
		<?php echo '</script'; ?>
>
		
	</body>
</html>
<?php }
}
