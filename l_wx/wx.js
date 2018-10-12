
document.write('<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>');
$(function () {

	getwxpz();
});
//微信配置
function getwxpz() {
		$.ajax({
		type: 'GET',
		url: '/l_wx/wxinfo.php?method=getwxjs',
		dataType: 'json',
		success: function(data){
			//alert(data);
			if (1 == data.code) {
            		wx.config({
				    debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
				    appId:     data.content.appId, // 必填，公众号的唯一标识
				    timestamp: data.content.timestamp, // 必填，生成签名的时间戳
				    nonceStr: data.content.nonceStr, // 必填，生成签名的随机串
				    signature: data.content.signature,// 必填，签名，见附录1
				    jsApiList: ['onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
				});
				var title = "分享至朋友圈可查看击败全国多少其他家庭，还可领取同远7.28亲子节大礼包哦，GO!";
				var link = "http://aqeyzdf.yooyor.com/client/share.html";
				var imgUrl = "http://aqeyzdf.yooyor.com/client/public/css/self/image/home-banner.jpg";
				var desc = "分享至朋友圈可查看击败全国多少其他家庭，还可领取同远7.28亲子节大礼包哦，GO!";
				var type = "";
				var dataUrl = "";
            		wx.ready(function(){
            			wx.onMenuShareTimeline({
					    title: title, // 分享标题
					    link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: imgUrl, // 分享图标
					    success: function () {
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () {
					        // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareAppMessage({
					    title: title, // 分享标题
					    desc: desc, // 分享描述
					    link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
					    imgUrl: imgUrl, // 分享图标
					    type: type, // 分享类型,music、video或link，不填默认为link
					    dataUrl: dataUrl, // 如果type是music或video，则要提供数据链接，默认为空
					    success: function () {
					        // 用户确认分享后执行的回调函数
					    },
					    cancel: function () {
					        // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareQQ({
					    title: title, // 分享标题
					    desc: desc, // 分享描述
					    link: link, // 分享链接
					    imgUrl: imgUrl, // 分享图标
					    success: function () {
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () {
					       // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareWeibo({
					    title: title, // 分享标题
					    desc: desc, // 分享描述
					    link: link, // 分享链接
					    imgUrl: imgUrl, // 分享图标
					    success: function () {
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () {
					        // 用户取消分享后执行的回调函数
					    }
					});
					wx.onMenuShareQZone({
					    title: title, // 分享标题
					    desc: desc, // 分享描述
					    link: link, // 分享链接
					    imgUrl: imgUrl, // 分享图标
					    success: function () {
					       // 用户确认分享后执行的回调函数
					    },
					    cancel: function () {
					        // 用户取消分享后执行的回调函数
					    }
					});
            		});
			} else {
				//alert('系统繁忙！稍后再试！');
			}
		},
		error:function(data) {
			//layer.msg('删除失败!',{icon:1,time:1000});;
		},
	});
}