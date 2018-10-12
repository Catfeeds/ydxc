<?php
/* Smarty version 3.1.30, created on 2018-08-26 07:27:32
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist_details.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b825664a251c7_61696792',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7cfb7f799bc254de56d64d717b39690e18828240' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist_details.html',
      1 => 1535267999,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b825664a251c7_61696792 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row mold-on">
				<label for="">
					<input type="radio" name="class" value="1" checked="checked"/><?php echo $_smarty_tpl->tpl_vars['courseshow']->value['name'];?>

				</label>
				<span class="right">
					<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];?>

				</span>
			</div>
			
			<div class="row notice">
				<h1 class="col-xs-12">班级说明</h1>
				<div class="col-xs-12">
					<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['intro'];?>

				</div>
			</div>
			
			
			<div class="row notice">
				<h1 class="col-xs-12">学车须知</h1>
				<div class="col-xs-12">
					<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['liucheng'];?>

				</div>
			</div>
			
			<div class="row kong"></div>
			
			
			<div class="row enroll">
				<a href="tel:400-689-8909">
					<div class="col-xs-4 enroll-call">
						<p>咨询热线</p>	             
						<p>400-689-8909</p>
					</div>
				</a>
				<a class="col-xs-8 enroll-btn" href="javascript:dr_submit()">确认报名</a>
			</div>
			
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
		
		<?php echo '<script'; ?>
>
			function dr_submit() {
				var phone = '<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
';
				if(phone=='' || phone==null) {
					$("#model").css("display","block");
					return false;
				}else{
					window.location.href = "/index.php?do=enlist_order&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&coach=<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['coach'];?>
";
				}
				
			}
			function visit_code() {
				var phone = $("#phone").val();
				var code = $("#code").val();
				$.ajax({
					type:"post",
					url:"/index.php?do=enlist_details&action=visit",
					async:true,
					data:{phone:phone,code:code},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							window.location.href = "/index.php?do=enlist_order&id=<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
&coach=<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['coach'];?>
";
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
     　　url: "/index.php?do=enlist_details&action=send&phone="+phone, //目标地址
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
