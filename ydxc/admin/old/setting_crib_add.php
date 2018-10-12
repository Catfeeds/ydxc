<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
loadcache('store'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目
loadcache('crib'  ,'storeid', 'id', 'orderlist', 1);   // 加载缓存树状栏目
//loadcache('crib'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	//判断 父级 是否存在
	if($_POST['pid']){
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('crib')." WHERE id='$_POST[pid]' AND id<>$id");
		if (!$list=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('父级垛位不存在，请检查是不是将自己作为父级了！');
		}		
	}
	
	if ($id <= 0) { //添加

		$classarr = array(
				'storeid'              => 	$_POST['storeid'],
				'graded'               => 	$_POST['graded'],
				'pid'              => 	$_POST['pid'],
				'name'             => 	$_POST['name'],
				//'barcode'          => 	$_POST['barcode'],
				'descript'         => 	$_POST['descript'],
				'date'             => 	$_TGLOBAL['timestamp'],
				'createname'       => 	$_TGLOBAL['adm_name'],
				'departmentid'     => 	$_TGLOBAL['adm_storeid'],
				'userid'           => 	$_TGLOBAL['adm_userid'],
				'orderlist'        => 	$_POST['orderlist'],
				);
		$cribid = inserttable('crib', $classarr, 1);
		
		// 更新编号、条形码
		$crib['no']      = str_repeat(0,3 - strlen($cribid)).$cribid;
		$store      = str_repeat(0,3 - strlen($_POST['storeid'])).$_POST['storeid'];
		$crib['barcode'] = makeno('crib', 'barcode', 11, 'dc'.$store.'d'.$crib['no']);
		updatetable('crib', $crib, array('id' => $cribid));
		
		//储存条形码
		$barcodearr = array(
					'itype'            => 	2,
					'num'              => 	20,
					'barcode'          => 	$crib['barcode'],
					'name'             => 	$_POST['name'],
					'isused'           => 	1,
					'departmentid'     => 	$_TGLOBAL['adm_storeid'],
					'userid'           => 	$_TGLOBAL['adm_userid'],
					'createname'       => 	$_TGLOBAL['adm_name'],
					'date'             => 	$_TGLOBAL['timestamp'],
						);
		inserttable('barcode', $barcodearr);
		
		//makecache('crib','id', '', 'orderlist', 1); //缓存
		makecache('crib','storeid', 'id', 'orderlist', 1); //缓存
		showmsg('垛位添加成功！', 'module.php?ac=setting&mod=crib&storeid='.$_POST['storeid']);

	} else { //更新

		$classarr = array(
				'storeid'              => 	$_POST['storeid'],
				'graded'               => 	$_POST['graded'],
				'pid'              => 	$_POST['pid'],
				'name'             => 	$_POST['name'],
				//'barcode'          => 	$_POST['barcode'],
				'descript'         => 	$_POST['descript'],
				//'date'             => 	$_POST['date'],
				//'createname'       => 	$_TGLOBAL['adm_name'],
				//'departmentid'     => 	$_TGLOBAL['adm_cribid'],
				//'userid'           => 	$_TGLOBAL['adm_userid'],
				'orderlist'        => 	$_POST['orderlist']
				);
		updatetable('crib', $classarr, array('id' => $id));
		makecache('crib','storeid', 'id', 'orderlist', 1); //缓存
		showmsg('垛位修改成功！', 'module.php?ac=setting&mod=crib&storeid='.$_POST['storeid']);

	}
}



//取出修改时的信息
$storeid = isset($_GET['storeid']) ? (int)$_GET['storeid'] : 0 ;
!$storeid && header("Location: module.php?ac=setting&mod=crib_addstore"); //如果没有指定仓库，先选择仓库
$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['tree_crib'][$storeid][$id];
	$storename = getcount('store', array('id'=>$tree['departmentid']), 'name');
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>TOUR V1.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 97%">
  <DIV class=header>垛位管理</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><?php 
				/*$tree['storeid'] = isset($tree['storeid']) ? $tree['storeid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_store'],'storeid', $tree['storeid'],'datatype="Require" msg="请选择所属仓库."','name', 'id','请选择仓库', '', 1) ;*/
				echo  get_pos($storeid, $_TGLOBAL['tree_store']);
				?>
				<input name="storeid" type="hidden" id="storeid" value="<?php echo $storeid; ?>">
				</td>
        </tr>
        <tr>
          <td width="30%" class="caption">父级垛位</td>
          <td width="70%"><?php 
				$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
				echo @makeselect((array)$_TGLOBAL['tree_crib'][$storeid],'pid', $tree['pid'],'datatype="Require" msg="请选择父级垛位."','name', 'id','作为一级垛位', '0', 1) ;?></td>
        </tr>
        <tr>
          <td width="30%" class="caption"><span class="font_red">*</span>垛位名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($tree['name']) ? $tree['name'] : '' ; ?>" size="50" maxlength="255" datatype="Require" msg="请填写垛位名称."></td>
        </tr>
        <tr>
          <td width="30%" class="caption">垛位级别</td>
          <td width="70%"><?php 
				$tree['graded'] = isset($tree['graded']) ? $tree['graded'] : 0 ;
				echo makeselect($_TGLOBAL['setting']['crib_graded'],'graded', $tree['graded'],'datatype="Require" msg="请选择垛位级别."','', '','请选择垛位级别', '0') ;?></td>
        </tr>
        <tr>
          <td width="30%" class="caption">垛位条形码</td>
          <td width="70%"><input name="barcode" type="text" id="barcode" value="<?php echo isset($tree['barcode']) ? $tree['barcode'] : '' ; ?>" size="50" maxlength="255" disabled />（后台自动生成）</td>
        </tr>
        <!--<tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>-->
		<tr>
			<td class="caption">描述</td>
			<td><textarea name="descript" cols="38" rows="4" id="descript"><?php echo isset($tree['descript']) ? $tree['descript'] : ''; ?></textarea></td>
		</tr>
        <tr>
          <td width="30%" class="caption">创建人</td>
          <td width="70%"><input name="createname" type="text" id="createname" value="<?php echo $_TGLOBAL['adm_name'] ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
        <tr>
          <td width="30%" class="caption">所属仓库</td>
          <td width="70%"><input name="cribid" type="text" id="cribid" value="<?php echo $_TGLOBAL['adm_storename'] ? $_TGLOBAL['adm_storename'] : '' ; ?>" size="20" maxlength="255" disabled /></td>
        </tr>
		
		
	
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
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
