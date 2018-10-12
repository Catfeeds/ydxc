<?php
/* Smarty version 3.1.30, created on 2018-09-07 14:01:42
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/partner.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b9284c69b0076_85638003',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '84f0355361d74032e1c446222def9bc7ef7532ab' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/partner.html',
      1 => 1536303204,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b9284c69b0076_85638003 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
	<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->	
	<div class="container">
			
		<!--<div class="row video">
			<?php echo $_smarty_tpl->tpl_vars['value']->value['content'];?>

		</div>-->
		<!--<div class="row img">
			<img src="public/css/self/image/demo_1.jpg"/>
		</div>-->
		
		
		<div class="row partner-text" style="overflow: hidden;">
			<?php echo $_smarty_tpl->tpl_vars['value']->value['vedio_url'];?>

			<div style="padding:6px 12px;">
				<?php echo $_smarty_tpl->tpl_vars['value']->value['content'];?>

			</div>
			<!--<div class="col-xs-12">
				<h1>活动规则</h1>
				<p class="danger">(请仔细阅读以下活动规则)</p>
			</div>
			<div class="col-xs-12">
				<h2>	一、活动主题</h2>
				<p><?php echo $_smarty_tpl->tpl_vars['value']->value['title'];?>
</p>
			</div>
			<div class="col-xs-12">
				<h2>二、报名时间</h2>
				<p>报名时间：<span><?php echo $_smarty_tpl->tpl_vars['value']->value['signup_time'];?>
起</span></p>
			</div>
			<div class="col-xs-12">
				<h2>	三、活动规则</h2>
				<?php echo $_smarty_tpl->tpl_vars['value']->value['rules'];?>

			</div>-->
		</div>
		
		<form method="post" id="myform">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['value']->value['id'];?>
" name="data[actid]" />
		<div class="row data">
				<div class="col-xs-12">
					<div>
						<label for="">
							<input type="text" name="data[username]" id="username"  value="" placeholder="请输入姓名" />
						</label>
					</div>
					<div>
						<label for="">
							<input type="text" name="data[phone]" id="userphone"  value="<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
" placeholder="请输入手机号" />
						</label>
					</div>
					<div>
						<label for="">
							<input type="text" name="data[school]"  value="" placeholder="请输入所在学校（选填）" />
						</label>
					</div>
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
				<a class="col-xs-8 enroll-btn" href="javascript:dr_submit()">提交报名</a>
			</div>
			
			<div class="container" id="model">
			<div class="row">
				<div class="modal-body">
					<div>
						<h1>请输入你的手机号</h1>
						<input type="text" name="phone" id="phone" />
						<input id="btnSendCode" type="button" value="发送验证码" onclick="sendMessage()" />
					</div>
					<div>
						<h1>请输入你的验证码</h1>
						<input type="text" name="code" id="code" />
					</div>
				</div>
				<div class="modal-btn">
					<a id="banck" href="javascript:$('#model').css('display','none');">返回</a>
					<a href="javascript:visit_code()">确定</a>
				</div>
			</div>
		</div>
			</form>
	</div>	
		
		
		
		
		
		
		
	<?php echo '<script'; ?>
 src="public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="public/js/libs/swiper-3.4.1.jquery.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
>
    		function dr_submit() {
    			var phone = '<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
';
    			var username = $('#username').val().trim();
    			var userphone = $('#userphone').val().trim();
    			
    				if(username==''||username==null||userphone==''||userphone==null){
    					alert("名字和手机号不能为空");
    					return false;
    				}
				if(phone=='' || phone==null) {
					$("#model").css("display","block");
					return false;
				} else {
		    			$.ajax({
		    				type:"post",
		    				url:"/index.php?do=partner&action=post",
		    				async:true,
		    				data:$("#myform").serialize(),
		    				dataType:"json",
		    				success:function(data) {
		    					alert(data.code);
		    					if(data.status==1) {
		    						window.location.href = "/index.php";
		    					}
		    				}
		    			});
		    		}
    		}
    		
    		function visit_code() {
				var phone = $("#phone").val();
				var code = $("#code").val();
				$.ajax({
					type:"post",
					url:"/index.php?do=partner&action=visit",
					async:true,
					data:{phone:phone,code:code},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							window.location.href = "/index.php?do=partner&id=9";
						}else{
							alert(data.code);
						}
					}
				});
			}
			var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
	var phone = $("#phone").val();
  　curCount = count;
　　  //向后台发送处理数据
     $.ajax({
     　　type: "POST", //用POST方式传输
     　　dataType: "json", //数据格式:JSON
     　　url: "/index.php?do=partner&action=send&phone="+phone, //目标地址
    　　 error: function (XMLHttpRequest, textStatus, errorThrown) { },
     　　success: function (msg){
     		if(msg.status==5){
     			alert(msg.code);
     		} else {
     			　　//设置button效果，开始计时
			     $("#btnSendCode").attr("disabled", "true");
			     $("#btnSendCode").val(  curCount + "秒");
     			InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
     		}
     	}
     });
}
//timer处理函数
function SetRemainTime() {
            if (curCount == 0) {                
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").val("重新发送验证码");
            }
            else {
                curCount--;
                $("#btnSendCode").val( curCount + "秒");
            }
        }
    <?php echo '</script'; ?>
>
	</body>
</html>
<?php }
}
