<?php
/*
	[CTB] (C) 2007-2009 51shop.org
	$Id: main.php 2009-5-3 21:46:41 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
 header("Content-type: text/html; charset=utf-8");   

//登录检查
!$_TCOOKIE['adminauth'] && header("Location: module.php?ac=system&mod=login");

//加载缓存
loadcache('menu'        ,'id', '', 'orderlist'); // 后台菜单缓存
loadcache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限

//取出权限
$role_id = $_TGLOBAL['adm_role_id']; //会员角色的id
$roles = $_TGLOBAL['admin_role_priv'][$role_id];

// 组合一级二级菜单
foreach($_TGLOBAL['menu'] as $key=>$val){
	// 如果存在权限就组合
	if(array_key_exists($val['id'], $roles)){
		if($val['pid']==0){
			if($val['is_hidden']!=1){
				$top_menu[] = $val; //组合一级菜单
			}
		}else{
			if($val['is_hidden']!=1){
				$left_menu[] = $val; //组合二级菜单
			}
		}
	}
}


//var_dump($top_menu);
//var_dump($left_menu);
$left = array(); //重新构建数组
foreach($left_menu as $key=>$val){
	$left[$val['mod']][$val['ac']] = $val['name'];
}

//var_dump($roles);
?>
<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $_TCONFIG['sitename']; ?> power by ctb v2.0</title>
<meta http-equiv=content-type content="text/html; charset=utf-8">
<link media=all href="./images/admincp.css" type=text/css rel=stylesheet>
<script src="./js/common.js" type=text/javascript charset="utf-8"></script>
</head>
<body style="margin: 0px" scroll=no>
<div id=append_parent></div>
<table height="100%" cellspacing=0 cellpadding=0 width="100%" border=0>
  <tbody>
    <tr>
      <td colspan=2 height=90><div class=mainhd>
          <div class=logo>ctb administrator's control panel</div>
          <div class=uinfo>
            <p></p>
            <p class=btnlink></p>
          </div>
          <div class=navbg></div>
          <div class=nav>
            <ul id=topmenu>
<?php
foreach($top_menu as $key => $val) {
	//下面切换的值
	!isset($header_key) && $header_key = $val['mod'];
	$ary = array_keys(array_slice($left[$val['mod']], 0, 1));
	echo " <li><em><a id=\"header_$val[mod]\" hidefocus onclick=\"toggleMenu('$val[mod]', 'ac=$val[mod]&mod=$ary[0]');\" href=\"javascript:;\">$val[name]</a></em></li>";

 } ?>
            </ul>
            <div class=currentloca>
              <p id=admincpnav></p>
            </div>
            <div class=navbd></div>
           <div class=sitemapbtn>
              <div style="float: left; margin: 5px 10px 0px 0px">您好, <em><?php echo $_TGLOBAL['adm_username']; ?></em> [ <a 
      href="module.php?ac=system&mod=logout" target=_top>退出</a> ] <a href="../" target=_blank>网站首页</a> </div>
              <span id=add2custom></span><a id=cpmap onclick="showmap();return false;" href="###"><img title=后台导航 height=18 src="images/btn_map.gif" width=72></a> </div>
          </div>
          </div>
        </div></td>
    </tr>
    <tr>
      <td class=menutd valign=top width=160><div class=menu id=leftmenu>
<?php
$aryid = array();
foreach($top_menu as $key => $val) {
	$aryid[] = $val['mod'];
	echo "<ul id=\"menu_$val[mod]\" style=\"display: none\">";
	foreach($left[$val['mod']] as $kk => $vv) {
		if ($vv == '') continue;
		echo "<li><a hidefocus href=\"module.php?ac=$val[mod]&mod=$kk\" target=\"main\">$vv</a></li>";
	} 
	echo " </ul>";
} ?>
      </div></td>
      <td class=mask valign=top width="100%"><iframe id=save_frame_18807984 
      name=save_frame_18807984 src="about:blank" width=0 scrolling=0 
      height=0></iframe>
        <iframe style="overflow: visible" name=main src="module.php?ac=system&mod=admin" frameborder=0 width="100%" scrolling=yes height="100%"></iframe></td>
    </tr>
  </tbody>
</table>
<div class=copyright>
  <p>&copy; 2007-2015,  </p>
</div>
<div class=custom id=cpmap_menu style="display: none">
  <div class=cside>
    <h3><span class=ctitle1></span></h3>
    <ul class=cslist id=custommenu>
    </ul>
  </div>
  <div class=cmain id=cmain></div>
  <div class=cfixbd></div>
</div>
<SCRIPT type=text/JavaScript>
	var headers = new Array(<?php echo simplode($aryid); ?>);
	var admincpfilename = 'module.php';
	
	function toggleMenu(key, url) {
		if(key == 'system' && url == 'home') {
			if(is_ie) {
				doane(event);
			}
			top.location.href = 'main.php' + '?frames=yes';
			return false;
		}
		for(var k in headers) {
			if(_$('menu_' + headers[k])) {
				_$('menu_' + headers[k]).style.display = headers[k] == key ? '' : 'none';
			}
		}
		var lis = _$('topmenu').getElementsByTagName('li');
		for(var i = 0; i < lis.length; i++) {
			if(lis[i].className == 'navon') lis[i].className = '';
		}
		_$('header_' + key).parentNode.parentNode.className = 'navon';
		if(url) {
			parent.main.location = admincpfilename + '?' + url;
			var hrefs = _$('menu_' + key).getElementsByTagName('a');
			for(var j = 0; j < hrefs.length; j++) {
				hrefs[j].className = hrefs[j].href.substr(hrefs[j].href.indexOf(admincpfilename + '?action=') + 19) == url ? 'tabon' : (hrefs[j].className == 'tabon' ? '' : hrefs[j].className);
			}
		}
		return false;
	}
	
	function initCpMenus(menuContainerid) {
		var key = '';
		var hrefs = _$(menuContainerid).getElementsByTagName('a');
		for(var i = 0; i < hrefs.length; i++) {
			if(menuContainerid == 'leftmenu' && !key && 'action=home'.indexOf(hrefs[i].href.substr(hrefs[i].href.indexOf(admincpfilename + '?action=') + 12)) != -1) {
				key = hrefs[i].parentNode.parentNode.id.substr(5);
				hrefs[i].className = 'tabon';
			}
			if(!hrefs[i].getAttribute('ajaxtarget')) hrefs[i].onclick = function() {
				if(menuContainerid != 'custommenu') {
					var lis = _$(menuContainerid).getElementsByTagName('li');
					for(var k = 0; k < lis.length; k++) {
						if(lis[k].firstChild.className != 'menulink') lis[k].firstChild.className = '';
					}
					if(this.className == '') this.className = menuContainerid == 'leftmenu' ? 'tabon' : 'bold';
				}
				if(menuContainerid != 'leftmenu') {
					var hk, currentkey;
					var leftmenus = _$('leftmenu').getElementsByTagName('a');
					for(var j = 0; j < leftmenus.length; j++) {
						hk = leftmenus[j].parentNode.parentNode.id.substr(5);
						if(this.href.indexOf(leftmenus[j].href) != -1) {
							leftmenus[j].className = 'tabon';
							if(hk != 'system') currentkey = hk;
						} else {
							leftmenus[j].className = '';
						}
					}
					if(currentkey) toggleMenu(currentkey);
					hideMenu();
				}
			}
		}
		return key;
	}
	
	var header_key = initCpMenus('leftmenu');
	toggleMenu(header_key ? header_key : '<?php echo $header_key; ?>');
	
	function initCpMap() {
		var ul, hrefs, s;
		s = '<ul class="cnote"><li><img src="images/btn_map.gif" /></li><li>顶吉驾校官网</li></ul><table class="cmlist" id="mapmenu"><tr>';

		for(var k in headers) {
			if(headers[k] != 'system' && headers[k] != 'uc') {
				s += '<td valign="top"><ul class="cmblock"><li><h4>' + _$('header_' + headers[k]).innerHTML + '</h4></li>';
				ul = _$('menu_' + headers[k]);
				hrefs = ul.getElementsByTagName('a');
				for(var i = 0; i < hrefs.length; i++) {
					s += '<li><a href="' + hrefs[i].href + '" target="' + hrefs[i].target + '" k="' + headers[k] + '">' + hrefs[i].innerHTML + '</a></li>';
				}
				s += '</ul></td>';
			}
		}
		s += '</tr></table>';
		return s;
	}
	
	_$('cmain').innerHTML = initCpMap();
	initCpMenus('mapmenu');
	var cmcache = false;
	function showMap() {
		showMenu('cpmap', true, 3, 3);
	}
	
	function resetEscAndF5(e) {
		e = e ? e : window.event;
		actualCode = e.keyCode ? e.keyCode : e.charCode;
		if(actualCode == 27) {
			if(_$('cpmap_menu').style.display == 'none') {
				showMap();
			} else {
				hideMenu();
			}
		}
		if(actualCode == 116 && parent.main) {
			parent.main.location.reload();
			if(document.all) {
				e.keyCode = 0;
				e.returnValue = false;
			} else {
				e.cancelBubble = true;
				e.preventDefault();
			}
		}
	}
	_attachEvent(document.documentElement, 'keydown', resetEscAndF5);


	function uc_left_menu(uc_menu_data) {
		var leftmenu = _$('menu_uc');
		leftmenu.innerHTML = '';
		var html_str = '';
		for(var i=0;i<uc_menu_data.length;i+=2) {
			html_str += '<li><a href="'+uc_menu_data[(i+1)]+'" hidefocus="true" onclick="uc_left_switch(this)" target="main">'+uc_menu_data[i]+'</a></li>';
		}
		leftmenu.innerHTML = html_str;
		toggleMenu('uc', '');
		_$('admincpnav').innerHTML = 'UCenter';
	}

	var uc_left_last = null;
	function uc_left_switch(obj) {
		if(uc_left_last) {
			uc_left_last.className = '';
		}
		obj.className = 'tabon';
		uc_left_last = obj;
	}

</SCRIPT>
</BODY>
</HTML>
