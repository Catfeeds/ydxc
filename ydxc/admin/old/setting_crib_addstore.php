<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

//权限检查
checkpermission(''); //权限检查
loadcache('store'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目
loadcache('crib'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {

	$storeid = isset($_POST['storeid']) ? (int)$_POST['storeid'] : 0 ;

	//判断 是否子级存在
	if($storeid){
		$list  = $_TGLOBAL['db']->getall("SELECT NULL FROM ".tname('store')." WHERE pid='$storeid' ");
		
		if ($list) {
			showmsg('一级仓库不能添加垛位！！', 'module.php?ac=setting&mod=crib_addstore');
		}else{
			header("Location: module.php?ac=setting&mod=crib_add&storeid=$storeid"); 
		}
	}
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['tree_crib'][$id];
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
  <DIV class=header>选择所属仓库</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="30%" class="caption">选择所属仓库</td>
          <td width="70%"><?php 
				$tree['storeid'] = isset($tree['storeid']) ? $tree['storeid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_store'],'storeid', $tree['storeid'],'datatype="Require" msg="请选择所属仓库."','name', 'id','请选择仓库', '', 1) ;?></td>
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
