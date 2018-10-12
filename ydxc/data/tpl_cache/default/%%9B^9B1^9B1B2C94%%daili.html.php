<?php /* Smarty version 2.6.22, created on 2016-11-28 21:06:59
         compiled from daili.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'daili.html', 11, false),)), $this); ?>
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
                代理中心
            </div>
            <div class="content_right">
                <div class="form">
				<form action="" method="post" onSubmit="return Validator.Validate(this,3)">
                    <table>
                        <tr>
                            <td align="right">姓名：</td>
                            <td><input name="name" type="text" datatype="Require" msg="请填写姓名."></td>
                        </tr>
                        <tr>
                            <td align="right">证件类型：</td>
                            <td>
                                <select name="card">
                                    <option value="身份证">身份证</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">证件号码：</td>
                            <td><input name="cardno" type="text" datatype="Require" msg="请填写证件号码."></td>
                        </tr>
                        <tr>
                            <td align="right">联系电话：</td>
                            <td><input name="tel" type="text" datatype="Require" msg="请填写联系电话."></td>
                        </tr>
                        <tr>
                            <td align="right">手机：</td>
                            <td><input name="mobile" type="text" datatype="Require" msg="请填写手机."></td>
                        </tr>
                        <tr>
                            <td align="right">QQ：</td>
                            <td><input name="qq" type="text" datatype="Require" msg="请填写QQ."></td>
                        </tr>
                        <tr>
                            <td align="right">区域：</td>
                            <td><input name="area" type="text" datatype="Require" msg="请填写区域."></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td align="center">
								<input type="submit" style="height:40px;width:230px;margin-left:-120px;" >
								<input type="hidden" name="daili" value="1">
							</td>
                        </tr>
                        <tr>
                            <td style="height:30px;"></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td align="left" class="msg" colspan="2">
                                代理要求：<br/>
                                本公司面对社会招收代理人员，经过简单程序即可成为本公司代理，不管你是从事什么行业，什么年龄，只要你想赚钱，提升自己，都可以成为我们的招生代理，享受高额提成和福利待遇。<br/>
                                合法公民、热爱驾培这个行业、价值观端正、热爱本公司
                            </td>
                        </tr>
                        <tr>
                            <td align="left" class="msg" colspan="2">注意：客服会尽快与您取得联系</td>
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