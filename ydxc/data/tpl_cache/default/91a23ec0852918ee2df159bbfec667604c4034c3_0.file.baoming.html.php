<?php
/* Smarty version 3.1.30, created on 2017-09-01 17:06:55
  from "/data/www/ydxc/ydxc/template/default/baoming.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a9232f1b4759_62231845',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91a23ec0852918ee2df159bbfec667604c4034c3' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/baoming.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:left.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_59a9232f1b4759_62231845 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/ydxc/lib/smarty/plugins/modifier.nl2br.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitename'];?>
</title>
    <link href="css/zt.css" rel="stylesheet" type="text/css">
    <?php echo '<script'; ?>
 type="text/javascript" src="js/jquery-1.9.1.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 type="text/javascript" src="js/zt.js"><?php echo '</script'; ?>
>
		
	<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['keywords'];?>
"/>
	<meta name="description" content="<?php echo smarty_modifier_nl2br($_smarty_tpl->tpl_vars['_TCONFIG']->value['description']);?>
"/>
</head>
<body>
<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
<div class="body">
    <div class="position">
        <div class="icon_postion">
            <img src="images/icon1.png" width="40" height="32">
        </div>
        <div class="msg_position">
            > 重庆鼎吉驾校 >  <?php echo $_smarty_tpl->tpl_vars['curr_class']->value;?>

        </div>
    </div>
    <div class="content">
        <?php $_smarty_tpl->_subTemplateRender("file:left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
        <div class="right">
            <div class="title_right">
                我要报名
            </div>
            <div class="content_right ">
				<form action="" method="post" onSubmit="return Validator.Validate(this,3)">
					<div>
						<div class="box">
							<span>
								<!--<input type="text" name="courseid" placeholder="选择班级" datatype="Require" msg="请选择班级.">-->
								<select name="courseid" datatype="Require" msg="请选择班级。" style="padding:0px;height:45px; width:241px; line-height: 40px; font-size:18px; border:1px solid #ccc;">
									<option value="">请选择班级</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['course'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</span>
						</div>
						<div class="box">
							<span><input type="text" name="num" placeholder="报名人数" datatype="Integer" msg="请填写报名人数."></span>
						</div>
						<div class="box">
							<span><input type="text" name="name" placeholder="姓名" datatype="Require" msg="请填写姓名."></span>
						</div>
						<div class="box">
							<span>
								<!--<?php echo $_smarty_tpl->tpl_vars['select_sex']->value;?>

								<input type="text" name="sex" placeholder="性别" datatype="Require" msg="请填写性别.">-->
								<select name="sex" datatype="Require" msg="请选择性别。" style="padding:0px; height:45px; width:241px; line-height: 40px; font-size:18px; border:1px solid #ccc;">
									<option value="">请选择性别</option>
									<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['setting']['sex'], 'item', false, 'key');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
										<option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
									<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

								</select>
							</span>
						</div>
						<div class="box">
							<span>
								<!--<input type="text" name="card" placeholder="证件类型" datatype="Require" msg="请填写证件类型.">-->
								<select name="card" datatype="Require" msg="请选择证件类型。" style="padding:0px;height:45px; width:241px; line-height: 40px; font-size:18px; border:1px solid #ccc;">
									<option value="身份证">身份证</option>
								</select>
							</span>
						</div>
						<div class="box">
							<span><input type="text" name="cardno" placeholder="证件号码" datatype="IdCard" msg="请填写身份证号码."></span>
						</div>
						<div class="box">
							<span><input type="text" name="tel" placeholder="联系电话" datatype="Require" msg="请填写电话号码."></span>
						</div>
						<div class="box">
							<span><input type="text" name="mobile" placeholder="手机" datatype="Mobile" msg="请填写手机号码."></span>
						</div>
						<!--<div class="box">
							<span><input type="text" name="area" placeholder="区域"></span>
						</div>
						<div class="box">
							<span><input type="text" name="point" placeholder="服务点"></span>
						</div>-->
						<div class="box">
							<span><input type="text" name="qq" placeholder="QQ" datatype="Require" msg="请填写QQ号码."></span>
						</div>
					</div>
					<div style="clear: both">
						<textarea name="remark" id="" cols="30" rows="10" placeholder="咨询内容或备注"></textarea>
					</div>
					<div>
						<input type="submit" class="sub">
						<input type="hidden" name="sign" value="1">
					</div>
				</form>
                <div class="bmtitle">
                    报名条件
                </div>
                <div class="bmtj">
                    <p>1、培训范围;C1、C2</p>
                    <p>2、招生范围：全国招生</p>
                    <p>3、年龄;C1、C2牌18-70周岁</p>
                    <p>4、身高;C1、C2牌不限身高</p>
                    <p>5、视力;C1、C2≥4.9（矫正）</p>
                    <p>6、左下肢残缺允许报C2牌</p>
                    <p>7、辩色率无红绿色弱/色盲</p>
                </div>
                <div class="bmtitle">
                    所需资料
                </div>
                <div class="bmtj">
                    <p>非深户;有效居住证复印件一份</p>
                    <p>现役军人（含武警）：军官证复印件、团级以上单位出具的申请人现实际驻地的住址证明、团级以上医疗机构的出具的身份检查结果 增驾元驾证复印件（正、副本）1份</p>
                </div>
                <div class="bmtitle">
                    特别提示
                </div>
                <div class="bmtj">
                    <p style="color:red">
                        为明确学校和学员的权利和义务，请各位学员朋友详细阅读并与学校签订《驾驶培训协议书》以保障双方的权益
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</body>
</html><?php }
}
