<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user_work.php 2009-8-5 15:07:33 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
checkpermission('', 'menu'); //权限检查
loadcache('menu','id', '', 'orderlist', 1); // 加载缓存树状菜单
include_once(S_ROOT . '/lib/function/function_cache.php');


if (isset($_POST['usage'])) {
	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	//判断 父级 是否存在
	if($_POST['pid']){
		$query  = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('menu')." WHERE id='$_POST[pid]' AND id <> $id ");
		if (!$list=$_TGLOBAL['db']->fetch_array($query)) {
			showmsg('父级不存在，请检查是不是将自己作为父级了！');
		}		
	}

	
	if ($id <= 0) { //添加
		$menuarr = array(
				'name'         => 	$_POST['name'],
				'mod'          => 	trim($_POST['mod']),
				'ac'           => 	trim($_POST['ac']),
				'pid'          => 	$_POST['pid'],
				'orderlist'    => 	$_POST['orderlist'],
				'is_hidden'    => 	$_POST['is_hidden'],
				);
		inserttable('menu', $menuarr);
		makecache('menu','id', '', 'orderlist'); // 后台菜单缓存
		makecache('menu','id', '', 'orderlist', 1); // 后台菜单缓存
		showmsg('菜单添加成功！', 'module.php?ac=system&mod=menu');

	} else { //更新

		$menuarr = array(
				'name'         => 	$_POST['name'],
				'mod'          => 	trim($_POST['mod']),
				'ac'           => 	trim($_POST['ac']),
				'pid'          => 	$_POST['pid'],
				'orderlist'    => 	$_POST['orderlist'],
				'is_hidden'    => 	$_POST['is_hidden'],
				);

		updatetable('menu', $menuarr, array('id' => $id));
		makecache('menu','id', '', 'orderlist'); // 后台菜单缓存
		makecache('menu','id', '', 'orderlist', 1); // 后台菜单缓存
		showmsg('菜单修改成功！', 'module.php?ac=system&mod=menu');
	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$tree = $_TGLOBAL['menu'][$id];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
<SCRIPT language=JavaScript src="js/validator.js"></SCRIPT>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>菜单管理</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="22%" class="caption">父级菜单</td>
            <td width="78%"><?php 
					$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
					echo makeselect($_TGLOBAL['tree_menu'],'pid', $tree['pid'],'datatype="Require" msg="请选择父级菜单."','name', 'id','作为一级菜单', '0', 1);
			
			?></td>
          </tr>
          <tr>
            <td width="22%" class="caption">菜单名称</td>
            <td width="78%"><input name="name" type="text" id="name" value="<?php echo isset($tree['name']) ? $tree['name'] : ''; ?>" size="50" maxlength="50" datatype="Require" msg="请填写菜单名称." ></td>
          </tr>
          <tr>
            <td width="22%" class="caption">模型</td>
            <td width="78%"><input name="mod" type="text" id="mod" value="<?php echo isset($tree['mod']) ? $tree['mod'] : '' ; ?>" size="50" maxlength="50" datatype="Require" msg="请填写模型."></td>
          </tr>
          <tr>
            <td width="22%" class="caption">方法</td>
            <td width="78%"><input name="ac" type="text" id="ac" value="<?php echo isset($tree['ac']) ? $tree['ac'] : '' ; ?>" size="50" maxlength="50" ></td>
          </tr>
          <tr>
            <td width="22%" class="caption">显示顺序</td>
            <td width="78%"><input name="orderlist" type="text" id="orderlist" value="<?php echo isset($tree['orderlist']) ? $tree['orderlist'] : ''; ?>" size="50" maxlength="50" ></td>
          </tr>
          <tr>
            <td width="22%" class="caption">是否隐藏</td>
            <td width="78%"><input name="is_hidden" type="checkbox" id="is_hidden" <?php if(isset($tree['is_hidden']) && $tree['is_hidden']==1 ){echo 'checked'; }  ?> value="1"></td>
          </tr>
          <tr>
            <td class="caption">&nbsp;</td>
            <td><input name="button" type="submit" class="button" id="button" value="提交">
            <input name="id" type="hidden" id="id" value="<?php echo $id; ?>">
            <input name="usage" type="hidden" id="usage" value="1"></td>
          </tr>
        </tbody>
      </table>
    </form>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>