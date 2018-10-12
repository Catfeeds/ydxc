<?php
/* Smarty version 3.1.30, created on 2018-09-07 07:19:25
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/coach_detail_k2.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b92267dd030a7_39597965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0a4477bb02ab081d8353e7cc4e346a15904d9959' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/coach_detail_k2.html',
      1 => 1536303291,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b92267dd030a7_39597965 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row video">
				<img src="<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['img1'];?>
"/>
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
								<?php if ($_smarty_tpl->tpl_vars['newsshow']->value['avg'] == 0) {?>
								<div>
									<span>暂无学员打分</span>
								</div>
								<?php } else { ?>
								<div class="coach-star coach-star-<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['avg'];?>
">
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
									<i class="iconfont icon-xing"></i>
								</div>
								<?php }?>
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
					<p><?php echo $_smarty_tpl->tpl_vars['cd']->value['cd_address'];?>
</p>
				</div>
			</div>
			
			<div class="row assess">
				<h1 class="col-xs-12">学员评价</h1>
				<div class="col-xs-12 assess-nav">
					<?php if (empty($_smarty_tpl->tpl_vars['comment']->value)) {?>
					<div class="col-xs-12" style="text-align: center;">
						暂无评论
					</div>
					<?php } else { ?>
					<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['comment']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
					<div class="col-xs-12">
						<h2>匿名评论</h2>
						<span><?php echo date("Y-m-d H:i",$_smarty_tpl->tpl_vars['item']->value['inputtime']);?>
</span>
						<p class="col-xs-12"><?php echo $_smarty_tpl->tpl_vars['item']->value['content'];?>
</p>
					</div>
					<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

					<?php }?>
				</div>
			</div>
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<a href="tel:400-689-8909">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-689-8909</p>
				</div>
				</a>
				<!--
                	作者：offline
                	时间：2017-08-25
                	描述：科三教练确认选择  不进入报名页面
                -->
                <?php if ($_smarty_tpl->tpl_vars['wx_user']->value['k2_status'] == 2) {?>
				<a onclick="is_choose()" class="col-xs-8 enroll-btn">确认选择</a>
				<?php } else { ?>
				<!--
                	作者：offline
                	时间：2017-08-25
                	描述：科二教练 报名 付款
                -->
				<a onclick="is_choose1()" class="col-xs-8 enroll-btn">我要报名</a>
				<?php }?>
			</div>
		</div>	
		
	</body>
</html>
<?php echo '<script'; ?>
>
	function is_choose(){
		var kemu = <?php echo $_smarty_tpl->tpl_vars['sign']->value['kemu'];?>
;
		if(kemu == 3){
			alert("你已选过科三教练");
		} else if(kemu == <?php echo $_smarty_tpl->tpl_vars['newsshow']->value['kemu'];?>
){
			alert("科目二已过，请选择科三教练");
		} else {
			if(confirm("确认选择该教练？")){
				alert("选择成功");
				window.location.href = "/index.php?do=coach_confirm&coach=<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['id'];?>
";
				return true;
			} else {
				return false;
			}
		}
	}
	function is_choose1(){
		var kemu = <?php echo $_smarty_tpl->tpl_vars['sign']->value['kemu'];?>
;
		if(kemu == 2){
			alert("你已报名，无需再报名");
		} else {
				window.location.href = "/index.php?do=enlist&coach=<?php echo $_smarty_tpl->tpl_vars['newsshow']->value['id'];?>
";
		}
	}
<?php echo '</script'; ?>
>
<?php }
}
