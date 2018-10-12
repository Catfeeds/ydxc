<?php /* Smarty version 2.6.22, created on 2017-08-13 21:30:29
         compiled from enlist.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mold">
				<h1 class="col-xs-12">班别选择</h1>
				<div class="col-xs-12">
					<?php $_from = $this->_tpl_vars['course']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<div class="col-xs-12">
						<label for="<?php echo $this->_tpl_vars['item']['id']; ?>
">
							<input type="radio" name="class" value="<?php echo $this->_tpl_vars['item']['id']; ?>
" id="<?php echo $this->_tpl_vars['item']['id']; ?>
" /><?php echo $this->_tpl_vars['item']['name']; ?>

						</label>
						<span class="right">
							<?php if ($this->_tpl_vars['item']['id'] == 4): ?><?php echo $this->_tpl_vars['item']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['item']['id'] == 5): ?><?php echo $this->_tpl_vars['item']['zd_price']; ?>
<?php elseif ($this->_tpl_vars['item']['id'] == 6): ?><?php echo $this->_tpl_vars['item']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['item']['id'] == 7): ?><?php echo $this->_tpl_vars['item']['zd_price']; ?>
<?php endif; ?>
						</span>
					</div>
					<?php endforeach; endif; unset($_from); ?>
				</div>				
			</div>
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<a href="tel:400-6898-909">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线<?php echo $this->_tpl_vars['course']['coach']; ?>
</p>	             
					<p>400-6898-909</p>	
				</div>
				</a>
				<a class="col-xs-8 enroll-btn" href="javascript:void(0);" id="next">下一步</a>
			</div>
			
		</div>
		
	</body>
	<script>
			 $(function(){
				  $(":radio").click(function(){
				   		var id = $(this).val();
				   		var href = "/ydxc/index.php?do=enlist_details&coach=<?php echo $this->_tpl_vars['coach']; ?>
&id="+id;
				   		$("#next").attr("href",href);
				  });
				  
				  $("#next").click(function(){
				  		if($('input:radio[name="class"]:checked').val()==null){
				  			alert("请选择一个班级");
				  		}
				  });
				  
			 });
	</script>
</html>