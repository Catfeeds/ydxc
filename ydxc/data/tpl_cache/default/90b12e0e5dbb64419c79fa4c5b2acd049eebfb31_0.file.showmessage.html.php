<?php
/* Smarty version 3.1.30, created on 2017-09-10 18:09:44
  from "/data/www/ydxc/ydxc/template/default/showmessage.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59b50f6849aae4_78068372',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '90b12e0e5dbb64419c79fa4c5b2acd049eebfb31' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/showmessage.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:footer.html' => 1,
  ),
),false)) {
function content_59b50f6849aae4_78068372 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>信息提示_<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitename'];?>
</title>

</head>
<body>

<link href="css/zt.css" rel="stylesheet" type="text/css">
<div class="header">
    <div class="logo">
        <div class="logoimg">
            <img src="images/logo_03.png" alt="鼎吉驾校" width="332" height="103">
        </div>
        <div class="logomsg">
            军旅特色 鼎吉服务
        </div>
        <div class="baoming">
            <div class="baomingimg">
                <img src="images/rexian.gif">
            </div>
            <div class="phone">
               <?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitetel'];?>

            </div>
            <div class="baoming3">
                 <a href="tencent://Message/?Uin=<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['qq'];?>
&websiteName=www.weihangye.cn=&Menu=yes">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>
            </div>
        </div>
    </div>
    <div class="daohang">
        <div class="nav">
            <div class="index<?php if (!$_smarty_tpl->tpl_vars['do']->value) {?>active<?php }?>">
                <a href="./">首页</a>
            </div>
            
			
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['tree_news_class'], 'item', false, 'key', 'class', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['key']->value => $_smarty_tpl->tpl_vars['item']->value) {
?>
			<?php if ($_smarty_tpl->tpl_vars['item']->value['pid'] == 0) {?>
				<div class="dh <?php if ($_smarty_tpl->tpl_vars['topparent']->value['id'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>active<?php }?>">
					<a href="<?php if ($_smarty_tpl->tpl_vars['item']->value['jumpto']) {
echo $_smarty_tpl->tpl_vars['item']->value['jumpto'];
} else { ?>index.php?do=intro&class_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];
}?>"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
					<ul>
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['_TGLOBAL']->value['tree_news_class'], 'vv');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['vv']->value) {
?>
							<?php if ($_smarty_tpl->tpl_vars['vv']->value['pid'] == $_smarty_tpl->tpl_vars['item']->value['id']) {?>
								<li><a href="<?php if ($_smarty_tpl->tpl_vars['vv']->value['jumpto']) {
echo $_smarty_tpl->tpl_vars['vv']->value['jumpto'];
} else { ?>index.php?do=intro&class_id=<?php echo $_smarty_tpl->tpl_vars['vv']->value['id'];
}?>"<?php if ($_smarty_tpl->tpl_vars['vv']->value['isnew']) {?>target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
</a></li>
							<?php }?>
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 
					</ul>
				</div>	
			<?php }?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
    </div>
    <div class="bg1">
        <div class="zixun">
            <form action="index.php?do=baoming" method="post" onSubmit="return Validator.Validate(this,2)">
                <div class="zixun1">报名咨询</div>
                <div class="zixun2"><input type="text" class="xm" name="name" datatype="Require" msg="请填写姓名."></div>
                <div class="zixun3"><input type="text" class="dh" name="tel"  datatype="Require" msg="请填写电话号码."></div>
				<input type="hidden" name="sign" value="1">
                <div class="zixun4"><input type="submit" class="subzx" value=" "></div>
            </form>
        </div>
    </div>
</div>

<div class="list_main">
  <div class="showmessage" align="center">
    <caption>
    <h2>&nbsp;</h2>
    <h2>信息提示</h2>
    </caption>
    <p><?php echo $_smarty_tpl->tpl_vars['message']->value;?>
</p>
    <p class="op"> <?php if ($_smarty_tpl->tpl_vars['url_forward']->value) {?> <a href="<?php echo $_smarty_tpl->tpl_vars['url_forward']->value;?>
">页面跳转中...</a> <?php } else { ?> <a href="<?php echo $_smarty_tpl->tpl_vars['_TGLOBAL']->value['refer'];?>
">返回上一页</a> | <a href="index.php">返回首页</a> <?php }?> </p>
    <br />
    <br />
    <br />
    <br />
    <br />
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html>
<?php }
}
