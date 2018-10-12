<?php
/* Smarty version 3.1.30, created on 2018-08-26 13:21:15
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/my_ewm.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b82a94ba52775_95326703',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd5af12995e268a99e6f32f2d295ae955b7978ce5' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/my_ewm.html',
      1 => 1535289668,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b82a94ba52775_95326703 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <meta name="format-detection" content="telephone=no" />
        <title>二维码</title>
        <meta name="description" content="Yan" />
        <meta name="keywords" content="Yan" />
        <meta name="author" content="Yan" />
        <?php echo '<script'; ?>
 src="/template/wap/public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <!--<?php echo '<script'; ?>
 src="public/js/self/custom.js"><?php echo '</script'; ?>
>-->
        <?php echo '<script'; ?>
 src="/client/public/js/self/custom1.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/template/wap/public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <link rel="stylesheet" type="text/css" href="/template/wap/public/css/self/reset.css" />
        <link rel="stylesheet" type="text/css" href="/template/wap/css/iconfont.css"/>
        <link rel="stylesheet" type="text/css" href="/template/wap/public/css/libs/swiper-3.4.1.min.css" />
        <link rel="stylesheet" type="text/css" href="/template/wap/public/css/self/custom.css" />
        <link rel="stylesheet" type="text/css" href="/template/wap/css/style.css" />
        <link rel="stylesheet" type="text/css" href="/template/wap/css/frozen.css" />
    </head>
	<body style="background-color: #444444;">
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<!--<div class="container">
			<div class="row order">
				<div class="col-xs-12 order-number">
					我的二维码
				</div>
				<div class="col-xs-12 order-detail" style="text-align: center;">
					<div id="code"></div> 
				</div>
				<div class="col-xs-12 order-price">
					
				</div>
			</div>
		</div>-->
		
		
		<ul class="ui-row ui-whitespace">
               <li class="ui-col ui-col-50">&nbsp;</li>
               <li class="ui-col ui-col-50">&nbsp;</li>
        </ul>
        <ul class="ui-row ui-whitespace">
               <li class="ui-col ui-col-50">&nbsp;</li>
               <li class="ui-col ui-col-50">&nbsp;</li>
        </ul>
        <div class="ewm">
        	<ul class="ui-list ui-border-b">
                <li>
                    <div class="ui-avatar">
                        <span style="background-image:url(<?php echo $_smarty_tpl->tpl_vars['userwxinfo']->value['headimgurl'];?>
)"></span>
                    </div>
                    <div class="ui-list-info">
                        <h4 class="ui-nowrap"><?php echo $_smarty_tpl->tpl_vars['userwxinfo']->value['nickname'];?>
</h4>
                    </div>
                </li>
            </ul>
            <ul class="ui-row ui-whitespace">
                   <li class="ui-col ui-col-50">&nbsp;</li>
                   <li class="ui-col ui-col-50">&nbsp;</li>
            </ul>
            <div class="ui-flex ui-flex-pack-center">
                  <div id="code1"></div> 
            </div>
            
            <ul class="ui-row ui-whitespace">
                <div class="ui-tips ui-tips-success color-bule">
                   <p style="font-size: initial;">人工智能引领驾培未来</p>
                   <p style="font-size: initial;">易点学车定制中国好司机</p>
                </div>
            </ul>
        </div>
        
        <div class="container" id="model">
			<div class="row">
				<div class="modal-body">
					<div>
						<h1 style="font-size: 16px">请输入你的手机号</h1>
						<input type="text" name="phone" id="phone" />
						<input id="btnSendCode" type="button" value="发送验证码" onclick="sendMessage()" />
					</div>
					<div>
						<h1 style="font-size: 16px">请输入你的验证码</h1>
						<input type="text" name="code" id="code" />
					</div>
				</div>
				<div class="modal-btn">
					<a id="banck" href="javascript:$('#model').css('display','none');">返回</a>
					<a href="javascript:visit_code()">确定</a>
				</div>
			</div>
		</div>
		
		<!--<?php echo '<script'; ?>
 src="public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>-->
        <!--<?php echo '<script'; ?>
 src="public/js/self/custom.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>-->
        <?php echo '<script'; ?>
 src="/statics/js/jquery.qrcode.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 src="/statics/js/qrcode.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
        <?php echo '<script'; ?>
 type="text/javascript">
        	$('#code1').qrcode("<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
");
        	$(function(){
		　　var phone1 = '<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
';
				if(phone1=='' || phone1==null) {
					$("#model").css("display","block");
				}
		}); 
			function visit_code() {
				var phone = $("#phone").val();
				var code = $("#code").val();
				$.ajax({
					type:"post",
					url:"/index.php?do=myewm&action=visit",
					async:true,
					data:{phone:phone,code:code},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							alert("绑定成功");
							window.location.href="/index.php?do=myewm";
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
			     　　url: "/index.php?do=myewm&action=send&phone="+phone, //目标地址
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
