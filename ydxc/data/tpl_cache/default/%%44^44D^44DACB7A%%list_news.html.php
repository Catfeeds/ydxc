<?php /* Smarty version 2.6.22, created on 2016-11-28 03:34:09
         compiled from list_news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'list_news.html', 11, false),array('modifier', 'truncate', 'list_news.html', 35, false),array('modifier', 'date_format', 'list_news.html', 35, false),)), $this); ?>
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
					<div>
						<ul>
							<?php $_from = $this->_tpl_vars['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>			 	
								<li>
									 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['item']['id']; ?>
#miaodian"><div><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 48) : smarty_modifier_truncate($_tmp, 48)); ?>
 <span><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</span></div>
								</li>
							<?php endforeach; endif; unset($_from); ?>
						</ul>
					</div>
					<div class="page"><?php echo $this->_tpl_vars['multi']; ?>
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