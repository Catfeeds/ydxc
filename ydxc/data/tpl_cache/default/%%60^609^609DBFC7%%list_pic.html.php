<?php /* Smarty version 2.6.22, created on 2016-11-28 08:35:18
         compiled from list_pic.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'list_pic.html', 11, false),)), $this); ?>
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
                <?php echo $this->_tpl_vars['class_name']['name']; ?>

            </div>
            <div class="content_right">
                <?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
					<div class="jlfc">
						<p><a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['item']['id']; ?>
#miaodian"><img src="<?php echo $this->_tpl_vars['item']['img']; ?>
"></a></p>
						<?php if ($this->_tpl_vars['class_id'] == 3): ?><p align="center"><?php echo $this->_tpl_vars['_TGLOBAL']['setting']['kemu'][$this->_tpl_vars['item']['kemu']]; ?>
:<?php echo $this->_tpl_vars['item']['xingming']; ?>
</p><?php endif; ?>
					</div>
				<?php endforeach; endif; unset($_from); ?>
                <!--<div class="jlfc">
                    <img src="images/5.png">
                </div>
                <div class="jlfc">
                    <img src="images/008.png">
                </div>
                <div class="jlfc">
                    <img src="images/7dd98d1001e93901df56c40079ec54e736d196bc.jpg">
                </div>
                <div class="jlfc">
                    <img src="images/006.png">
                </div>
                <div class="jlfc">
                    <img src="images/5.png">
                </div>
                <div class="jlfc">
                    <img src="images/008.png">
                </div>
                <div class="jlfc">
                    <img src="images/7dd98d1001e93901df56c40079ec54e736d196bc.jpg">
                </div>-->
            </div>
			<div class="page"><?php echo $this->_tpl_vars['multi']; ?>
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