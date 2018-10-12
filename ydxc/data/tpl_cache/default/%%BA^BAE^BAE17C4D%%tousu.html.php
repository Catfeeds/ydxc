<?php /* Smarty version 2.6.22, created on 2016-11-28 23:56:45
         compiled from tousu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'tousu.html', 11, false),)), $this); ?>
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
            > 重庆鼎吉驾校 > <?php echo $this->_tpl_vars['curr_class']; ?>

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
                我要投诉
            </div>
            <div class="content_right">
                <div style="letter-spacing: 1px;line-height: 25px;">如果您有什么问题或者对我们的服务有什么意见请在这里跟我们提出！也可以画上您宝贵的两分钟提交您的需求，感谢新老客户对我们的信赖与支持，我们将竭诚为您服务！</div>
                <div class="form">
				<form action="" method="post" onSubmit="return Validator.Validate(this,3)">
                    <table>
                        <tr>
                            <td align="right">问题：</td>
                            <td><input name="title" type="text" datatype="Require" msg="请填写问题."><span style="color:red">*</span></td>
                        </tr>
                        <tr>
                            <td align="right">内容：</td>
                            <td>
                                <textarea name="remark" id="" style="width:370px;height:100px;" cols="30" rows="10" datatype="Require" msg="请填写投诉内容."></textarea><span style="color:red">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">联系人：</td>
                            <td><input name="name" type="text" datatype="Require" msg="请填写联系人."><span style="color:red">*</span></td>
                        </tr>
                        <tr>
                            <td align="right">联系方式：</td>
                            <td><input name="tel" type="text" datatype="Require" msg="请填写联系方式."><span style="color:red">*</span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="left">
								&nbsp;&nbsp;<input type="submit"  style="height:40px;width:230px;">
								<input type="hidden" name="tousu" value="1">
							</td>
                        </tr>
                    </table>
					</form>
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