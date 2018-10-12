/**
 * Created by Administrator on 2016/7/4 0004.
 */
$(function(){
	alert()
	//导航
    $(".nav div").mousemove(function(){
        $(this).addClass("active");
        $(this).siblings(".dh").removeClass("active");
        $(this).siblings(".dh").addClass("dh");
    })
    $(".nav div ul li").mousemove(function(){
        $(this).addClass("on");
        $(this).siblings().removeClass("on");
    })
    //banner
    //初始化
    var y=1;
    $(".banner_img li").eq(0).siblings().addClass("yc");
    $(".banner_xz li").eq(0).addClass("yuan_lan").siblings().addClass("yuan_bai");

    var h=setInterval(function(){
        xianshi(y);
        xiaodian(y);
        y++;
        //最大图片数
        var length = $(".banner_img li").length;
        if(y==length){
            y=0;
        }
    },2500);

    $(".banner_xz li").each(function(index){
        $(this).hover(function(){
            xiaodian(index);
            xianshi(index);
            if(h){
                clearInterval(h);
            }
        },function(){
            h=setInterval(function(){
                xianshi(y);
                xiaodian(y);
                y++;
                if(y==4){
                    y=0;
                }
            },2500);
        });
    });
    //banner结束
    //首页提交框关闭
    $(".guanbi").click(function(){
        $(".fdbm").addClass("yc");
    })
})
//banner切换事件
function xianshi(x){
    $(".banner_img li").eq(x).fadeIn(600);
    $(".banner_img li").eq(x).siblings().css("display","none");
    y=x;
}
//banner指示标切换事件
function xiaodian(z){
    $(".banner_xz li").eq(z).attr("class","yuan_lan");
    $(".banner_xz li").eq(z).siblings().attr("class","yuan_bai");
}