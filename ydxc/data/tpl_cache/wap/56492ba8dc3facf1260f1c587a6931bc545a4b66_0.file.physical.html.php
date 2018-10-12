<?php
/* Smarty version 3.1.30, created on 2018-09-07 07:55:38
  from "/usr/share/nginx/html/ydxctrue/ydxc/template/wap/physical.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b922efad00db6_96893903',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '56492ba8dc3facf1260f1c587a6931bc545a4b66' => 
    array (
      0 => '/usr/share/nginx/html/ydxctrue/ydxc/template/wap/physical.html',
      1 => 1536306564,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5b922efad00db6_96893903 (Smarty_Internal_Template $_smarty_tpl) {
?>
	<div class="container   " style="background-color: #FFFFFF;">
		
		<div class="row">
				<div class="col-xs-12">
					<a class="map-dh" <?php if (!empty($_smarty_tpl->tpl_vars['cd_info']->value['id'])) {?> href="/index.php?do=go&id=<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
"<?php }?>>
							<i class="iconfont icon-quzheli"></i>
							<p>到这里</p>
					</a>
				</div>
		</div>
		
		<form method="post" name="tj_code_form" id="tj_code_form">
				<div class="row data">
					<div class="col-xs-12">
						<div>
							<label for="">
								<input type="text" name="data[uname]" id="uname"  value="" placeholder="请输入姓名" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[phone]" id="phone1"  value="<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
" placeholder="请输入手机号" />
							</label>
						</div>
						<div>
							<a>
								<div><?php echo $_smarty_tpl->tpl_vars['cd_info']->value['title'];?>
 <?php echo $_smarty_tpl->tpl_vars['cd_info']->value['cd_address'];?>
</div>
								<input type="hidden" name="data[tjz_id]" id="tjz_id" value="<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['id'];?>
" />
								<!--<i></i>-->
							</a>
						</div>
					</div>
				</div>
				
				<div class="container" id="model" style="z-index: 1;">
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
			

			
			<div class="row explain">
				<p class="col-xs-12">*说明：申请后您会收到体检码，请携带体检码和身份证到所选择的体检站进行体检</p>
			</div>
			
			<div class="row" style="padding-left: 15px;padding-right: 15px; margin-top:20px ;overflow:scroll ; height: 20px;">
				<?php echo $_smarty_tpl->tpl_vars['cd_info']->value['content'];?>

			</div>
			
			<div class="kong row"></div>
			
				<a href="javascript:transform_order();" class="row application-btn" style="color: #FFFFFF;">申请体检</a>
				<!--<input type="submit" class="row application-btn" value="申请体检" style="border: 0;background-color: #22A7F0;color: #ffffff;" />-->
			
		</div>                      
		
	<?php echo '<script'; ?>
 type="text/javascript">
	function transform_order(){
		var uname = $("#uname").val().trim();
		var phone1 = $("#phone1").val().trim();
		var tjz_id = $("#tjz_id").val();
		var phone = '<?php echo $_smarty_tpl->tpl_vars['weixin']->value['phone'];?>
';
		if(""==uname||""==phone1||""==tjz_id){
			alert("请填写完整");
			return false;
		} else if(phone=='' || phone==null) {
					$("#model").css("display","block");
					return false;
		} else {
			if(<?php echo $_smarty_tpl->tpl_vars['have_code']->value;?>
==0){
				alert("该体检站体检码已经用完，请和管理员进行联系");
			} else {
				$.ajax({
					type:"POST",
					url:"/index.php?do=pay&tj=1&money=20",
					data:$("#tj_code_form").serialize(),
					dataType:"json",
					success: function (data) {
						if (1 == data.code) {
				            		wx.config({
								    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
								    appId:     data.content.appId, // 必填，公众号的唯一标识
								    timestamp: data.content.timestamp, // 必填，生成签名的时间戳
								    nonceStr: data.content.nonceStr, // 必填，生成签名的随机串
								    signature: data.content.signature,// 必填，签名，见附录1
								    jsApiList: ['chooseWXPay'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
								});
								var title = "易点学车";
								var link = "http:/ydxctrue.yidianxueche.cn/client/";
								var imgUrl = "http:/ydxctrue.yidianxueche.cn/client/";
								var desc = "易点学车";
								var type = "";
								var dataUrl = "";
				            		wx.ready(function(){
	
									wx.chooseWXPay({
									           appId : data.content.appId ,     //公众号名称，由商户传入
									           timestamp :  data.content.timestamp,         //时间戳，自1970年以来的秒数
									           nonceStr : data.content.nonceStr, //随机串
									           package : data.content.package,
									           signType : "MD5",         //微信签名方式：
									           paySign : data.content.paySign, //微信签名
										       success: function (res){
												 	//alert(res.msg);
												 	window.location.href = "/index.php?do=physical_pay_success";
										       },
										        cencel:function(res){　　　　　　　　　　　　　　// 支付取消回调函数
												 	window.location.href = "/index.php?do=physical_pay_fail";
										        },
										        fail: function(res){　　　　　　　　　　　　　　// 支付失败回调函数
												 	window.location.href = "/index.php?do=physical_pay_fail";
										        }
									});
				            		});
				            		
								localStorage.hurl = "";
							} else {
								localStorage.hurl = window.location.href;
								window.location.href="/index.php?do=getwxinfo";
							}
					}
				});
			}
		}
	}
	
	function visit_code() {
				var phone = $("#phone").val();
				var code = $("#code").val();
				$.ajax({
					type:"post",
					url:"/index.php?do=physical&action=visit",
					async:true,
					data:{phone:phone,code:code},
					dataType:"json",
					success:function(data) {
						if(data.status==1) {
							window.location.href = "/index.php?do=xlc_map&tj=1";
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
     　　url: "/index.php?do=physical&action=send&phone="+phone, //目标地址
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
<?php }
}
