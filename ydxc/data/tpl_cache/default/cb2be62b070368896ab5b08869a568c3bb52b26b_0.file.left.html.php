<?php
/* Smarty version 3.1.30, created on 2017-09-01 17:06:21
  from "/data/www/ydxc/ydxc/template/default/left.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_59a9230d892d87_96857461',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cb2be62b070368896ab5b08869a568c3bb52b26b' => 
    array (
      0 => '/data/www/ydxc/template/default/left.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59a9230d892d87_96857461 (Smarty_Internal_Template $_smarty_tpl) {
?>


<div class="left">
	<div class="title_left">
		<div style="padding: 10px 0px 5px 20px;width: 100%;border-bottom: 1px solid #ccc">
			<div><img src="images/icon2.png" width="32" height="32"></div>
			<div style="padding-left: 5px;">
				<?php echo $_smarty_tpl->tpl_vars['topparent']->value['name'];?>

			</div>
		</div>
		<ul>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['left']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
				<li <?php if ($_smarty_tpl->tpl_vars['item']->value['id'] == $_smarty_tpl->tpl_vars['class_id']->value) {?>class="title_on"<?php }?>><a href="<?php if ($_smarty_tpl->tpl_vars['item']->value['jumpto']) {
echo $_smarty_tpl->tpl_vars['item']->value['jumpto'];
} else { ?>index.php?do=intro&class_id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];
}?>#miaodian" <?php if ($_smarty_tpl->tpl_vars['item']->value['isnew']) {?>target="_blank"<?php }?>><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></li>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

		</ul>
		<div style="clear:both;height: 0px;"></div>
		
	</div>

</div>

<!--右侧QQ
	<div style="position:relative;">
		<div style="margin-top:40px;">
			<a href="tencent://Message/?Uin=<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['qq'];?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png"></a>
		</div>
		<div style="position: relative;top:230px;right:-1px;">
			<a href="tel:<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitetel'];?>
"><img src="images/lxdh_03.png"></a>
		</div>
	</div>-->


<!--右侧QQ-->
<div class="QQ">
    <div style="float:right;margin-right: 5px;cursor:pointer" onclick="yc()">X</div>
	<div>
        <a href="tencent://Message/?Uin=<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['siteQQ'];?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png" width="150px" ></a>
    </div>
    <div style="position: relative;top:-5px;"><!--right:-1px;-->
        <a href="tel:<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitetel'];?>
"><img src="images/lxdh_03.png" width="150px"></a>
    </div>
</div>
<!--右侧QQ-->
<?php echo '<script'; ?>
>
    function yc(){
        $(".QQ").addClass("yc");
    }
<?php echo '</script'; ?>
>



<?php }
}
