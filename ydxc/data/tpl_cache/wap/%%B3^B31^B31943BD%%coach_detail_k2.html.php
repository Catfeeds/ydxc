<?php /* Smarty version 2.6.22, created on 2017-08-13 21:17:21
         compiled from coach_detail_k2.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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
							<img src="<?php echo $this->_tpl_vars['newsshow']['img']; ?>
"/>
							<div>
								<span><?php echo $this->_tpl_vars['newsshow']['xingming']; ?>
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
							<?php echo $this->_tpl_vars['newsshow']['drive_type']; ?>
/科目<?php echo $this->_tpl_vars['newsshow']['kemu']; ?>

						</div>
					</div>
				</div>
				
				<div class="col-xs-12 drill-mark">
					<div class="col-xs-4">
						<h1><?php echo $this->_tpl_vars['newsshow']['ljpxrs']; ?>
</h1>
						<p>累计培训人数</p>
					</div>
					<div class="col-xs-4">
						<h1><?php echo $this->_tpl_vars['newsshow']['ketgl']; ?>
%</h1>
						<p>科目二通过率</p>
					</div>
					<div class="col-xs-4">
						<h1><?php echo $this->_tpl_vars['newsshow']['kstgl']; ?>
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
					<h2><?php echo $this->_tpl_vars['newsshow']['sscd_name']; ?>
</h2>
					<p><?php echo $this->_tpl_vars['address_arr']['result']['formatted_address']; ?>
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
				<a href="/ydxc/index.php?do=enlist&coach=<?php echo $this->_tpl_vars['newsshow']['id']; ?>
" class="col-xs-8 enroll-btn">我要报名</a>
			</div>
		</div>	
		
	</body>
</html>