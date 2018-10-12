<?php /* Smarty version 2.6.22, created on 2016-11-28 08:35:14
         compiled from baoming.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'baoming.html', 11, false),)), $this); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->_tpl_vars['_TCONFIG']['sitename']; ?>
</title>
    <link href="css/zt.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/zt.js"></script>
		
	<meta name="Keywords" content="<?php echo $this->_tpl_vars['_TCONFIG']['keywords']; ?>
"/>
	<meta name="description" content="<?php echo ((is_array($_tmp=$this->_tpl_vars['_TCONFIG']['description'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>
"/>
</head>
<body>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "header.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<div class="body">
    <div class="position">
        <div class="icon_postion">
            <img src="images/icon1.png" width="40" height="32">
        </div>
        <div class="msg_position">
            > 重庆鼎吉驾校 >  <?php echo $this->_tpl_vars['curr_class']; ?>

        </div>
    </div>
    <div class="content">
        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "left.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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
									<?php $_from = $this->_tpl_vars['_TGLOBAL']['course']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
										<option value="<?php echo $this->_tpl_vars['item']['id']; ?>
"><?php echo $this->_tpl_vars['item']['name']; ?>
</option>
									<?php endforeach; endif; unset($_from); ?>
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
								<!--<?php echo $this->_tpl_vars['select_sex']; ?>

								<input type="text" name="sex" placeholder="性别" datatype="Require" msg="请填写性别.">-->
								<select name="sex" datatype="Require" msg="请选择性别。" style="padding:0px; height:45px; width:241px; line-height: 40px; font-size:18px; border:1px solid #ccc;">
									<option value="">请选择性别</option>
									<?php $_from = $this->_tpl_vars['_TGLOBAL']['setting']['sex']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
?>
										<option value="<?php echo $this->_tpl_vars['key']; ?>
"><?php echo $this->_tpl_vars['item']; ?>
</option>
									<?php endforeach; endif; unset($_from); ?>
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
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
</body>
</html>