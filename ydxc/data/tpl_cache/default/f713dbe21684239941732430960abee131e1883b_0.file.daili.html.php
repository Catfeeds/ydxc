<?php
/* Smarty version 3.1.30, created on 2017-09-11 17:19:36
  from "/data/www/ydxc/ydxc/template/default/daili.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b65528becb00_00595256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f713dbe21684239941732430960abee131e1883b' => 
    array (
      0 => '/data/www/ydxc/template/default/daili.html',
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
function content_59b65528becb00_00595256 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_nl2br')) require_once '/data/www/ydxc/lib/smarty/plugins/modifier.nl2br.php';
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
            > 重庆鼎吉驾校 > <?php echo $_smarty_tpl->tpl_vars['curr_class']->value;?>

        </div>
    </div>
    <div class="content">
        <?php $_smarty_tpl->_subTemplateRender("file:left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
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
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</body>
</html><?php }
}
