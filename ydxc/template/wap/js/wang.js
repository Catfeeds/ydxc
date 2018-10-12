/**
 * Created by Administrator on 2016/7/4 0004.
 */
$(function(){
	//顶部返回
	//$(".left").click(function(){history.back()});
	//返回首页
	$(".icon-home").click(function(){window.location.href='index.php?do=index';});
	
	
	//提交表单 
	$(".submit_post").click(function() { 
		
		var _form = $(this).parents("form");
        if (!Validator.Validate(document.forms[_form.attr("name")],2)) {
			return false;
		}
		
		$.post(_form.prop("action"), _form.serialize(), function(data){
				if (data.error) {	
					alerterr(data.error);
					return false;
				}
				if (data.ok) {
					alertok(data.ok);
				}
				if (data.jumpto) {		
					window.setTimeout("location.href = '" + data.jumpto + "'", 1000);					
				}
				//清空表单下的所有输入框的值
				var isclear = _form.data("isclear");
				if (isclear != undefined) {
					_form.find('input[type=text], textarea, input[type=password]').val('');
				}
				//alert(data);
			},
			"json");
		return false; //防止表格submit类型按钮提交表单
	});
})
