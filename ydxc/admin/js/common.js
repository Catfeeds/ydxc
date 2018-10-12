/*
	[Discuz!] (C)2001-2009 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: common.js 17449 2008-12-22 08:58:53Z cnteacher $
*/

var lang = new Array();
var userAgent = navigator.userAgent.toLowerCase();
var is_opera = userAgent.indexOf('opera') != -1 && opera.version();
var is_moz = (navigator.product == 'Gecko') && userAgent.substr(userAgent.indexOf('firefox') + 8, 3);
var is_ie = (userAgent.indexOf('msie') != -1 && !is_opera) && userAgent.substr(userAgent.indexOf('msie') + 5, 3);

//FixPrototypeForGecko
if(is_moz && window.HTMLElement) {
	HTMLElement.prototype.__defineSetter__('outerHTML', function(sHTML) {
        	var r = this.ownerDocument.createRange();
		r.setStartBefore(this);
		var df = r.createContextualFragment(sHTML);
		this.parentNode.replaceChild(df,this);
		return sHTML;
	});

	HTMLElement.prototype.__defineGetter__('outerHTML', function() {
		var attr;
		var attrs = this.attributes;
		var str = '<' + this.tagName.toLowerCase();
		for(var i = 0;i < attrs.length;i++){
			attr = attrs[i];
			if(attr.specified)
			str += ' ' + attr.name + '="' + attr.value + '"';
		}
		if(!this.canHaveChildren) {
			return str + '>';
		}
		return str + '>' + this.innerHTML + '</' + this.tagName.toLowerCase() + '>';
        });

	HTMLElement.prototype.__defineGetter__('canHaveChildren', function() {
		switch(this.tagName.toLowerCase()) {
			case 'area':case 'base':case 'basefont':case 'col':case 'frame':case 'hr':case 'img':case 'br':case 'input':case 'isindex':case 'link':case 'meta':case 'param':
			return false;
        	}
		return true;
	});
	HTMLElement.prototype.click = function(){
		var evt = this.ownerDocument.createEvent('MouseEvents');
		evt.initMouseEvent('click', true, true, this.ownerDocument.defaultView, 1, 0, 0, 0, 0, false, false, false, false, 0, null);
		this.dispatchEvent(evt);
	}
}

Array.prototype.push = function(value) {
	this[this.length] = value;
	return this.length;
}

// 仿jquery
function _$(id) {
	return document.getElementById(id);
}

// 下面菜单函数中也有调用
function doane(event) {
	e = event ? event : window.event;
	if(is_ie) {
		e.returnValue = false;
		e.cancelBubble = true;
	} else if(e) {
		e.stopPropagation();
		e.preventDefault();
	}
}

