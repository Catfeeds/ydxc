<?php
/*
	[CTB] (C) 2007-2009 
	$Id: member_group_add.php 2010-6-9 20:32:10 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查
loadcache('class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状
loadcache('brand'  ,'id', '', 'orderlist');  
$classid = isset($_POST['classid']) ? $_POST['classid'] : (isset($_GET['classid']) ? $_GET['classid'] : '' );

//include_once(S_ROOT.'./lib/function/function_cache.php');
//$classid = isset($_GET['classid']) ? (int)$_GET['classid'] : (isset($_POST['classid']) ? (int)$_POST['classid'] : 0);


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	if ($id <= 0) { //添加

		$grouparr = array(
			
				'classid'          => 	$_POST['classid'],
				'name'             => 	$_POST['name'],
				'brandid'          => 	$_POST['brandid'],
				'descript'         => 	$_POST['descript'],
				'warnnum'          => 	$_POST['warnnum'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],
				'isone'            => 	$_POST['isone'],
				'usetime'          => 	$_POST['usetime'],
				'useumit'          => 	$_POST['useumit'],

				);
		$nameid = inserttable('name', $grouparr,1);
		
		// 更新编号、条形码
		// 物资分类-品牌编号-物资编号-2位随机号
		$classno         = getcount('class', array('id'=>$_POST['classid']), 'no');
		$brandno         = getcount('brand', array('id'=>$_POST['brandid']), 'no');
		!$brandno      && $brandno = '0000';
		$name['no']      = str_repeat(0,4 - strlen($nameid)).$nameid;
		$name['barcode'] = makeno('name', 'barcode', 6, 'nl'.$classno.'p'.$brandno.'n'.$name['no']);
		updatetable('name', $name, array('id' => $nameid));
		
		//储存条形码
		$barcodearr = array(
					'itype'            => 	3,
					'num'              => 	strlen($name['barcode']),
					'barcode'          => 	$name['barcode'],
					'name'             => 	$_POST['name'],
					'isused'           => 	1,
					'departmentid'     => 	$_TGLOBAL['adm_storeid'],
					'userid'           => 	$_TGLOBAL['adm_userid'],
					'createname'       => 	$_TGLOBAL['adm_name'],
					'date'             => 	$_TGLOBAL['timestamp'],
						);
		inserttable('barcode', $barcodearr);
		
		// 插入物资属性
		foreach($_POST['attrs'] as $key=>$val){
			$attrs = array(
				'nameid'           => 	$nameid,
				'attrsid'          => 	$key,
				'name'             => 	$val,
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'remark'           => 	'',
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],

					);
			inserttable('name_attr', $attrs);	
		}
		
		// 插入物资名称
		foreach($_POST['parts'] as $key=>$val){
			$parts = array(
				'nameid'           => 	$nameid,
				'partsid'          => 	$key,
				'name'             => 	$val,
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'remark'           => 	'',
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],

					);
			inserttable('name_parts', $parts);	
		}
		
		
		//showmsg('物资属性添加成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资名录添加成功！', 'module.php?ac=setting&mod=name');

	} else { //更新

		$grouparr = array(
				'classid'          => 	$_POST['classid'],
				'name'             => 	$_POST['name'],
				'warnnum'          => 	$_POST['warnnum'],
				'brandid'          => 	$_POST['brandid'],
				'descript'         => 	$_POST['descript'],
				//'date'             => 	$_TGLOBAL['timestamp'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'remark'           => 	$_POST['remark'],
				'isone'            => 	$_POST['isone'],
				'usetime'          => 	$_POST['usetime'],
				'useumit'          => 	$_POST['useumit'],


				);
		updatetable('name', $grouparr, array('id' => $id));
		
		
		// 更新物资属性
		foreach($_POST['attrs'] as $key=>$val){
			$attrs = array(
				'nameid'           => 	$id,
				'attrsid'          => 	$key,
				'name'             => 	$val,
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'remark'           => 	'',
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],

					);
			updatetable('name_attr', $attrs, array('nameid' => $id, 'attrsid' => $key, ));
		}
		
		// 更新物资名称
		foreach($_POST['parts'] as $key=>$val){
			$parts = array(
				'nameid'           => 	$id,
				'partsid'          => 	$key,
				'name'             => 	$val,
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'remark'           => 	'',
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],

					);
			updatetable('name_parts', $parts, array('nameid' => $id, 'partsid' => $key, ));	
		}
		
		
		//showmsg('物资属性修改成功！', 'module.php?ac=setting&mod=class_detail&classid='.$classid);
		showmsg('物资属性修改成功！', 'module.php?ac=setting&mod=name');

	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('name')." WHERE id='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
	$storename = getcount('store', array('id'=>$departmentid), 'name');
	
	//取出物资属性
	$name_attrs   = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('name_attr')." WHERE nameid='$id'" ,'attrsid');

	//取出物资配件
	$name_parts  = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('name_parts')." WHERE nameid='$id'" ,'partsid');
}

//取出产品属性和配件
//取出类别属性
$attrs   = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('class_attr')." WHERE classid='$classid'");

//取出类别配件
$parts  = $_TGLOBAL['db']->getall("SELECT * FROM ".tname('class_parts')." WHERE classid='$classid'");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
<script language="JavaScript" src="js/jsAddress.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>物资名录管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="15%" class="caption"><span class="font_red">*</span>类别名称</td>
            <td width="35%"> <?php 
				//$classid = isset($classid) ? $classid : 0 ;
				//echo makeselect((array)$_TGLOBAL['tree_class'],'classid', $classid,'datatype="Require" msg="选择物资类别."','name', 'id','选择物资类别', '', 1) ;
				echo get_pos($classid, $_TGLOBAL['tree_class']); ?>
				<input type="hidden" name="classid" value="<?php echo $classid; ?>">
			</td>
            <td width="15%" class="caption"><span class="font_red">*</span>品牌</td>
            <td width="35%"> <?php 
				$brandid = isset($brandid) ? $brandid : 0 ;
				echo makeselect((array)$_TGLOBAL['brand'],'brandid', $brandid,'datatype="Require" msg="请选择品牌."','name', 'id','选择品牌', '', 1) ;?></td>
          </tr>

        <tr>
          <td class="caption"><span class="font_red">*</span>物资名称</td>
          <td colspan="3"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写属性名称."></td>
        </tr>
		<tr>
          <td class="caption"><span class="font_red">*</span>预警数量</td>
          <td><input name="warnnum" type="text" id="warnnum" value="<?php echo isset($warnnum) ? $warnnum : '' ; ?>" datatype="Integer" msg="请填写物资预警数量." size="20" maxlength="255" ></td>
            <td class="caption"><span class="font_red">*</span>一次性物资</td>
            <td> <?php 
				$isone = isset($isone) ? $isone : 0 ;
				echo makeselect((array)$_TGLOBAL['setting']['isone'],'isone', $isone,'datatype="Require" msg="请选择是否为一次性物资."','', '','请选择', '') ;?></td>
          </tr>
		<tr>
          <td class="caption">有效期</td>
          <td><input name="usetime" type="text" id="usetime" value="<?php echo isset($usetime) ? $usetime : '' ; ?>" size="20" maxlength="255" ></td>
            <td class="caption">有效期单位</td>
            <td> <?php 
				$useumit = isset($useumit) ? $useumit : 0 ;
				echo makeselect((array)$_TGLOBAL['setting']['useumit'],'useumit', $useumit,'datatype="False" msg="请选择有效期."','', '','选择有效期', '0') ;?></td>
          </tr>
		<tr>
			<td class="caption">物资描述</td>
			<td><textarea name="descript" cols="60" rows="4" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
			<td class="caption">备注</td>
			<td><textarea name="remark" cols="60" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
		</tr>
        <tr>
          <td class="caption">创建人</td>
          <td><input name="createname" type="text" id="createname" value="<?php echo $_TGLOBAL['adm_name'] ; ?>" size="50" maxlength="255" disabled /></td>
          <td class="caption">所属仓库</td>
          <td><input name="departmentid" type="text" id="departmentid" value="<?php echo $_TGLOBAL['adm_storename'] ? $_TGLOBAL['adm_storename'] : '' ; ?>" size="50" maxlength="255" disabled /></td>
        </tr>
        </tbody>
      </table>
	  
	  
	  <DIV class=header>物资属性</DIV>
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
		
			<?php 
			$i = 0;
			foreach($attrs as $key=>$val):
				if($i%2 == 0) echo '<tr>';
				
				$str =  isset($name_attrs) && count($name_attrs)==count($attrs) ? $name_attrs[$val['id']]['name'] : '' ;
				echo "<td class=\"caption\" width=\"15%\">$val[name]</td><td width=\"35%\"><input name='attrs[$val[id]]' type='text' datatype=\"Require\" msg=\"请填写$val[name].\" size=\"50\" value=\"".  $str ."\" ></td>";
				
				if($i%2 == 1) echo '</tr>';
				$i++;
			endforeach; ?>
        </tbody>
      </table>
	  
	  <DIV class=header>物资配件</DIV>
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
			<?php 
			$i = 0;
			foreach($parts as $key=>$val):
				if($i%2 == 0) echo '<tr>';
				
				$str =  isset($name_parts) &&  count($name_parts)==count($parts) ? $name_parts[$val['id']]['name'] : '' ;
				echo "<td class=\"caption\" width=\"15%\">$val[name]</td><td width=\"35%\"><input name='parts[$val[id]]' type='text' datatype=\"Integer\" msg=\"请填写{$val['name']}数量.\" size=\"50\" value=\"". $str ."\" ></td>";
				
				if($i%2 == 1) echo '</tr>';
				$i++;
			endforeach; ?>
        </tbody>
      </table>
	  
	  
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td class="caption">&nbsp;</td>
            <td ><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="userid" type="hidden" id="id" value="<?php echo $_TGLOBAL['adm_userid']; ?>">
			<input name="usage" type="hidden" id="usage" value="1">
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>