


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
	if(kll_li.index() > 3){//�ж���ʾ�����Ƿ��г������Ƿ�������
		for(var k = 0; k<4; k++){//��ĩβ׷��ǰ��������ʾ����һ��ֻ����ʾ������
			var kll_lihtm = kll_li.eq(k).html();//ѭ����ȡ
			kll_ul.append("<li>"+kll_lihtm+"</li>");//׷��
		};
	};
	kll_ul.width(($(".img_show1 div ul.ul_show li").index()+1)*257);//��ʼ����ul��ȣ�����li�����ı�
	var p2_btnL = $(".img_show1 img.i1");//������
	var p2_btnR = $(".img_show1 img.i2");//���ҵ��
	var p2 = 0;//��ʼ�ƶ�����
	p2_btnR.click(function(){//����click
		if(!kll_ul.is(":animated") ){//�ж�Ŀǰ�Ƿ����˶�״̬(!��ʾ���ǣ�����ִ��{}�������)
			if(kll_li.index() > 2){//�жϸ���������ʾ�ڵ��������ʾ
				p2++;//��¼�������
				kll_ul.animate({left:-257*p2},400,function(){//�����˶���ʽanimate
					if(p2>$(this).children("li").index()-4){//�˶���ɺ��ж��Ƿ��˶������һ��λ��
						//alert("�������");
						
						p2 = 0;
						$(this).animate({left:-257*p2},0);//��ԭ����һ��λ�ã����λ�õ�һλ����ͬ�����Կ��ž���ѭ�������ˣ�
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
	if(kll_li1.index() > 3){//�ж���ʾ�����Ƿ��г������Ƿ�������
		for(var k = 0; k<4; k++){//��ĩβ׷��ǰ��������ʾ����һ��ֻ����ʾ������
			var kll_li1htm = kll_li1.eq(k).html();//ѭ����ȡ
			kll_ul1.append("<li>"+kll_li1htm+"</li>");//׷��
		};
	};
	kll_ul1.width(($(".img_show2 div ul.ul_show li").index()+1)*257);//��ʼ����ul��ȣ�����li�����ı�
	var p3_btnL1 = $(".img_show2 img.i1");//������
	var p3_btnR1 = $(".img_show2 img.i2");//���ҵ��
	var p3 = 0;//��ʼ�ƶ�����
	p3_btnR1.click(function(){//����click
		if(!kll_ul1.is(":animated") ){//�ж�Ŀǰ�Ƿ����˶�״̬(!��ʾ���ǣ�����ִ��{}�������)
			if(kll_li1.index() > 2){//�жϸ���������ʾ�ڵ��������ʾ
				p3++;//��¼�������
				kll_ul1.animate({left:-257*p3},400,function(){//�����˶���ʽanimate
					if(p3>$(this).children("li").index()-4){//�˶���ɺ��ж��Ƿ��˶������һ��λ��
						//alert("�������");
						
						p3 = 0;
						$(this).animate({left:-257*p3},0);//��ԭ����һ��λ�ã����λ�õ�һλ����ͬ�����Կ��ž���ѭ�������ˣ�
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
// ����Ϊ��ҳ
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
				alert("�˲�����������ܾ���\n�����������ַ�����롰about:config�����س�\nȻ�� [signed.applets.codebase_principal_support]��ֵ����Ϊ'true',˫�����ɡ�"); 
			} 
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch); 
			prefs.setCharPref('browser.startup.homepage',vrl); 
		}else{ 
			alert("�����������֧�֣��밴�����沽�������1.����������á�2.���������ҳ��3.���룺"+vrl+"���ȷ����"); 
		} 
	} 
} 
// �����ղ� ����360��IE6 
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
			alert("�����ղ�ʧ�ܣ���ʹ��Ctrl+D�������"); 
		} 
	} 
} 