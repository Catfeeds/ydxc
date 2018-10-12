<?php
/*
	[TOUR] (C) 2007-2009 
	$Id: news_class_work.php 2009-6-14 17:55:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

$mod = 'partner_class';
//权限检查
checkpermission('', 'class'); //权限检查
loadcache('partner_class'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

include_once(S_ROOT.'./lib/function/function_cache.php');

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;

	//判断 父级 是否存在
	if($_POST['pid']){
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('partner_class')." WHERE id='$_POST[pid]' AND id<>$id");
		if (!$list=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('父级不存在，请检查是不是将自己作为父级了！');
		}	
	}
	
	
	if ($id <= 0) { //添加

		$classarr = array(
				'name'			  => 	trim($_POST['name']),
				'template'		  =>	$_POST['template'],
				'jumpto'		  =>	$_POST['jumpto'],
				'isnew'         => 	$_POST['isnew'],
				'name'         => 	$_POST['name'],
				'pid'          => 	$_POST['pid'],
				'orderlist'    => 	$_POST['orderlist'],
				'is_hidden'    => 	$_POST['is_hidden'],
				);
		inserttable('partner_class', $classarr);
		makecache('partner_class','id', '', 'orderlist', 1); //缓存
		showmsg('类别添加成功！', 'module.php?ac=partner&mod=class&class_id='.$_POST['class_id']);

	} else { //更新

		$classarr = array(
				'name'			  => 	trim($_POST['name']),
				'template'		  =>	$_POST['template'],
				'jumpto'		  =>	$_POST['jumpto'],
				'isnew'         => 	$_POST['isnew'],
				'name'         => 	$_POST['name'],
				'pid'          => 	$_POST['pid'],
				'orderlist'    => 	$_POST['orderlist'],
				'is_hidden'    => 	$_POST['is_hidden'],
				);
		updatetable('partner_class', $classarr, array('id' => $id));
		makecache('partner_class','id', '', 'orderlist', 1); //缓存
		showmsg('类别修改成功！', 'module.php?ac=partner&mod=class&class_id='.$_POST['class_id']);

	}
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['tree_partner_class'][$id];
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
  <DIV class=header>类别管理</DIV>
  <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
    <table border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
      <tbody>
        <tr>
          <td width="30%" class="caption">父级</td>
          <td width="70%"><?php 
				$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_partner_class'],'pid', $tree['pid'],'datatype="Require" msg="请选择父级菜单."','name', 'id','作为一级菜单', '0', 1) ;?></td>
        </tr>
        <tr>
          <td width="30%" class="caption">类别名称</td>
          <td width="70%"><input name="name" type="text" id="name" value="<?php echo isset($tree['name']) ? $tree['name'] : '' ; ?>" size="20" maxlength="255" datatype="Require" msg="请填写类别名称."></td>
        </tr>
        <tr>
          <td class="caption">转跳</td>
          <td><input name="jumpto" type="text" id="jumpto" value="<?php echo isset($tree['jumpto']) ? $tree['jumpto'] : ''; ?>" size="80" maxlength="255"></td>
        </tr>
        <tr>
          <td class="caption">显示顺序</td>
          <td><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="20" maxlength="10">
            数字，值越大，越在前面</td>
        </tr>
        <tr>
          <td class="caption">前台显示方式</td>
          <td><?php 
				$template = isset($tree['template']) ? $tree['template'] : '';
				echo  GetSelect((array)$_TGLOBAL['setting']['class_template'], 'template', $template); ?></td>
        </tr>
	  <!--<tr>
		<td class="caption">是否隐藏</td>
		<td><input name="is_hidden" type="checkbox" id="is_hidden" <?php if(isset($tree['is_hidden'])){echo 'checked'; }  ?> value="1"></td>
	  </tr>-->
		<tr>
			<td class="caption">新开窗口</td>
			<td><input name="isnew" type="checkbox" id="isnew" <?php if(isset($tree['isnew'])){echo 'checked'; }  ?> value="1">是</td>
		</tr>
        <tr>
          <td class="caption">&nbsp;</td>
          <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="usage" type="hidden" id="usage" value="1">
            <input name="class_id" type="hidden" id="class_id" value="<?php echo $_GET['class_id']; ?>"></td>
        </tr>
      </tbody>
    </table>
  </form>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>
