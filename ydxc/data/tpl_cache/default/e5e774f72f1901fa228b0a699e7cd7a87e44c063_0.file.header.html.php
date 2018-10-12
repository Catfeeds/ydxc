<?php
/* Smarty version 3.1.30, created on 2017-08-18 01:28:42
  from "/data/www/ydxc/ydxc/template/default/header.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995d24ac42a40_31388753',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e5e774f72f1901fa228b0a699e7cd7a87e44c063' => 
    array (
      0 => '/data/www/ydxc/template/default/header.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5995d24ac42a40_31388753 (Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
 type="text/javascript" src="js/validator.js"><?php echo '</script'; ?>
>
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
                 <!--<a href="tencent://Message/?Uin=<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['qq'];?>
&websiteName=www.weihangye.cn=&Menu=yes">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>-->
                 <a href="index.php?do=tousu#miaodian">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>
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
}?>#miaodian"<?php if ($_smarty_tpl->tpl_vars['vv']->value['isnew']) {?>target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['vv']->value['name'];?>
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
    <!--<div class="bg1">
        <div class="zixun">
            <form action="index.php?do=baoming" method="post" onSubmit="return Validator.Validate(this,2)">
                <div class="zixun1">报名咨询</div>
                <div class="zixun2"><input type="text" class="xm" name="name" datatype="Require" msg="请填写姓名."></div>
                <div class="zixun3"><input type="text" class="dh" name="tel"  datatype="Require" msg="请填写电话号码."></div>
				<input type="hidden" name="sign" value="1">
                <div class="zixun4"><input type="submit" class="subzx" value=" "></div>
            </form>
        </div>
    </div>-->
    <style>
        .banner .banner_img{
            width:100%;
            height:596px;
        }
        .banner_img img{
            width:100%;
            height:596px;
        }
        .banner_xz{
            position: relative;
            bottom: 45px;
            left:930px;
        }
        .banner_xz li{
            list-style: none;
            float:left;
            margin-left: 5px;
            cursor:pointer;
        }
    </style>
    <div class="banner">
        <ul class="banner_img">
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['banners']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
            <li>
				<?php if ($_smarty_tpl->tpl_vars['item']->value['link']) {?><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['link'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"></a>
				<?php } else { ?><img src="<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
"><?php }?>
			</li>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
        <ul class="banner_xz">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['banners']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
				<li></li>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </ul>
    </div>
	
	<a href="#miaodian" name="miaodian"></a>
	
    <div class="bg2">
        <div class="notice">
            <ul>
                <li>已有经累计超过 <font color="red"><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['jiazhao'];?>
</font> 人在鼎吉驾校拿到驾照，已有 <font color="red"><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['zixun'];?>
</font> 人咨询</li>
                <li>已有经累计超过 <font color="red"><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['jiazhao'];?>
</font> 人在鼎吉驾校拿到驾照，已有 <font color="red"><?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['zixun'];?>
</font> 人咨询</li>
            </ul>
        </div>
    </div>
</div><?php }
}
