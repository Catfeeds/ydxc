<?php
/* Smarty version 3.1.30, created on 2017-08-17 20:30:12
  from "/data/www/ydxcnew/ydxc/template/wap/coach_detail_k2.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59958c542585b7_66079513',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '23b9fb457ee8608acfdd056f91e0acd8628a56bd' => 
    array (
      0 => '/data/www/ydxcnew/ydxc/template/wap/coach_detail_k2.html',
      1 => 1502629993,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_59958c542585b7_66079513 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row video">
				<img src="/ydxc/template/wap/public/css/self/image/demo_1.jpg"/>
			</div>
			
			
			<div class="row drill">
				<div class="col-xs-12 drill-name">
					<div class="col-xs-12">
						<div class="drill-summary">
							<img src="<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['img'];?>
"/>
							<div>
								<span><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['xingming'];?>
</span>
								<div class="coach-star coach-star-4">
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
								</div>
							</div>
						</div>
						
						<div class="drill-subject">
							<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['drive_type'];?>
/科目<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['kemu'];?>

						</div>
					</div>
				</div>
				
				<div class="col-xs-12 drill-mark">
					<div class="col-xs-4">
						<h1><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['ljpxrs'];?>
</h1>
						<p>累计培训人数</p>
					</div>
					<div class="col-xs-4">
						<h1><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['ketgl'];?>
%</h1>
						<p>科目二通过率</p>
					</div>
					<div class="col-xs-4">
						<h1><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['kstgl'];?>
%</h1>
						<p>科目三通过率</p>
					</div>
				</div>				
			</div>
			
			<div class="row authentication">
				<div class="col-xs-4">
					<i class="iconfont icon-zhengpinrenzheng"></i>
					<p>平台保证</p>
				</div>
				<div class="col-xs-4">
					<i class="iconfont icon-jinpaihuiyuan"></i>
					<p>金牌教练</p>
				</div>
				<div class="col-xs-4">
					<i class="iconfont icon-jiaxiao"></i>
					<p>公司直营</p>
				</div>
			</div>
			
			<div class="row site">
				<h1 class="col-xs-12">场地地址</h1>
				<div class="col-xs-12">
					<h2><?php echo $_smarty_tpl->tpl_vars['newsshow']->value['sscd_name'];?>
</h2>
					<p><?php echo $_smarty_tpl->tpl_vars['address_arr']->value['result']['formatted_address'];?>
</p>
				</div>
			</div>
			
			<div class="row assess">
				<h1 class="col-xs-12">学员评价</h1>
				<div class="col-xs-12 assess-nav">
					<div class="col-xs-12">
						<h2>谭春林</h2>
						<span>16分钟前</span>
						<p class="col-xs-12">老师教的很认真也很仔细</p>
					</div>
					<div class="col-xs-12">
						<h2>谭春林</h2>
						<span>16分钟前</span>
						<p class="col-xs-12">老师教的很认真也很仔细</p>
					</div>		
				</div>
			</div>
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<a href="tel:400-6898-909">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-6898-909</p>	
				</div>
				</a>
				<a href="/ydxc/index.php?do=enlist&coach=<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['id'];?>
" class="col-xs-8 enroll-btn">我要报名</a>
			</div>
		</div>	
		
	</body>
</html>
<?php }
}
