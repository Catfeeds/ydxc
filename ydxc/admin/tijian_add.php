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

		//接收前台文件  
        $ex = $_FILES['excel'];
        //重设置文件名
        $filename = time().substr($ex['name'],stripos($ex['name'],'.'));  
        $path = S_ROOT.'./upload/excel/'.$filename;//设置移动路径  
        move_uploaded_file($ex['tmp_name'],$path);
        
        $driveFile=S_ROOT.'./lib/PHPExcel/PHPExcel.php';
        if(!file_exists($driveFile)){
            $res=array('code'=>'55','msg'=>'驱动文件不存在');
            return json_encode($res);
        }
        require_once($driveFile);
        //获取phpexcel对象
        // $objPHPExcel = new PHPExcel();
        //获取excel 2007对象
        // $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
        //获取excel读取类
        $objReader = PHPExcel_IOFactory::createReader('Excel5');
        //设置只读
        $objReader->setReadDataOnly(true);
        //加载需要读取的文件
        $objPHPExcel = $objReader->load($path);
        //获取单元格
        $objWorksheet = $objPHPExcel->getActiveSheet();
        //获取总的行数
        $highestRow = $objWorksheet->getHighestRow();
        //获取总的列数
        $highestColumn = $objWorksheet->getHighestColumn();
        //将字母列名变成数字列名
        $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
        //定义
        $excelData = array();
        //循环获取数据
        for($row = 1; $row <= $highestRow; $row++ ){
            for($cols = 0; $cols < $highestColumnIndex; $cols++){
                $excelData[$row]['b'[$cols]]=(string)$objWorksheet->getCellByColumnAndRow($cols, $row)->getValue();
            }
         }
         unlink($path);
         for($i=1;$i<=count($excelData);$i++){
         	$arr = array(
				'tj_code'            => 	$excelData[$i]['b'],
				'inputtime'          => 	time(),
				'putouttime'         => 	strtotime($_POST['putouttime']),
				'is_use'             => 	$_POST['is_use'],
				'belong_to'          => 	$_POST['belong_to'],
				);
			$rand1 = rand(0,9);
			$rand2 = rand(0,9);
			$rand3 = rand(0,9);
			
			$rand_group = $rand1.$rand2.$rand3;
			$arr['rand_code'] = $rand_group;
			$substring = substr($excelData[$i]['b'],0,7);
			// 10位体检码  7位源码 ＋ 3位随机码
			$arr['tj_code_new'] = $substring.$rand_group;
			inserttable('tj_code_info', $arr, 1);
         }
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
				'tj_code'            => 	$_POST['tj_code'],
				'putouttime'         => 	strtotime($_POST['putouttime']),
				'is_use'             => 	$_POST['is_use'],
				'belong_to'          => 	$_POST['belong_to'],
				);
		updatetable('tj_code_info', $arr, array('id' => $id));
		$result = '内容修改成功！';
	}

	showmsg($result, 'module.php?ac=tijian&mod=hmgl');

}

$display = 1;
//取出修改时的信息
$id = @(int)$_GET['id'];
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('tj_code_info')." WHERE id='$id'");
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
<SCRIPT language=JavaScript src="jquery-2.1.4.min.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/popcalendar.js"></script>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=DBd897f58d7a63e585485e3dea011253"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">

<DIV class=datacontainer2 style="WIDTH: 98%">
  <DIV class=header>体检号管理 </DIV>
  <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <!--<tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 体检原码</td>
          <td width="50%"><input name="tj_code" type="text" id="tj_code" value="<?php echo @$tj_code; ?>" size="85" maxlength="255" datatype="Require" msg="请填写内容标题." ></td>
        </tr>-->
        <tr>
          <td width="14%" class="caption"><span class="font_red">*</span> 表格</td>
          <td width="50%"><input name="excel" type="file" id="excel"></td>
        </tr>
        <tr>
          <td class="caption">发放时间</td>
          <td>
          	<?php if(empty(@$putouttime)) $putouttime=time();?>
          		
          	<input name="putouttime" type="date" id="putouttime" value="<?php echo date('Y-m-d',@$putouttime); ?>" size="85" maxlength="255" datatype="Require" msg="请填写发放时间." >
          		
          	</td>
        </tr>
        <tr>
          <td class="caption">是否使用</span></td>
          <td>
          	<select name="is_use">
          		<option value="0">分配状态</option>
          		<option value="1" <?php if(@$is_use==1){?>selected="selected"<?php } ?>>未分配</option>
          		<option value="2" <?php if(@$is_use==2){?>selected="selected"<?php } ?>>已分配</option>
          	</select>
          </td>
        </tr>
		<tr>
          <td class="caption">所属机构</span></td>
          <td>
          	<select name="belong_to" id="belong_to" >
          		<option value="0">请选择机构</option>
          		<?php $sql = $_TGLOBAL['db']->query("SELECT * FROM ".tname('news_class')." where pid=24");
				while ($value = $_TGLOBAL['db']->fetch_array($sql)) {	 ?>
          		<option value="<?php echo $value['id']; ?>" <?php if(@$belong_to==$value['id']){?>selected="selected"<?php } ?>><?php echo $value['name'];?></option>
          		<?php } ?>
          	</select>
          </td>
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

