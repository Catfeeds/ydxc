;(function($){
	$.fn.extend({
		//  ==================================================
		//  $(element).slide({arrow:false,scrollBar:false,playTime:2000,effectTime:200})
		//  arrow			是否显示上下按钮
		//  playTime		图片显示时间
		//  scrollBar		进度条
		//  effectTime		图片渐隐渐现效果时间
		//  ==================================================
		slide:function(option){
			var option = $.extend($.fn.slide.defaults,option);
			var playTime = parseInt(option.playTime);
			var effectTime = parseInt(option.effectTime);
			var arrow = Boolean(option.arrow);
			var scrollBar = Boolean(option.scrollBar);
			var slide = $(this);
			if(slide.find('li').length <= 1) return true;
			slide.find('li:gt(0)').hide();
			slide.find('li').css({
				'position':'absolute',
				'top':0,
				'left':0,
				'width':'100%'
			});
			var slideEq = 0;
			function slidePlus(){
				slideEq++;
				if(slideEq >= slide.find('li').length) slideEq = 0;
				slideFade();
			}
			function slideMinus(){
				slideEq--;
				if(slideEq <= -1) slideEq = slide.find('li').length-1;
				slideFade();
			}
			function slideScroll(){
				slide.find('#slide-scroll-bar').children().animate({'margin-left':(scrollBarChildrenWidth*slideEq)+'px'},effectTime);
			}
			function slideFade(){
				slide.find('li').fadeOut(effectTime).eq(slideEq).fadeIn(effectTime);
				if(scrollBar) slideScroll();
				console.log('slideEq = ' + slideEq);
			}
			var slideTimer = setInterval(slidePlus,playTime);
			slide.mouseover(function(){
				clearInterval(slideTimer);
			});
			slide.mouseleave(function(){
				slideTimer = setInterval(slidePlus,playTime);
			});
			if(scrollBar){
				var scrollBarHtml = '<div id="slide-scroll-bar"><div></div></div>';
					slide.append(scrollBarHtml);
				slide.find('#slide-scroll-bar').css({
					'position':'absolute',
					'bottom':'3%',
					'left':'20%',
					'overflow':'hidden',
					'width':'60%',
					'background':'rgba(255,255,255,.8)'
				});
				var scrollBarChildrenWidth = Math.round(slide.find('#slide-scroll-bar').width() / slide.find('li').length);
				slide.find('#slide-scroll-bar').children().css({
					'display':'block',
					'width':scrollBarChildrenWidth+'px',
					'height':'3px',
					'background':'#3aac3a'
				});
			}
			if(arrow){
				var arrowHtml = '<a href="javascript:void(0)" class="prev"><</a>';
					arrowHtml += '<a href="javascript:void(0)" class="next">></a>';
				slide.append(arrowHtml);
				slide.find('.prev,.next').css({
					'position':'absolute',
					'top':'40%',
					'z-index':'11',
					'display':'none',
//					'width':'5%',
//					'height':'20%',
					'padding':'10px 8px',
					'background':'rgba(0,0,0,.4)',
					'overflow':'hidden',
					'font-size':'35px',
					'color':'rgba(255,255,255,.25)'
				});
				slide.find('.prev').css({
					'left':'0',
					'border-radius':'0 5px 5px 0'
				});
				slide.find('.next').css({
					'right':'0',
					'border-radius':'5px 0 0 5px'
				});
				slide.hover(function(){
					slide.find('.prev,.next').fadeIn(150);
				},function(){
					slide.find('.prev,.next').fadeOut(150);
				});
				slide.find('.prev').on('click',function(){
					slideMinus();
				});
				slide.find('.next').on('click',function(){
					slidePlus();
				});
			}
		}
	});
	$.fn.slide.defaults = {
		arrow:false,
		scrollBar:false,
		playTime:2000,
		effectTime:200
	};
})(jQuery);