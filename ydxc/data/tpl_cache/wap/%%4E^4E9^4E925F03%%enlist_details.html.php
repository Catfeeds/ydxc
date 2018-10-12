<?php /* Smarty version 2.6.22, created on 2017-08-13 21:43:24
         compiled from enlist_details.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mold-on">
				<label for="">
					<input type="radio" name="class" value="1" checked="checked"/><?php echo $this->_tpl_vars['courseshow']['name']; ?>

				</label>
				<span class="right">
					<?php if ($this->_tpl_vars['courseshow']['id'] == 4): ?><?php echo $this->_tpl_vars['courseshow']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 5): ?><?php echo $this->_tpl_vars['courseshow']['zd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 6): ?><?php echo $this->_tpl_vars['courseshow']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 7): ?><?php echo $this->_tpl_vars['courseshow']['zd_price']; ?>
<?php endif; ?>
				</span>
			</div>
			
			<div class="row notice">
				<h1 class="col-xs-12">班级说明</h1>
				<div class="col-xs-12">
					<?php echo $this->_tpl_vars['courseshow']['intro']; ?>

				</div>
			</div>
			
			
			<div class="row notice">
				<h1 class="col-xs-12">学车须知</h1>
				<div class="col-xs-12">
					<?php echo $this->_tpl_vars['courseshow']['liucheng']; ?>

				</div>
			</div>
			
			<div class="row kong"></div>
			
			
			<div class="row enroll">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-6898-909</p>	
				</div>
				<a class="col-xs-8 enroll-btn" href="/ydxc/index.php?do=enlist_order&id=<?php echo $this->_tpl_vars['id']; ?>
&coach=<?php echo $this->_tpl_vars['courseshow']['coach']; ?>
">确认报名</a>
			</div>
			
		</div>
		
	</body>
</html>