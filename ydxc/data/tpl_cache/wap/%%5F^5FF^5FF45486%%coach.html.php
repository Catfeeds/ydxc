<?php /* Smarty version 2.6.22, created on 2017-08-16 22:26:53
         compiled from coach.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		 <!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row item">
				<?php $_from = $this->_tpl_vars['coaches']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<div class="col-xs-6">
					<a class="coach-item" href="/ydxc/index.php?do=coach_details&id=<?php echo $this->_tpl_vars['item']['id']; ?>
">
						<div class="coach-avatar">
	                          <img src="<?php echo $this->_tpl_vars['item']['img']; ?>
" style="width: 145px;height: 145px;"/>
	                     </div>
	                     <div class="coach-name"><?php echo $this->_tpl_vars['item']['xingming']; ?>
</div>
	                     <div class="coach-place"><?php echo $this->_tpl_vars['item']['sscd']; ?>
</div>
	                     <div class="coach-star coach-star-1"><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i><i class="iconfont icon-xing"></i></div>
	                     <div class="coach-course"><?php if ($this->_tpl_vars['item']['kemu'] == 0): ?> 科目未知<?php else: ?> 科目<?php echo $this->_tpl_vars['item']['kemu']; ?>
<?php endif; ?></div>
					</a>
				</div>
				<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
		
		
	</body>
</html>