<?php /* Smarty version 2.6.22, created on 2017-08-13 23:21:11
         compiled from enlist_order.html */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row genre">
				<h1 class="col-xs-12">学车类型</h1>
				<div class="col-xs-12 ">
					<p class="left"><?php echo $this->_tpl_vars['courseshow']['name']; ?>
</p>
					<span class="right"><?php if ($this->_tpl_vars['courseshow']['id'] == 4): ?><?php echo $this->_tpl_vars['courseshow']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 5): ?><?php echo $this->_tpl_vars['courseshow']['zd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 6): ?><?php echo $this->_tpl_vars['courseshow']['sd_price']; ?>
<?php elseif ($this->_tpl_vars['courseshow']['id'] == 7): ?><?php echo $this->_tpl_vars['courseshow']['zd_price']; ?>
<?php endif; ?></span>
				</div>			
			</div>
			
			<div class="row site">
				<h1 class="col-xs-12">场地地址</h1>
				<div class="col-xs-12">
					<h2><?php echo $this->_tpl_vars['sscd']['title']; ?>
</h2>
					<p><?php echo $this->_tpl_vars['address_arr']['result']['formatted_address']; ?>
</p>
				</div>
			</div>
			
			
			<div class="row genre">
				<h1 class="col-xs-12">推荐人</h1>
				<div class="col-xs-12 ">
					<p>吴昊</p>
				</div>			
			</div>
			<form method="post" id="sign_form">
				<div class="row data">
					<div class="col-xs-12">
						<div>
							<label for="">
								<input type="text" name="data[uname]" id="uname"  value="" placeholder="请输入姓名" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[phone]" id="phone"  value="" placeholder="请输入手机号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[card_id]" id="card_id"  value="" placeholder="请输入身份证号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[shcool]" id="shcool"  value="" placeholder="请输入详细地址（学校）" />
							</label>
						</div>
					</div>
				</div>
			</form>
			
			<div class="row protocol">
				<div class="col-xs-12">
					<label>
						<input type="checkbox" name="" id="xy" value="" />
						本人已阅读并签署易点学车<a>《培训协议》</a>（电子协议与纸质协议具有同等法律效益)
					</label>					
				</div>
			</div>
			
			
			<div class="kong row"></div>
			
			<div class="row enroll">
				<div class="col-xs-4 enroll-call">
					<p>咨询热线</p>	             
					<p>400-6898-909</p>	
				</div>
				<a class="col-xs-8 enroll-btn" id="pay" href="javascript:transform_order();">支付</a>
			</div>
			
		</div>
		
	</body>
	<script>
		
		var name = $('#uname').val();
		var phone = $('#phone').val();
		var card_id = $('#card_id').val();
		var school = $('#shcool').val();
		
	function transform_order(){
			
		if(!$('#xy').is(':checked')){
			alert("请阅读并同意协议");
			return false;
		} else {
			if(""==name||""==phone||""==card_id){
				alert("请填写完整");
			} 
		}
//			else {
//				var type='<?php echo '<?php'; ?>
 echo $data["type"]; <?php echo '?>'; ?>
';
//	    			var cid='<?php echo '<?php'; ?>
 echo $data["id"]; <?php echo '?>'; ?>
';
//	    			var event_key='<?php echo '<?php'; ?>
 echo $data["event_key"]; <?php echo '?>'; ?>
';
//				var pid = $('#pid').val();
//				$.ajax({
//				url: '/index.php?s=order&c=home&m=indexforajax&mid=purchase&'+'&type='+type+'&cid='+cid+'&event_key='+event_key+'&pid='+pid+'&is_first_learn=1',
//				type: 'post',
//				dataType: 'json',
//				data: $('#pay_data').serialize(),
//				error: function() {
//					alert('error');
//				},
//				success: function(data) {
//					$("#payorder").html(data.return.pay.html);
//					jsApiCall();
//					$("#loding").hide();
//				}
//			});
//			}
//		}
	}
	</script>
</html>