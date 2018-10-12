<?php
/* Smarty version 3.1.30, created on 2017-08-18 01:28:42
  from "/data/www/ydxc/ydxc/template/default/index.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5995d24ac2e422_72662814',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea2b752dbe88d56d7320df8ba0ee666c8a3fdd08' => 
    array (
      0 => '/data/www/ydxc/ydxc/template/default/index.html',
      1 => 1500819566,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:header.html' => 1,
    'file:index_course.html' => 1,
    'file:index_news.html' => 1,
    'file:footer.html' => 1,
  ),
),false)) {
function content_5995d24ac2e422_72662814 (Smarty_Internal_Template $_smarty_tpl) {
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
    <link type="text/css" rel="stylesheet" href="banner/css/posterTvGrid.css">
    <?php echo '<script'; ?>
 language="javascript" type="text/javascript" src="banner/js/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 language="javascript" type="text/javascript" src="banner/js/posterTvGrid.js"><?php echo '</script'; ?>
>
	
	<meta name="Keywords" content="<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['keywords'];?>
"/>
	<meta name="description" content="<?php echo smarty_modifier_nl2br($_smarty_tpl->tpl_vars['_TCONFIG']->value['description']);?>
"/>
</head>
<body>

<?php $_smarty_tpl->_subTemplateRender("file:header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
<!--班级部分-->
	<?php $_smarty_tpl->_subTemplateRender("file:index_course.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
<!--班级部分部分-->
<!--中间部分-->
<div class="banjijiage">
    <div class="banjititle">
        四大班级，不过？就退费！
    </div>
    <div class="banjiimg">
        <img src="images/banji.png" width="1200" height="400">
    </div>
    <!--<div class="banjiimg">-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
            <!--<div>-->
                <!--<div class="banjileft">-->
                    <!--<h1>c</h1>1-->
                <!--</div>-->
            <!--</div>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
        <!--<div>-->
            <!--<h3>品质班</h3>-->
        <!--</div>-->
    <!--</div>-->
    <div style="height:50px;"></div>
</div>
<div>
    <img src="images/zixun.png" height="140">
</div>
<div class="biaoge">
    <img src="images/biaoge.png" width="1200" height="1016">
</div>
<div class="mxjl">
    <img src="images/mxjl.png" width="1199" height="176">
    <!--教练-->
    <div class="jl">
        <center><div id="posterTvGrid86804"></div></center>
        <style>
            .leftShadow{
                display: none;
            }
            .rightShadow{
                display: none;
            }
            .bottomNav{
                display: none;
            }
            .posterTvGrid{
                height:580px;
                width:1000px;
            }
        </style>
        <?php echo '<script'; ?>
 type="text/javascript">
            var posterTvGrid86804 = new posterTvGrid(
                    'posterTvGrid86804',
                    {className: "posterTvGrid",width:"1000",height:"580"},
                    [
						<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['teachers']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
							{"img":"<?php echo $_smarty_tpl->tpl_vars['item']->value['img'];?>
","title":"<?php echo $_smarty_tpl->tpl_vars['item']->value['title'];?>
","url":"index.php?do=newshow&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
#miaodian"},
						<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

						/*{"img":"images\/1.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/2.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/3.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/2.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},*/
					]
            );
        <?php echo '</script'; ?>
>
    </div>
    <!--教练-->
    <div class="jxfc">
        <img src="images/jlimg.png" width="1204" height="56">
    </div>
    <div class="fengcai">
        <div>
            <div><img src="images/fengcai1.jpg" width="280" height="210"></div>
            <!--<div class="fengcai_text">
                上坡起步练习
            </div>-->
        </div>
        <div>
            <div><img src="images/fengcai2.jpg" width="280" height="210"></div>
            <!--<div class="fengcai_text">
                上坡起步练习
            </div>-->
        </div>
        <div>
            <div><img src="images/fengcai3.jpg" width="280" height="210"></div>
            <!--<div class="fengcai_text">
                上坡起步练习
            </div>-->
        </div>
        <div>
            <div><img src="images/fengcai4.jpg" width="280" height="210"></div>
            <!--<div class="fengcai_text">
                上坡起步练习
            </div>-->
        </div>
    </div>
		<?php $_smarty_tpl->_subTemplateRender("file:index_news.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 
</div>
<!--中间部分结束-->

<?php $_smarty_tpl->_subTemplateRender("file:footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 

<!--右侧QQ-->
<div class="QQ">
    <div style="float:right;margin-right: 5px;cursor:pointer" onclick="yc()">X</div>
    <div>
        <a href="tencent://Message/?Uin=<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['siteQQ'];?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png" width="150px"></a>
    </div>
    <div style="position: relative;top:-5px;right:-1px;">
        <a href="tel:<?php echo $_smarty_tpl->tpl_vars['_TCONFIG']->value['sitetel'];?>
"><img src="images/lxdh_03.png" width="150px"></a>
    </div>
</div>
<!--右侧QQ-->
<!--浮动报名-->
<div class="fdbm">
    <div class="guanbi">
        <div>X</div>
    </div>
    <div class="xcbm">
	<form action="index.php?do=baoming" method="post" onSubmit="return Validator.Validate(this,2)">
        <div>
            <img src="images/icon01_03.png" width="230" style="margin-left: 30px;">
        </div>
        <table>
            <tr>
                <td colspan="2">客服将尽快联系您</td>
            </tr>
            <tr>
                <td align="right">姓名：</td>
                <td align="left"><input type="text" name="name" datatype="Require" msg="请填写姓名."></td>
            </tr>
            <tr>
                <td align="right">手机：</td>
                <td align="left"><input type="text" name="tel"  datatype="Require" msg="请填写电话号码."></td>
            </tr>
            <tr>
                <td><input type="hidden" name="sign" value="1"></td>
                <td align="left"><input type="submit"></td>
            </tr>
        </table>
     </form>
    </div>
</div>
<!--浮动报名-->
</body>
<?php echo '<script'; ?>
>
    function yc(){
        $(".QQ").addClass("yc");
    }
<?php echo '</script'; ?>
>
</html><?php }
}
