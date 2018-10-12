<?php
/* Smarty version 3.1.30, created on 2018-08-26 18:28:41
  from "/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist_order.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5b82f1591c9498_06074707',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd90268b074165ec12c15502f970be6149c1caf67' => 
    array (
      0 => '/usr/share/nginx/html/ydxc/ydxc/template/wap/enlist_order.html',
      1 => 1535307980,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
  ),
),false)) {
function content_5b82f1591c9498_06074707 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<body>
		<!--[if lt IE 9]>对不起，浏览器版本太低~！<![endif]-->
		<div class="container">
			<div class="row genre">
				<h1 class="col-xs-12">学车类型</h1>
				<div class="col-xs-12 ">
					<p class="left"><?php echo $_smarty_tpl->tpl_vars['courseshow']->value['name'];?>
</p>
					<span class="right"><?php echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];?>
</span>
				</div>			
			</div>
			
			<div class="row site">
				<h1 class="col-xs-12">场地地址</h1>
				<div class="col-xs-12">
					<h2><?php echo $_smarty_tpl->tpl_vars['sscd']->value['title'];?>
</h2>
					<p><?php echo $_smarty_tpl->tpl_vars['sscd']->value['cd_address'];?>
</p>
				</div>
			</div>
			
			<div class="row genre">
				<h1 class="col-xs-12">所选教练</h1>
				<div class="col-xs-12 ">
					<p><?php echo $_smarty_tpl->tpl_vars['coach_info']->value['xingming'];?>
</p>
				</div>			
			</div>
			
			<div class="row genre">
				<h1 class="col-xs-12">推荐人</h1>
				<div class="col-xs-12 ">
					<?php if (empty($_smarty_tpl->tpl_vars['_SESSION']->value['yqopenid'])) {?>
					<p>无</p>
					<?php } else { ?>
					<p><?php echo $_smarty_tpl->tpl_vars['inv']->value['name'];?>
</p>
					<?php }?>
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
								<input type="text" name="data[phone]" id="phone"  value="<?php echo $_smarty_tpl->tpl_vars['wx_user']->value['phone'];?>
" placeholder="请输入手机号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[card_id]" id="card_id"  value="" placeholder="请输入身份证号" />
							</label>
						</div>
						<div>
							<label for="">
								<input type="text" name="data[school]" id="school"  value="" placeholder="请输入详细地址（学校）" />
							</label>
						</div>
						<input type="hidden" name="data[coach_id]" id="coach_id" value="<?php echo $_smarty_tpl->tpl_vars['coach']->value;?>
" />
						<input type="hidden" name="data[coach_km]" id="coach_km" value="<?php echo $_smarty_tpl->tpl_vars['coach_info']->value['kemu'];?>
" />
						<input type="hidden" name="data[inv]" id="inv" value="<?php echo $_smarty_tpl->tpl_vars['inv']->value['id'];?>
" />
						<input type="hidden" name="data[zd_price]" id="zd_price" value="<?php echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];?>
" />
					</div>
				</div>
			</form>
			
			<div class="row protocol">
				<div class="col-xs-12">
					<label>
						<input type="checkbox" checked="checked" name="" id="xy" value="" />
						本人已阅读并签署易点学车<a href="/index.php?do=pxxy">《培训协议》</a>（电子协议与纸质协议具有同等法律效益)
					</label>					
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
				<a class="col-xs-8 enroll-btn" id="pay" href="javascript:transform_order();">支付</a>
			</div>
			
		</div>
		
	</body>
    <?php echo '<script'; ?>
 src="/client/public/js/libs/jquery-2.2.3.min.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
 src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript" charset="utf-8"><?php echo '</script'; ?>
>
	<?php echo '<script'; ?>
>
		
		
		
	function sendMessage() {
//		var phone = '<?php echo $_smarty_tpl->tpl_vars['coach_info']->value['coach_phone'];?>
';
		var phone1 = '18580967515';
	　　  //向后台发送处理数据
	     $.ajax({
	     　　type: "POST", //用POST方式传输
	     　　dataType: "json", //数据格式:JSON
	     　　url: "/index.php?do=k2_msg&action=send&phone="+phone1, //目标地址
	    　　 error: function (XMLHttpRequest, textStatus, errorThrown) { },
	     　　success: function (msg){alert(phone1); }
	     });
	}
	
	function transform_order(){
		
		var name = $('#uname').val().trim();
		var phone = $('#phone').val().trim();
		var card_id = $('#card_id').val().trim();
		var school = $('#school').val().trim();
		var class_id = <?php echo $_smarty_tpl->tpl_vars['courseshow']->value['id'];?>
;
		var money = <?php echo $_smarty_tpl->tpl_vars['courseshow']->value['zd_price'];?>
;
		if(!$('#xy').is(':checked')){
			alert("请阅读并同意协议");
			return false;
		}
		if(""==name||""==phone||""==card_id){
			alert("请填写完整");
			return false;
		} else {
			$.ajax({
				type:"POST",
				url:"/index.php?do=pay&class="+class_id+"&money="+money,
				data:$("#sign_form").serialize(),
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
							var link = "http://ydxctrue.yidianxueche.cn";
							var imgUrl = "http://ydxctrue.yidianxueche.cn";
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
											 	//sendMessage();
											 	window.location.href = "/index.php?do=enlist_pay_success&phone=<?php echo $_smarty_tpl->tpl_vars['coach_info']->value['coach_phone'];?>
";
									       },
									        cencel:function(res){　　　　　　　　　　　　　　// 支付取消回调函数
											// console.log('cencel');console.log(res);	
											window.location.href = "/index.php?do=enlist_pay_fail";
									        },
									        fail: function(res){　　　　　　　　　　　　　　// 支付失败回调函数
											//console.log('fail'); console.log(res);	
											window.location.href = "/index.php?do=enlist_pay_fail";
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
	<?php echo '</script'; ?>
>
</html>
<?php }
}
