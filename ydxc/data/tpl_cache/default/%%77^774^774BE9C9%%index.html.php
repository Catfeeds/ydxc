<?php /* Smarty version 2.6.22, created on 2016-11-28 01:47:52
         compiled from index.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'index.html', 14, false),)), $this); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $this->_tpl_vars['_TCONFIG']['sitename']; ?>
</title>
    <link href="css/zt.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="js/zt.js"></script>
    <link type="text/css" rel="stylesheet" href="banner/css/posterTvGrid.css">
    <script language="javascript" type="text/javascript" src="banner/js/jquery.js"></script>
    <script language="javascript" type="text/javascript" src="banner/js/posterTvGrid.js"></script>
	
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
<!--班级部分-->
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index_course.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
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
        <script type="text/javascript">
            var posterTvGrid86804 = new posterTvGrid(
                    'posterTvGrid86804',
                    {className: "posterTvGrid",width:"1000",height:"580"},
                    [
						<?php $_from = $this->_tpl_vars['teachers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
							{"img":"<?php echo $this->_tpl_vars['item']['img']; ?>
","title":"<?php echo $this->_tpl_vars['item']['title']; ?>
","url":"index.php?do=newshow&id=<?php echo $this->_tpl_vars['item']['id']; ?>
#miaodian"},
						<?php endforeach; endif; unset($_from); ?>
						/*{"img":"images\/1.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/2.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/3.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},
						{"img":"images\/2.jpg","title":"chinaz","url":"http:\/\/www.baidu.com\/"},*/
					]
            );
        </script>
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
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index_news.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
</div>
<!--中间部分结束-->

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 

<!--右侧QQ-->
<div class="QQ">
    <div style="float:right;margin-right: 5px;cursor:pointer" onclick="yc()">X</div>
    <div>
        <a href="tencent://Message/?Uin=<?php echo $this->_tpl_vars['_TCONFIG']['siteQQ']; ?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png" width="150px"></a>
    </div>
    <div style="position: relative;top:-5px;right:-1px;">
        <a href="tel:<?php echo $this->_tpl_vars['_TCONFIG']['sitetel']; ?>
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
<script>
    function yc(){
        $(".QQ").addClass("yc");
    }
</script>
</html>