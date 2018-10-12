<?php
/*
	[CTB] (C) 2007-2009 copytaobao.com
	$Id: news_news_add.php 2013-11-25 0:32:35 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(); //权限检查
loadcache('news_class'  ,'id', '', 'orderlist', 1);  // 加载缓存树状栏目

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	$date_start = strtotime($_POST['date_start'].' 00:00:00'); //转换输入的时间为时间戳的方式
	$date_end = strtotime($_POST['date_end']. ' 23:59:59');
	
	$img_url = '';
	$_CTB['attachdir'] = '.' . $_CTB['attachdir'];
	//上传logo
	include_once(S_ROOT.'./lib/function/function_image.php');
	if ($_FILES['img']['name']) {
		$aryreturn = pic_save($_FILES['img']);
		if (is_array($aryreturn)) { //返回数组则上传成功,取得文件名
			$img_url = $aryreturn['new_name'];
		} else {
			showmsg($aryreturn);
		}
	}
	
	if ($id <= 0) { //添加

		$arr = array(
				//'title'            => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['title']),
				'title'            => 	$_POST['title'],
				'signup_time'          => 	strtotime($_POST['signup_time']),
				
				'img'              => 	$img_url,
				//'content'          => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['content']),
				'rules'          => 	$_POST['rules'],
				'inputtime'      => time()
				);
		$id = inserttable('partner_rule', $arr, 1);
		$result = '内容添加成功！';

	} else { //更新
		
		if ($img_url) {
			$img_url_new = $img_url;
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			file_exists($_POST['fileimg_url'].'.thumb.jpg') && unlink($_POST['fileimg_url'].'.thumb.jpg');
		} else {
			$img_url_new = $_POST['fileimg_url'];
		}

		//删除缩略图
		if ($_POST['img_url_flag'] == 1) {
			file_exists($_POST['fileimg_url']) && unlink($_POST['fileimg_url']);
			$img_url_new = '';
		}
		$arr = array(
				//'title'            => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['title']),
				'title'            => 	$_POST['title'],
				'signup_time'          => 	strtotime($_POST['signup_time']),
				
				'img'              => 	$img_url?$img_url:$_POST['img'],
				//'content'          => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['content']),
				'rules'          => 	$_POST['rules'],
				'inputtime'      => time()
				);
		updatetable('partner_rule', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result, 'module.php?ac=partner&mod=rule');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('partner_rule')." WHERE id='$id'");
	@extract($_TGLOBAL['db']->fetch_array($query));
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/jquery.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=DBd897f58d7a63e585485e3dea011253"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<div id="bd_map" style="display: block; position: absolute;width: 716px;left: 180px;top: 50px;z-index: -2017;">
	<table style="background-color:#f6f6f6;">
		<tbody>
			<tr>
				<td colspan="2">
					<div>
						<div class="aui_title" style="cursor: move;height: 28px;line-height: 27px;padding-top:0px;padding-right: 28px;padding-bottom: 0px;padding-left: 10px;font-weight: bold;">BaiduMap</div>
						<a class="aui_close" id="close" href="javascript:void(0);" style="padding: 0;top: 4px;right: 4px;width: 21px;line-height: 21px;font-size: 18px;color: #333333;overflow: hidden;display: block;position: absolute;text-decoration: none;outline: none;">×</a>
					</div>
				</td>
			</tr>
			<tr>
				<td style="padding-bottom: 0px;width: 700px;height: 430px;visibility: visible;">
					<div id="l-map" style="display: block;width: 100%;margin: 0;padding: 0!important;height: 100%;"></div>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="aui_footer">
					<div class="aui_buttons" style="background-color: #f6f6f6;border-top-width:1px;border-top-style: solid;border-top-color: rgb(218,222,229);padding: 8px;text-align: right;white-space: nowrap;">
						<button type="button" id="confirm" style="margin-left: 15px;padding-top: 6px;padding-right: 8px;padding-bottom: 6px;padding-left: 8px;cursor: pointer;display: inline-block;text-align: center;line-height: 1;letter-spacing: 2px;overflow: visible;border-radius: 5px;border: solid 1px #999999;">确定</button>
						<button type="button" id="cancel" style="margin-left: 15px;padding-top: 6px;padding-right: 8px;padding-bottom: 6px;padding-left: 8px;cursor: pointer;display: inline-block;text-align: center;line-height: 1;letter-spacing: 2px;overflow: visible;border-radius: 5px;border: solid 1px #999999;">取消</button>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>活动管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 标题</td>
          <td width="86%"><input name="title" type="text" id="title" value="<?php echo @$title; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>
		<tr>
			<td>报名时间：</td>
			<?php if(empty(@$signup_time)) { ?>
			<td><input type="date" name="signup_time" value="<?php echo date('Y-m-d',time());?>"</td>
			<?php }else{ ?>
			<td><input type="date" name="signup_time" value="<?php echo date('Y-m-d',@$signup_time);?>"</td>
			<?php } ?>
		</tr>
		
        <tr>
          <td class="caption">图片</td>
          <td><input type="file" name="img" size="35">
            <?php if (@$img) echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"img\" value=\"".$img."\">删除图片"; ?>（列表页图片展示）</td>
        </tr>
        
        <tr>
        		<td>活动规则</td>
          <td><script charset="utf-8" src="ueditor/ueditor.config.js" type="text/javascript"></script>
			<script charset="utf-8" src="ueditor/ueditor.all.min.js" type="text/javascript"> </script>
			<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
			<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
			<script charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
			<script id="editor" type="text/plain" style="width:100%;height:500px;" name="rules"><?php echo @$rules; ?></script>	</td>
        </tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo @$id; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
        </tr>
      </tbody>
    </table>
  </form>
</DIV>
<?php include 'footer.php'; ?>
<style>
.jiaolian{
	display:block;
}
</style>
<script type="text/javascript">
//实例化编辑器
//建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例


var ue = UE.getEditor('editor',
				{
					//sourceEditor :"textarea",
				});

//类别选择
$("#class_id").change ( function () {
	if($("#class_id").val() == 3 ){
		$(".jiaolian").css("display","block");
		$(".jiaolian").removeClass("jiaolian");
	}else{
		//$(".jiaolian").addClass("jiaolian");
	}
	class_list();
});
function class_list() {
	$.get("../lib/xml.php?"+Math.random(), { ac: "news_class", last_class_id: $("#class_id").val(), class_id: '<?php echo @substr($class_id, 0, 6); ?>'},
		function(data){
			$("#goods_class").html(data);
		});
}
class_list();

//选择二级时，显示三级类别
function class_list_3(val) {
	$.get("../lib/xml.php?"+Math.random(), { ac: "news_class", last_class_id: val, class_id: '<?php echo @$class_id; ?>'},
		function(data){
			$("#goods_class_3").html(data);
		});
}
class_list_3('<?php echo @substr($class_id, 0, 6); ?>');
</script>
</BODY>
</HTML>
<script type="text/javascript">

	$(function(){ 
		// 百度地图API功能
		var map = new BMap.Map("l-map");
		var p_lng;
		var p_lat; 
		p_lng = $("#lng").val();
		p_lat = $("#lat").val();
		//判断 如果是新建的标注无值 就取默认的定位，如果标注有值 就取出值标注定位到地图
		if((p_lng==null||p_lng==''||p_lng==undefined)&&(p_lat==null||p_lat==''||p_lat==undefined)){
			p_lng = 106.559614;
			p_lat = 29.567507;
		} else {
			p_lng = $("#lng").val();
			p_lat = $("#lat").val();
		}
		var point = new BMap.Point(p_lng,p_lat);
		map.centerAndZoom(point, 12);
		map.enableScrollWheelZoom(true);   //缩放地图
		var marker = new BMap.Marker(point);// 创建标注
		map.addOverlay(marker);             // 将标注添加到地图中
		marker.enableDragging();           // 可拖拽
　　		$("#close").click(function(){
			$("#bd_map").css("z-index",-2017);
　　		});

		$("#cancel").click(function(){
			$("#bd_map").css("z-index",-2017);
　　		});

		$("#open_map").click(function(){
			$("#bd_map").css("z-index",2017);
　　		});

		$("#confirm").click(function(){
			var p = marker.getPosition();       //获取marker的位置
			var lng = p.lng;
			var lat = p.lat;
			$("#lng").val(lng);
			$("#lat").val(lat);
			$("#bd_map").css("z-index",-2017);
		});
	}); 
</script>
