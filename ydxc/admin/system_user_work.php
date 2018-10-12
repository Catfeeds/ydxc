<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: system_user_work.php 2009-8-5 15:07:33 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(''); //权限检查
//loadcache('store'  ,'id', '', 'orderlist', 1);   // 加载缓存树状栏目

if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	//$zone_id_new = join(',', $_POST['business_zone_id']);
	
	$query = $_TGLOBAL['db']->query("SELECT NULL FROM ".tname('admin') . " WHERE username ='$_POST[username]'");
	if ($userinfo = $_TGLOBAL['db']->fetch_array($query)) {
		showmsg('人员帐号已经存在，请重新填写！');
	}

	if ($id <= 0) { //添加

		$adminarr = array(
				'username'         => 	$_POST['username'],
				//'name'             => 	$_POST['name'],
				'password'         => 	md5($_POST['password']),
				'descript'         => 	$_POST['descript'],
				'role_id'          => 	$_POST['role_id'],
				//'storeid'          => 	$_POST['storeid'],
				'times'            => 	0,
				);
		inserttable('admin', $adminarr);
		showmsg('管理员添加成功！', 'module.php?ac=system&mod=user');

	} else { //更新

		  $adminarr = array();	  
		  $password = $_POST['password'];
		  //如果密码不为空
		  if ($password) {
				$password = md5($password);//密码加密
				$adminarr['password'] = $password;
		  }
		  $adminarr ['role_id']			 = $_POST['role_id'];
		  $adminarr ['descript']		 = $_POST['descript'];
		  //$adminarr ['name']		     = $_POST['name'];
		  //$adminarr ['storeid']		     = $_POST['storeid'];

		updatetable('admin', $adminarr, array('userid' => $id));
		showmsg('管理员修改成功！', 'module.php?ac=system&mod=user');
	}
}

//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('admin')." WHERE userid='$id'");
	extract((array)$_TGLOBAL['db']->fetch_array($query));
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
    <DIV class=header>管理员维护</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          
          <tr>
            <td width="22%" class="caption">管理员帐号</td>
            <td width="78%"><input name="username" type="text" id="username" value="<?php echo isset($username) ? $username : ''; ?>" size="50" maxlength="50" datatype="Require" msg="请填写管理员帐号." <?php echo (isset($id) && $id>0) ? 'disabled' : ''; ?>></td>
          </tr>
          <!--<tr>
            <td width="22%" class="caption">管理员姓名</td>
            <td width="78%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="50" datatype="Require" msg="请填写管理员姓名." ></td>
          </tr>
        <tr>
          <td width="30%" class="caption"><span class="font_red">*</span>父级仓库</td>
          <td width="70%"><?php 
				$tree['pid'] = isset($tree['pid']) ? $tree['pid'] : 0 ;
				echo makeselect((array)$_TGLOBAL['tree_store'],'storeid', isset($storeid) ? $storeid : 0 ,'datatype="Require" msg="请选择父级仓库."','name', 'id','作为一级仓库', '0', 1) ;?></td>
        </tr>-->
          <tr>
            <td class="caption">密码</td>
            <td><input name="password" type="password" id="password" size="50" maxlength="50">
              为空则不修改</td>
          </tr>
          <tr>
            <td class="caption">用户角色</td>
            <td>
<?php
$role_id = isset($role_id) ? $role_id : '';
echo GetSelect((array)$_TGLOBAL['admin_role'], 'role_id', $role_id, 'name');
?> &nbsp;&nbsp;<a href="module.php?ac=system&mod=role">维护用户角色</a> &nbsp;&nbsp;不同的角色拥有不同的系统功能</td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td><textarea name="descript" cols="30" rows="4" id="descript"><?php echo isset($descript) ? $descript : ''; ?></textarea></td>
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