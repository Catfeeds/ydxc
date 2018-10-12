


$(function(){
/*	$(".focus .img li").eq(0).show();
	$(".focus .btn li").eq(0).addClass("li");
	var focus_li = $(".focus .img li")
	var btn_li = $(".focus .btn li")*/
	$(".ban_cen a").eq(0).children("img").show();
	var i = 0;
	function Focus(a){
		$(".ban_cen a").eq(a).children("img").fadeIn("show").parent("a").siblings().children("img").fadeOut("show");
		//$(".focus .btn li").eq(a).addClass("li").siblings().removeClass("li");
	}
	function focus_img(){
		if(i<$(".ban_cen a").index()){
			i++;
		}else{
			i = 0;
		}
		Focus(i);
	}
	$(".ban_cen a").mouseover(function(){
		i = $(this).index();
		Focus(i);
		clearInterval(setFocus)
	}).mouseout(function(){setFocus = setInterval(focus_img,4000);})
	var setFocus = setInterval(focus_img,4000);
	
	var kll_li = $(".img_show1 div ul.ul_show li");
	var kll_ul = $(".img_show1 div ul.ul_show");
	if(kll_li.index() > 3){//判断显示区域是否有超出（是否填满）
		for(var k = 0; k<4; k++){//在末尾追加前三个（显示区域一次只能显示三个）
			var kll_lihtm = kll_li.eq(k).html();//循环获取
			kll_ul.append("<li>"+kll_lihtm+"</li>");//追加
		};
	};
	kll_ul.width(($(".img_show1 div ul.ul_show li").index()+1)*257);//初始设置ul宽度，根据li个数改变
	var p2_btnL = $(".img_show1 img.i1");//往左点击
	var p2_btnR = $(".img_show1 img.i2");//往右点击
	var p2 = 0;//初始移动次数
	p2_btnR.click(function(){//触发click
		if(!kll_ul.is(":animated") ){//判断目前是否处于运动状态(!表示不是，所以执行{}里面代码)
			if(kll_li.index() > 2){//判断个数超出显示在点击滑动显示
				p2++;//记录点击次数
				kll_ul.animate({left:-257*p2},400,function(){//给出运动方式animate
					if(p2>$(this).children("li").index()-4){//运动完成后判断是否运动到最后一个位置
						//alert("到最后了");
						
						p2 = 0;
						$(this).animate({left:-257*p2},0);//还原到第一个位置（最后位置第一位置相同，所以看着就像循环滚动了）
					}
				});
			}
		}
		clearInterval(set_brand);
		set_brand = setInterval(brand_show,3000)
		//alert(1);
	});
	p2_btnL.click(function(){
		if(!kll_ul.is(":animated") ){
			if(p2 > 0){
				p2--;
			}else{
			}
			kll_ul.animate({left:-257*p2},400);
		}
		clearInterval(set_brand);
		set_brand = setInterval(brand_show,3000)
	});
	
	function brand_show(){
		p2++;
		kll_ul.animate({left:-257*p2},400,function(){
			if(p2>$(this).children("li").index()-4){
				p2 = 0;
				$(this).animate({left:-257*p2},0);
			}
		});
	};
	if(kll_li.index() > 3){
		var set_brand = setInterval(brand_show,3000)
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	var kll_li1 = $(".img_show2 div ul.ul_show li");
	var kll_ul1 = $(".img_show2 div ul.ul_show");
	if(kll_li1.index() > 3){//判断显示区域是否有超出（是否填满）
		for(var k = 0; k<4; k++){//在末尾追加前三个（显示区域一次只能显示三个）
			var kll_li1htm = kll_li1.eq(k).html();//循环获取
			kll_ul1.append("<li>"+kll_li1htm+"</li>");//追加
		};
	};
	kll_ul1.width(($(".img_show2 div ul.ul_show li").index()+1)*257);//初始设置ul宽度，根据li个数改变
	var p3_btnL1 = $(".img_show2 img.i1");//往左点击
	var p3_btnR1 = $(".img_show2 img.i2");//往右点击
	var p3 = 0;//初始移动次数
	p3_btnR1.click(function(){//触发click
		if(!kll_ul1.is(":animated") ){//判断目前是否处于运动状态(!表示不是，所以执行{}里面代码)
			if(kll_li1.index() > 2){//判断个数超出显示在点击滑动显示
				p3++;//记录点击次数
				kll_ul1.animate({left:-257*p3},400,function(){//给出运动方式animate
					if(p3>$(this).children("li").index()-4){//运动完成后判断是否运动到最后一个位置
						//alert("到最后了");
						
						p3 = 0;
						$(this).animate({left:-257*p3},0);//还原到第一个位置（最后位置第一位置相同，所以看着就像循环滚动了）
					}
				});
			}
		}
		clearInterval(set_brand1);
		set_brand1 = setInterval(brand_show1,3000)
		//alert(1);
	});
	p3_btnL1.click(function(){
		if(!kll_ul1.is(":animated") ){
			if(p3 > 0){
				p3--;
			}else{
			}
			kll_ul1.animate({left:-257*p3},400);
		}
		clearInterval(set_brand1);
		set_brand1 = setInterval(brand_show1,3000)
	});
	
	function brand_show1(){
		p3++;
		kll_ul1.animate({left:-257*p3},400,function(){
			if(p3>$(this).children("li").index()-4){
				p3 = 0;
				$(this).animate({left:-257*p3},0);
			}
		});
	};
	if(kll_li1.index() > 3){
		var set_brand1 = setInterval(brand_show1,3000)
	}

})
// 设置为主页
function gSetHomePage(obj,vrl){ 
	try{ 
		obj.style.behavior='url(#default#homepage)';obj.setHomePage(vrl); 
	} 
	catch(e){ 
		if(window.netscape) { 
			try { 
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect"); 
			} 
			catch (e) { 
				alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入“about:config”并回车\n然后将 [signed.applets.codebase_principal_support]的值设置为'true',双击即可。"); 
			} 
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
			prefs.setCharPref('browser.startup.homepage',vrl); 
		}else{ 
			alert("您的浏览器不支持，请按照下面步骤操作：1.打开浏览器设置。2.点击设置网页。3.输入："+vrl+"点击确定。"); 
		} 
	} 
} 
// 加入收藏 兼容360和IE6 
function gAddFav(sURL, sTitle) { 
	try  { 
		window.external.addFavorite(sURL, sTitle); 
	} 
	catch (e) { 
		try 
		{ 
			window.sidebar.addPanel(sTitle, sURL, ""); 
		} 
		catch (e) { 
			alert("加入收藏失败，请使用Ctrl+D进行添加"); 
		} 
	} 
} 