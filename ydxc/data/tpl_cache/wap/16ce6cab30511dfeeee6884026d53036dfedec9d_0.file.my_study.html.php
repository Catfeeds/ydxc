<?php
/* Smarty version 3.1.30, created on 2017-08-18 00:47:41
  from "/data/www/ydxcnew/ydxc/template/wap/my_study.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995c8ad3a5195_60175786',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '16ce6cab30511dfeeee6884026d53036dfedec9d' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/my_study.html',
      1 => 1502988452,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5995c8ad3a5195_60175786 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row my-info">
				<div class="col-xs-12">
					<p>班级信息</p>
					<h2>实惠手动挡（C1）</h2>
				</div>
				<div class="col-xs-12">
					<p>场地位置</p>
					<h2>重庆沙坪坝大学城千百汇附近</h2>
				</div>
				<div class="col-xs-12">
					<p>当前科目</p>
					<h2>科目四</h2>
				</div>
				<div class="col-xs-12">
					<p>当前教练</p>
					<h2>段小奎</h2>
				</div>
				<div class="col-xs-12">
					<p>教练电话</p>
					<h2>13983606322</h2>
				</div>
			</div>
			
			<div class="row evaluate">
				<p class="col-xs-12">评价</p>
				<div class="col-xs-12">
					<span>教学质量</span>
					<div class="mark-star mark-star-3">
						<i class="iconfont icon-xing active"></i>
						<i class="iconfont icon-xing active"></i>
						<i class="iconfont icon-xing active"></i>
						<i class="iconfont icon-xing active"></i>
						<i class="iconfont icon-xing"></i>
					</div>
					<span>3分</span>
				</div>
				<div class="col-xs-12">
					<span>和蔼可亲</span>
					<div class="mark-star mark-star-3">
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
					</div>
					<span>3分</span>
				</div>
				<div class="col-xs-12">
					<span>教练人品</span>
					<div class="mark-star mark-star-3">
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
					</div>
					<span>3分</span>
				</div>
				<div class="col-xs-12">
					<span>总体评价</span>
					<div class="mark-star" id="mark_star">
						<i class="iconfont icon-xing active"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
						<i class="iconfont icon-xing"></i>
					</div>
					<span>3分</span>
				</div>
			</div>
			
			<div class="row info-text">
				<textarea name="" rows="6" placeholder="请填入你对教练的评价"></textarea>
			</div>
			
			<div class="kong row"></div>
			
			<div class="row application-btn">
				<a  class="col-xs-12">提交</a>
			</div>
			
		</div>
		
		
		<?php echo '<script'; ?>
 src="public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
