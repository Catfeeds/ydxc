<?php
/*
	[CTB] (C) 2007-2009 
	$Id: admin_role_work.php 2010-1-12 15:12:00 jerry $
*/

!defined('IN_CTB') && die('Access Denied');
checkpermission('', 'role'); //权限检查
include_once(S_ROOT.'./lib/function/function_cache.php');


if (isset($_POST['usage'])) {

	$id = isset($_POST['id']) ? (int)$_POST['id'] : 0 ;
	
	//添加 或 删除角色
	if ($id <= 0) { //添加
		$arr = array(
				'name'             => 	$_POST['name'],
				'remark'           => 	$_POST['remark'],
				);
		$id = inserttable('admin_role', $arr, 1);
		//admin_role_cache();
		$result = '系统角色添加成功！';

	} else { //更新
		$arr = array(
				'name'             => 	$_POST['name'],
				'remark'           => 	$_POST['remark'],
				);
		updatetable('admin_role', $arr, array('id' => $id));
		//admin_role_cache();
		$result = '系统角色修改成功！';

	}
	
	//改变这个角色权限
	//删除此角色的所有
	$_TGLOBAL['db']->query("DELETE FROM ".tname('admin_role_priv')." WHERE role_id='$id'");
	
	// 如果有传值过来
	if(is_array($_POST['power_module'])){
		foreach($_TGLOBAL['menu'] as $kk => $vv){
			//插入二级栏目
			foreach($_POST['power_module'] as $k => $v){
				if(in_array($vv['id'],$v)){
					$arr = array(
						'role_id'          => 	$id,
						'menu_id'          => 	$vv['id'],
						'mod'              => 	$vv['mod'],
						'ac'               => 	$vv['ac'],
						);
					inserttable('admin_role_priv', $arr, 0, 1); //插入二级栏目
				}
			}
			
			//插入一级栏目
			if(isset($_POST['power_module'][$vv['mod']]) && $vv['pid']==0){
				$arr = array(
					'role_id'          => 	$id,
					'menu_id'          => 	$vv['id'],
					'mod'              => 	$vv['mod'],
					'ac'               => 	$vv['ac'],
					);
				inserttable('admin_role_priv', $arr, 0, 1); //插入一级栏目
			}
		}
	}
	makecache('admin_role_priv','role_id', 'menu_id'); // 后台管理员权限
	showmsg($result, 'module.php?ac=system&mod=role');
}



//取出修改时的信息
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0 ;
if ($id > 0) {
	// 角色缓存文件 data_admin_role.php
	// 缓存角色 $_TGLOBAL['admin_role'][$id]
	extract((array)$_TGLOBAL['db']->fetch_array($query));
}

/*
 // 在 module.php 已经做了组合菜单
foreach($_TGLOBAL['menu'] as $key=>$val){
	if($val['pid']==0){
		$top_menu[] = $val; //组合一级菜单
	}else{
		$left_menu[] = $val; //组合二级菜单
	}
}*/


//取出角色权限
if ($id) {
	$role_sql = "SELECT * FROM ".tname('admin_role')." WHERE id='$id'" ;
	extract($_TGLOBAL['db']->getrow($role_sql));
	$role_sql = "SELECT * FROM ".tname('admin_role_priv')." WHERE role_id='$id'" ;
	$roles    = $_TGLOBAL['db']->getall($role_sql, 'menu_id');
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
<style type="text/css">
<!--
.tab_01 td {
	text-align:left;
}
-->
</style>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <a href=\'module.php?ac=<?php echo $ac; ?>&mod=<?php echo $mod; ?>\' target=\'main\'><?php echo $_TGLOBAL['menu'][$ac][$mod]; ?></a> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 97%">
    <DIV class=header>系统角色</DIV>
    <form  method="post" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
      <table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" class="tab_01">
        <tbody>
          <tr>
            <td width="14%" class="caption">角色名称</td>
            <td width="86%"><input name="name" type="text" id="name" value="<?php echo isset($name) ? $name : ''; ?>" size="50" maxlength="255" datatype="Require" msg="请填写角色名称."></td>
          </tr>
          <tr>
            <td class="caption">权限列表</td>
            <td> <input type="checkbox" name="chkall20" id="chkall20" value="on" onClick="CheckAllPower(this.form,this.checked, 'power')">
          <label for="chkall20">全选</label>
<?php
$str = "<table width=\"100%\" border=\"0\">\n";
$i = 0;
foreach($top_menu AS $key => $val) {
	$str .= "<tr>\n";
	if (isset($roles) && is_array($roles)) {
		$checked = array_key_exists($val['id'], $roles) ? 'checked' : '';
	}else{
		$checked = '' ;
	}
	
	$str .= "<td width=\"12%\"><input name=\"power[]\" type=\"checkbox\" id=\"power_{$val['mod']}\" value=\"{$val['id']}\" {$checked}  onClick=\"CheckAllPower(this.form,this.checked, 'power_module[{$val['mod']}]')\">";
	$str .= "<label for=\"power_{$val['mod']}\">".$val['name']."</label></td>\n";
	$str .= "<td>";
	
	foreach($left_menu AS $k => $v) {
		if (!$v) continue;
		if ($v['mod'] != $val['mod']) continue;
		
		if (isset($roles) && is_array($roles)) {
			$checked = array_key_exists($v['id'], $roles) ? 'checked' : '';	
		}else{
			$checked = '' ;
		}

		$str .= "<label><input name=\"power_module[{$val['mod']}][]\" type=\"checkbox\" id=\"power_{$val['mod']}_{$v['mod']}\" value=\"{$v['id']}\"  {$checked}>{$v['name']}</label>\n";
	}
	
	$str .= "</td>\n";
	$str .= '</tr>'."\n";
	$i++;
}
$str .= '</table>'."\n";

echo $str;
?>
            </td>
          </tr>
          <tr>
            <td class="caption">备注</td>
            <td><textarea name="remark" cols="30" rows="4" id="remark"><?php echo isset($remark) ? $remark : ''; ?></textarea></td>
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
<script language="Javascript">
function CheckAllPower(form,flag, prefix)
  {
  for (var i=0;i<form.elements.length;i++)
    {
    var e = form.elements[i];
    if (e.name.substring(0, prefix.length) == prefix)
       e.checked = flag;
    }
  }
</script>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>