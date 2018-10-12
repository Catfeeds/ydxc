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
				'summary'          => 	$_POST['summary'],
				'xingming'          => 	$_POST['xingming'],
				'sscd'              => 	$_POST['sscd'],
				'nianxian'          => 	$_POST['nianxian'],
				'kemu'              => 	$_POST['kemu'],
				'drive_type'        => 	$_POST['drive_type'],
				'lng'              => 	$_POST['lng'],
				'lat'              => 	$_POST['lat'],
				'xingge'            => 	$_POST['xingge'],
				'class_id'         => 	$_POST['class_id'],
				'date_start'       => 	$date_start,
				'date_end'         => 	$date_end,
				'img'              => 	$img_url,
				//'content'          => 	str_replace('西部海淘', '<a href="http://www.dingjijiaxiao.com/">西部海淘</a>', $_POST['content']),
				'content'          => 	$_POST['content'],
				'jumpto'           => 	$_POST['jumpto'],
				'flag'             => 	@implode(",", $_POST['flag']),
				'readno'           => 	0,
				'date'             => 	$_TGLOBAL['timestamp'],
				'uname'            => 	$_TGLOBAL['adm_username'],
				'display'          => 	@(int)$_POST['display'],
				'displayorder'     => 	@(int)$_POST['displayorder'],
				);
		$id = inserttable('news', $arr, 1);
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
				'title'            => 	$_POST['title'],
				'summary'          => 	$_POST['summary'],
				'xingming'          => 	$_POST['xingming'],
				'sscd'              => 	$_POST['sscd'],
				'nianxian'          => 	$_POST['nianxian'],
				'kemu'              => 	$_POST['kemu'],
				'lng'              => 	$_POST['lng'],
				'lat'              => 	$_POST['lat'],
				'xingge'            => 	$_POST['xingge'],
				'class_id'         => 	$_POST['class_id'],
				'img'              => 	$img_url_new,
				'date_start'       => 	$date_start,
				'date_end'         => 	$date_end,
				'content'          => 	$_POST['content'],
				'jumpto'           => 	$_POST['jumpto'],
				'flag'             => 	@implode(",", $_POST['flag']),
				'display'          => 	@(int)$_POST['display'],
				'displayorder'     => 	@(int)$_POST['displayorder'],
				);
		updatetable('news', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result, 'module.php?ac=news&mod=li');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news')." WHERE id='$id'");
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
  <DIV class=header>新闻管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 标题</td>
          <td width="86%"><input name="title" type="text" id="title" value="<?php echo @$title; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>
        <tr>
          <td class="caption">类别</td>
          <td><?php echo @makeselect($_TGLOBAL['tree_news_class'],'class_id', $class_id,'datatype="Require" msg="请选择栏目"','name', 'id','请选择栏目', '0', 1);?> </td>
        </tr>
        <tr>
          <td class="caption"><span class="MustFill">显示顺序</span></td>
          <td><input name="displayorder" type="text" id="displayorder" value="<?php echo @$displayorder; ?>" size="14" maxlength="10">
            数字，值越大，越排在前面</td>
        </tr>
		
		
        <tr class="jiaolian2">
          <td class="caption"> 教练姓名</td>
          <td><input name="xingming" type="text" id="xingming" value="<?php echo @$xingming; ?>" size="85" maxlength="255" ></td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 所属场地</td>
          <td><!--<input name="kemu" type="text" id="kemu" value="<?php echo @$kemu; ?>" size="85" maxlength="255" >-->
				<?php echo @makeselect($_TGLOBAL['setting']['sscd'],'sscd', $sscd,'datatype="Require" msg="请选择场地"','', '','选择场地', '0', 1);?>
		  </td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 从业年限</td>
          <td><input name="nianxian" type="text" id="nianxian" value="<?php echo @$nianxian; ?>" size="85" maxlength="255" ></td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 科目</td>
          <td><!--<input name="kemu" type="text" id="kemu" value="<?php echo @$kemu; ?>" size="85" maxlength="255" >-->
				<?php echo @makeselect($_TGLOBAL['setting']['kemu'],'kemu', $kemu,'datatype="Require" msg="请选择栏目"','', '','选择科目', '0', 1);?>
		  </td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 驾驶类型</td>
          <td><!--<input name="kemu" type="text" id="kemu" value="<?php echo @$kemu; ?>" size="85" maxlength="255" >-->
				<?php echo @makeselect($_TGLOBAL['setting']['drive_type'],'drive_type', $drive_type,'datatype="Require" msg="请选择类型"','', '','选择类型', '0', 1);?>
		  </td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 场地位置</td>
          <td>
          	<input type="button" id="open_map" value="位置标注" />
          	经度<input name="lng" readonly="readonly" type="text" size="11" id="lng" value="<?php echo @$lng; ?>" style="border: none;">
          	纬度<input name="lat" readonly="readonly" type="text" size="10" id="lat" value="<?php echo @$lat; ?>" style="border: none;">		
          </td>
        </tr>
        <tr class="jiaolian2">
          <td class="caption"> 性格描述</td>
          <td><input name="xingge" type="text" id="xingge" value="<?php echo @$xingge; ?>" size="85" maxlength="255" ></td>
        </tr>
		
        <tr>
          <td class="caption">封面图</td>
          <td><input type="file" name="img" size="35">
            <?php if (@$img) echo "<a href='".$img."' target='_blank'>显示图片</a> <input type=\"checkbox\" name=\"img_url_flag\" value=\"1\"><input type=\"hidden\" name=\"fileimg_url\" value=\"".$img."\">删除图片"; ?>（列表页图片展示）</td>
        </tr>
        <tr>
          <td class="caption">显示标识</td>
          <td><input name="display" type="checkbox" id="display" value="1" <?php echo @$display ? 'checked' : ''; ?>></td>
        </tr>
        <!--<tr>
          <td class="caption">活动时间</td>
          <td>
			  <input name="date_start" type="text" value="<?php echo @$date_start ? date('Y-m-d',$date_start) : ''; ?>" size="10" maxlength="10" onClick="new Calendar().show(this);"> - <input name="date_end" type="text" value="<?php echo @$date_end ? date('Y-m-d',$date_end) : ''  ; ?>" size="10" maxlength="10" onClick="new Calendar().show(this);">
		  </td>
        </tr>-->
        <tr>
          <td class="caption">外链网址</td>
          <td><input name="jumpto" type="text" id="jumpto" value="<?php echo @$jumpto; ?>" size="60" maxlength="255">
需跳转到其他网址，请在这里填写网址</td>
        </tr>
        <tr>
          <td width="14%" class="caption">摘要</td>
          <td width="86%"><textarea name="summary" cols="85" rows="5"><?php echo @$summary; ?></textarea></td>
        </tr>
        <tr>
          <td colspan="2" align="left"><script charset="utf-8" src="ueditor/ueditor.config.js" type="text/javascript"></script>
			<script charset="utf-8" src="ueditor/ueditor.all.min.js" type="text/javascript"> </script>
			<!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
			<!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
			<script charset="utf-8" src="ueditor/lang/zh-cn/zh-cn.js" type="text/javascript"></script>
			<script id="editor" type="text/plain" style="width:100%;height:500px;" name="content"><?php echo @$content; ?></script>	</td>
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