// 下面菜单函数中也有调用
function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function strlen(str) {
	return (is_ie && str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
}

function trim(str) {
	return (str + '').replace(/(\s+)$/g, '').replace(/^\s+/g, '');
}

// 下面菜单函数中也有调用
function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

// 菜单页面调用函数
function _attachEvent(obj, evt, func, eventobj) {
	eventobj = !eventobj ? obj : eventobj;
	if(obj.addEventListener) {
		obj.addEventListener(evt, func, false);
	} else if(eventobj.attachEvent) {
		obj.attachEvent("on" + evt, func);
	}
}

///显示菜单----------------------
var jsmenu = new Array();
var ctrlobjclassName;
jsmenu['active'] = new Array();
jsmenu['timer'] = new Array();
jsmenu['iframe'] = new Array();

function initCtrl(ctrlobj, click, duration, timeout, layer) {
	if(ctrlobj && !ctrlobj.initialized) {
		ctrlobj.initialized = true;
		ctrlobj.unselectable = true;

		ctrlobj.outfunc = typeof ctrlobj.onmouseout == 'function' ? ctrlobj.onmouseout : null;
		ctrlobj.onmouseout = function() {
			if(this.outfunc) this.outfunc();
			if(duration < 3 && !jsmenu['timer'][ctrlobj.id]) jsmenu['timer'][ctrlobj.id] = setTimeout('hideMenu(' + layer + ')', timeout);
		}

		ctrlobj.overfunc = typeof ctrlobj.onmouseover == 'function' ? ctrlobj.onmouseover : null;
		ctrlobj.onmouseover = function(e) {
			doane(e);
			if(this.overfunc) this.overfunc();
			if(click) {
				clearTimeout(jsmenu['timer'][this.id]);
				jsmenu['timer'][this.id] = null;
			} else {
				for(var id in jsmenu['timer']) {
					if(jsmenu['timer'][id]) {
						clearTimeout(jsmenu['timer'][id]);
						jsmenu['timer'][id] = null;
					}
				}
			}
		}
	}
}

var menudragstart = new Array();
function menudrag(menuobj, e, op) {
	if(op == 1) {
		if(in_array(is_ie ? event.srcElement.tagName : e.target.tagName, ['TEXTAREA', 'INPUT', 'BUTTON', 'SELECT'])) {
			return;
		}
		menudragstart = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
		menudragstart[2] = parseInt(menuobj.style.left);
		menudragstart[3] = parseInt(menuobj.style.top);
		doane(e);
	} else if(op == 2 && menudragstart[0]) {
		var menudragnow = is_ie ? [event.clientX, event.clientY] : [e.clientX, e.clientY];
		menuobj.style.left = (menudragstart[2] + menudragnow[0] - menudragstart[0]) + 'px';
		menuobj.style.top = (menudragstart[3] + menudragnow[1] - menudragstart[1]) + 'px';
		doane(e);
	} else if(op == 3) {
		menudragstart = [];
		doane(e);
	}
}

function hideMenu(layer) {
	if(isUndefined(layer)) layer = 0;
	if(jsmenu['active'][layer]) {
		try {
			_$(jsmenu['active'][layer].ctrlkey).className = ctrlobjclassName;
		} catch(e) {}
		clearTimeout(jsmenu['timer'][jsmenu['active'][layer].ctrlkey]);
		jsmenu['active'][layer].style.display = 'none';
		if(is_ie && is_ie < 7 && jsmenu['iframe'][layer]) {
			jsmenu['iframe'][layer].style.display = 'none';
		}
		jsmenu['active'][layer] = null;
	}
}

function fetchOffset(obj) {
	var left_offset = obj.offsetLeft;
	var top_offset = obj.offsetTop;
	while((obj = obj.offsetParent) != null) {
		left_offset += obj.offsetLeft;
		top_offset += obj.offsetTop;
	}
	return { 'left' : left_offset, 'top' : top_offset };
}

function setMenuPosition(showid, offset) {
	var showobj = _$(showid);
	var menuobj = _$(showid + '_menu');
	if(isUndefined(offset)) offset = 0;
	if(showobj) {
		showobj.pos = fetchOffset(showobj);
		showobj.X = showobj.pos['left'];
		showobj.Y = showobj.pos['top'];
		if(_$(InFloat) != null) {
			var InFloate = InFloat.split('_');
			if(!floatwinhandle[InFloate[1] + '_1']) {
				floatwinnojspos = fetchOffset(_$('floatwinnojs'));
				floatwinhandle[InFloate[1] + '_1'] = floatwinnojspos['left'];
				floatwinhandle[InFloate[1] + '_2'] = floatwinnojspos['top'];
			}
			showobj.X = showobj.X - _$(InFloat).scrollLeft - parseInt(floatwinhandle[InFloate[1] + '_1']);
			showobj.Y = showobj.Y - _$(InFloat).scrollTop - parseInt(floatwinhandle[InFloate[1] + '_2']);
			InFloat = '';
		}
		showobj.w = showobj.offsetWidth;
		showobj.h = showobj.offsetHeight;
		menuobj.w = menuobj.offsetWidth;
		menuobj.h = menuobj.offsetHeight;
		if(offset < 3) {
			menuobj.style.left = (showobj.X + menuobj.w > document.body.clientWidth) && (showobj.X + showobj.w - menuobj.w >= 0) ? showobj.X + showobj.w - menuobj.w + 'px' : showobj.X + 'px';
			menuobj.style.top = offset == 1 ? showobj.Y + 'px' : (offset == 2 || ((showobj.Y + showobj.h + menuobj.h > document.documentElement.scrollTop + document.documentElement.clientHeight) && (showobj.Y - menuobj.h >= 0)) ? (showobj.Y - menuobj.h) + 'px' : showobj.Y + showobj.h + 'px');
		} else if(offset == 3) {
			menuobj.style.left = (document.body.clientWidth - menuobj.clientWidth) / 2 + document.body.scrollLeft + 'px';
			menuobj.style.top = (document.body.clientHeight - menuobj.clientHeight) / 2 + document.body.scrollTop + 'px';
		}

		if(menuobj.style.clip && !is_opera) {
			menuobj.style.clip = 'rect(auto, auto, auto, auto)';
		}
	}
}

function ebygum(eventobj) {
	if(!eventobj || is_ie) {
		window.event.cancelBubble = true;
		return window.event;
	} else {
		if(eventobj.target.type == 'submit') {
			eventobj.target.form.submit();
		}
		eventobj.stopPropagation();
		return eventobj;
	}
}

function initMenu(ctrlid, menuobj, duration, timeout, layer, drag) {
	if(menuobj && !menuobj.initialized) {
		menuobj.initialized = true;
		menuobj.ctrlkey = ctrlid;
		menuobj.onclick = ebygum;
		menuobj.style.position = 'absolute';
		if(duration < 3) {
			if(duration > 1) {
				menuobj.onmouseover = function() {
					clearTimeout(jsmenu['timer'][ctrlid]);
					jsmenu['timer'][ctrlid] = null;
				}
			}
			if(duration != 1) {
				menuobj.onmouseout = function() {
					jsmenu['timer'][ctrlid] = setTimeout('hideMenu(' + layer + ')', timeout);
				}
			}
		}
		menuobj.style.zIndex = 999 + layer;
		if(drag) {
			menuobj.onmousedown = function(event) {try{menudrag(menuobj, event, 1);}catch(e){}};
			menuobj.onmousemove = function(event) {try{menudrag(menuobj, event, 2);}catch(e){}};
			menuobj.onmouseup = function(event) {try{menudrag(menuobj, event, 3);}catch(e){}};
		}
	}
}

function showMenu(ctrlid, click, offset, duration, timeout, layer, showid, maxh, drag) {
	var ctrlobj = _$(ctrlid);
	if(!ctrlobj) return;
	if(isUndefined(click)) click = false;
	if(isUndefined(offset)) offset = 0;
	if(isUndefined(duration)) duration = 2;
	if(isUndefined(timeout)) timeout = 250;
	if(isUndefined(layer)) layer = 0;
	if(isUndefined(showid)) showid = ctrlid;
	var showobj = _$(showid);
	var menuobj = _$(showid + '_menu');
	if(!showobj|| !menuobj) return;
	if(isUndefined(maxh)) maxh = 400;
	if(isUndefined(drag)) drag = false;

	if(click && jsmenu['active'][layer] == menuobj) {
		hideMenu(layer);
		return;
	} else {
		hideMenu(layer);
	}

	var len = jsmenu['timer'].length;
	if(len > 0) {
		for(var i=0; i<len; i++) {
			if(jsmenu['timer'][i]) clearTimeout(jsmenu['timer'][i]);
		}
	}

	initCtrl(ctrlobj, click, duration, timeout, layer);
	ctrlobjclassName = ctrlobj.className;
	ctrlobj.className += ' hover';
	initMenu(ctrlid, menuobj, duration, timeout, layer, drag);

	menuobj.style.display = '';
	if(!is_opera) {
		menuobj.style.clip = 'rect(auto, auto, auto, auto)';
	}

	setMenuPosition(showid, offset);

	if(maxh && menuobj.scrollHeight > maxh) {
		menuobj.style.height = maxh + 'px';
		if(is_opera) {
			menuobj.style.overflow = 'auto';
		} else {
			menuobj.style.overflowY = 'auto';
		}
	}

	if(!duration) {
		setTimeout('hideMenu(' + layer + ')', timeout);
	}

	jsmenu['active'][layer] = menuobj;
}

/// 显示菜单 结束







/**
 * non_num_filter 
 * 屏蔽键盘输入的非数字型字符
 */
function non_num_filter(e){ 
	//alert(event.altKey);
	// 8 退格
	// 37 - 38 - 39 - 40 上下左右
	// 45 36 33 Insert Home Pageup
	// 46 35 34 Delete End Pagedown
	// 96-105 110
	// 48-57 190

	var key = event.keyCode;
	if(
		(key == 8) || 
		(key>=33 && key<=40) ||
		(key>=45 && key<=46) ||

		((key>=48 && key <=57) || key == 46) 
		/*||
		((key>=96 && key <=105) || key == 110)*/
	)
		return true;
	else
		return false;
}




// +------------------------------------------------------------------------+ //
// 表单操作
/**
 * chkbox_sel_all 全选
 * parameter:
 * form 当前表单的名称
 * obj_name 需要选择的checkbox的名称
 *
 * 不传递点击按钮或对象的this主要是因为可能该对象不在form中，或者不是一个input
 * 可能是一个<A>的onclick事件，或者一个<DIV>的onclick事件
 * 如果该对象是合法的<INPUT>并且在form中，可以用如下的方法使用该函数
 * chkbox_sel_all(this.form, '需要选取的对象的name')
 *
 * 
 */
function chkbox_sel_all(form, obj_name, checked) {
	var this_form = document.forms[form];
	if(typeof(this_form) != 'object' && this_form == null) return false;
	var obj = this_form.elements[obj_name];

	if(typeof(obj) == 'object' && obj != null) {
		if(obj.length > 0) {
			for(var i=0; i<obj.length; i++) obj[i].checked = checked;
		} else {
			obj.checked = checked;
		}
	}
}
/**
 * chkbox_sel_reverse 反选
 * 参数说明参照chkbox_sel_all
 */
function chkbox_sel_reverse(form, obj_name) {
	var this_form = document.forms[form];
	if(typeof(this_form) != 'object' && this_form == null) return false;
	var obj = this_form.elements[obj_name];

	if(typeof(obj) == 'object' && obj != null) {
		if(obj.length > 0) {
			for(var i=0; i<obj.length; i++) obj[i].checked = !obj[i].checked;
		} else {
			obj.checked = !obj.checked;
		}
	}
}

// 删除一条记录
function del_this() {
	return confirm('您是否真的要删除当前的记录？\n\n点击“确定”删除，“取消”取消删除操作。');
}

// 检测多选框中是否选择了至少一条记录
function check_at_least_one(form, obj_name) {
	var this_form = document.forms[form];
	if(typeof(this_form) != 'object' && this_form == null) return false;
	var obj = this_form.elements[obj_name];
	if(typeof(obj) == 'object' && obj != null) {
		if(obj.length > 0) {
			for(var i=0; i<obj.length; i++) {
				if(obj[i].checked) {
					return true;
					break;
				}
			}
		} else {
			if(obj.checked) return true;
		}
	}
	return false;
}

// 提交，默认是批量导出
// 根据后两个参数确定
/*function daochu_select_items(form, obj_name, op_lang, op_action) {
	if(typeof(op_lang) == 'undefined') op_lang = '导出';
	if(typeof(op_action) == 'undefined') op_action = 1;
	if(confirm('你还没有选择导出的内容？\n\n点击“确定”导出全部内容，“取消”重新选择内容。')) {
		if(op_action == 1) {
			return true;
		} else {
			// 不提交默认表单中的action
			var oform	= document.forms[form];
			oform.action = op_action;
			oform.submit();
			return true;
		}
	} else {
		return false;
	}
}*/

// 提交，默认是批量删除
// 根据后两个参数确定
function submit_select_items(form, obj_name, op_lang, op_action) {
	if(typeof(op_lang) == 'undefined') op_lang = '删除';
	if(typeof(op_action) == 'undefined') op_action = 1;


	//判断有无选择操作选项
	var tmpobj = document.forms[form].elements["dowhat"];
	if(typeof(tmpobj) == 'object') {
		if(!check_at_least_one(form, "dowhat")) {
			alert('请选择你要进行的操作！');
			return false;
		}
	}


	if(check_at_least_one(form, obj_name)) {
		if(confirm('您是否真的要['+op_lang+']当前选定的记录？\n\n点击“确定”'+op_lang+'，“取消”取消'+op_lang+'操作。')) {
			if(op_action == 1) {
				return true;
			} else {
				// 不提交默认表单中的action
				var oform	= document.forms[form];
				oform.action = op_action;
				oform.submit();
				return true;
			}
		} else {
			return false;
		}
	} else {
		alert('请至少选择一条要['+op_lang+']的记录！');
		return false;
	}
}

//当前导航位置
function write_nav(nav) {
    var onav = parent.document.getElementById('admincpnav');
    onav.innerHTML = '当前位置：' + nav;
}


//打印文档 只打印 报表区的内容
/* 注意开始 前后的字符串
	sprnstr="<!--startprint-->";
	eprnstr="<!--endprint-->";
*/
function preview() {
	bdhtml=window.document.body.innerHTML;
	sprnstr="<!--startprint-->";
	eprnstr="<!--endprint-->";
	prnhtml=bdhtml.substr(bdhtml.indexOf(sprnstr)+17);
	prnhtml=prnhtml.substring(0,prnhtml.indexOf(eprnstr));
	window.document.body.innerHTML=prnhtml;
	window.print();
	//alert(prnhtml);
}

//转换为大写
function Arabia_to_Chinese(Num){
	for(i=Num.length-1;i>=0;i--)
	{
	Num = Num.replace(",","")//替换tomoney()中的“,”
	Num = Num.replace(" ","")//替换tomoney()中的空格
	}
	Num = Num.replace("￥","")//替换掉可能出现的￥字符
	if(isNaN(Num)) { //验证输入的字符是否为数字
	alert("请检查小写金额是否正确");
	return;
	}
	//---字符处理完毕，开始转换，转换采用前后两部分分别转换---//
	part = String(Num).split(".");
	newchar = "";
	//小数点前进行转化
	for(i=part[0].length-1;i>=0;i--){
	if(part[0].length > 10){ alert("位数过大，无法计算");return "";}//若数量超过拾亿单位，提示
	tmpnewchar = ""
	perchar = part[0].charAt(i);
	switch(perchar){
	case "0": tmpnewchar="零" + tmpnewchar ;break;
	case "1": tmpnewchar="壹" + tmpnewchar ;break;
	case "2": tmpnewchar="贰" + tmpnewchar ;break;
	case "3": tmpnewchar="叁" + tmpnewchar ;break;
	case "4": tmpnewchar="肆" + tmpnewchar ;break;
	case "5": tmpnewchar="伍" + tmpnewchar ;break;
	case "6": tmpnewchar="陆" + tmpnewchar ;break;
	case "7": tmpnewchar="柒" + tmpnewchar ;break;
	case "8": tmpnewchar="捌" + tmpnewchar ;break;
	case "9": tmpnewchar="玖" + tmpnewchar ;break;
	}
	switch(part[0].length-i-1){
	case 0: tmpnewchar = tmpnewchar +"元" ;break;
	case 1: if(perchar!=0)tmpnewchar= tmpnewchar +"拾" ;break;
	case 2: if(perchar!=0)tmpnewchar= tmpnewchar +"佰" ;break;
	case 3: if(perchar!=0)tmpnewchar= tmpnewchar +"仟" ;break;
	case 4: tmpnewchar= tmpnewchar +"万" ;break;
	case 5: if(perchar!=0)tmpnewchar= tmpnewchar +"拾" ;break;
	case 6: if(perchar!=0)tmpnewchar= tmpnewchar +"佰" ;break;
	case 7: if(perchar!=0)tmpnewchar= tmpnewchar +"仟" ;break;
	case 8: tmpnewchar= tmpnewchar +"亿" ;break;
	case 9: tmpnewchar= tmpnewchar +"拾" ;break;
	}
	newchar = tmpnewchar + newchar;
	}
	//小数点之后进行转化
	if(Num.indexOf(".")!=-1){
	if(part[1].length > 2) {
	alert("小数点之后只能保留两位,系统将自动截段");
	part[1] = part[1].substr(0,2)
	}
	for(i=0;i<part[1].length;i++){
	tmpnewchar = ""
	perchar = part[1].charAt(i)
	switch(perchar){
	case "0": tmpnewchar="零" + tmpnewchar ;break;
	case "1": tmpnewchar="壹" + tmpnewchar ;break;
	case "2": tmpnewchar="贰" + tmpnewchar ;break;
	case "3": tmpnewchar="叁" + tmpnewchar ;break;
	case "4": tmpnewchar="肆" + tmpnewchar ;break;
	case "5": tmpnewchar="伍" + tmpnewchar ;break;
	case "6": tmpnewchar="陆" + tmpnewchar ;break;
	case "7": tmpnewchar="柒" + tmpnewchar ;break;
	case "8": tmpnewchar="捌" + tmpnewchar ;break;
	case "9": tmpnewchar="玖" + tmpnewchar ;break;
	}
	if(i==0)tmpnewchar =tmpnewchar + "角";
	if(i==1)tmpnewchar = tmpnewchar + "分";
	newchar = newchar + tmpnewchar;
	}
	}
	//替换所有无用汉字
	while(newchar.search("零零") != -1)
	newchar = newchar.replace("零零", "零");
	newchar = newchar.replace("零亿", "亿");
	newchar = newchar.replace("亿万", "亿");
	newchar = newchar.replace("零万", "万");
	newchar = newchar.replace("零元", "元");
	newchar = newchar.replace("零角", "");
	newchar = newchar.replace("零分", "");
	if (newchar.charAt(newchar.length-1) == "元" || newchar.charAt(newchar.length-1) == "角")
	newchar = newchar+"整"
	return newchar;
}

//处理多组多图上传 start
function GE(id) {
	if (typeof(id) != "string" || id == "") return null;
	if (document.getElementById && document.getElementById(id)) {
		return document.getElementById(id);
	} else if (document.all && document.all[id]) {
		return document.all[id];
	} else if (document.layers && document.layers[id]) {
		return document.layers[id];
	} else {
		return null;
	}
}

function up_onchange(ofile, c, num) {
    var oimg    = GE('preview_img_'+c+'_' + num);
    var oname   = GE('photo_'+c+'_name' + num);
    if(typeof(oimg) == 'object' && oimg != null) {
        oimg.src    = ofile.value;
		oimg.width  = 122;
		oimg.height = 92;
    }
    if(typeof(oname) == 'object' && oname != null) {
        var s = ofile.value;
        s = s.substr(s.lastIndexOf('\\')+1, s.length);
        oname.value = s;
    }
}
var amount_1 = amount_2 = amount_3 = amount_4 = 6;
function addRow(table_id, item_id, c){
    var table = GE(table_id);
    mynewrow = table.insertRow();	

    eval("amount_"+c+"++");
	eval("amount=amount_"+c);
    mynewcell_0=mynewrow.insertCell();
	mynewcell_0.align = 'center';
    mynewcell_0.innerHTML= amount+'.';
    mynewcell_1=mynewrow.insertCell();
    mynewcell_1.innerHTML='<input type="text" name="'+item_id+'name[]" id="'+item_id+'name'+amount+'" class="input01">';
    mynewcell_2=mynewrow.insertCell();
    mynewcell_2.innerHTML='<input type="file" name="'+item_id+amount+'" class="input02" onchange="return up_onchange(this,'+c+','+amount+');"  style="margin-left:-22px;margin-right:0px;">';
    mynewcell_3=mynewrow.insertCell();
    mynewcell_3.innerHTML='<input type="text" name="'+item_id+'memo[]" class="input01" size="20">';

    mynewcell_4=mynewrow.insertCell();
    mynewcell_4.innerHTML='<input type="button" onclick="deleteRow(this.parentNode.parentNode.rowIndex, '+c+','+amount+');" value="删除" class="button01" />';
    GE('review_img'+c).innerHTML  += '<img src="images/blank.gif" width="111" height="111" id="preview_img_'+c+'_'+amount+'">';
}

function deleteRow(id, c, num){
    var table = GE("up_table_"+c);
    table.deleteRow(id);
	var oimg    = GE('preview_img_'+c+'_' + num);
    oimg.removeNode(true);
    eval("amount_"+c+"--");
}
//处理多组多图上传 end



