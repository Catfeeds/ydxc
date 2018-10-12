// JavaScript Document

$(function(){

	//滑动翻页
	var page = 1;
	var IsNext = true;
	if($(".view_list_box").length){
		$(document).ready(function () {
			$(window).scroll(function () {
				var tops = parseFloat($(window).height()) + parseFloat($(window).scrollTop()) + 380; //320
				var h = $(document).height();
				//h = $(document.body).height()*page;
				var w = tops - h;
				if (IsNext && w >= 0) {
					if (IsNext) page++;
					foodlist(page);
				}
			});
			foodlist(0);
		});
	}
	
	

});
	
	


//滑动翻页 函数
function foodlist(Page) { 
	//var li_wid = $(window).width()*0.47;
	
	IsNext = false; 
	//$(".load_more").html("<span><img src=\"image/load.gif\"></span>正在加载更多...").show();
	$.ajax( 
	{ type: "post",
		dataType: "json",
		url: window.location.href+"&ajax=1&page=" + Page ,
		//data: "&keywords="+$("input[name=keywords]").val(),
		data: {"keywords": $("input[name=keywords]").val()},
		async: true,
		timeout: 10000,
		success: function (msg) {
			var list = eval(msg);
			var foodtemp = "";
			//alert(Page);
			//if (list.length != 0 && msg != "0") {
			if (list.list != null && list.list != '') {
				
				var html = template('showlist',msg);
				$(".view_list_box").append(html);
				//$(".view_list_box img").lazyload({ placeholder: "images/logo2.png", effect: "fadeIn" });
				IsNext = true;
				$(".load_more").hide();
			} else {
				
				//$(".load_more").html("无更多信息").show();
				if(Page==0){
					$(".null_box").show();
					$(".load_more").hide();
				}
				IsNext = false;
			}
		}, error: function (XMLHttpRequest, status) {
			
			$(".load_more").html("读取数据超时，请刷新本页面").show();
		}
	});
	

}


