<?php /* Smarty version 2.6.22, created on 2016-11-28 01:48:15
         compiled from intro.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'intro.html', 11, false),)), $this); ?>
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
                <a href="./"><img src="images/icon1.png" width="40" height="32"></a>
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
                    <?php if ($this->_tpl_vars['newsshow']['name']): ?><?php echo $this->_tpl_vars['newsshow']['name']; ?>
<?php else: ?><?php echo $this->_tpl_vars['class_name']['name']; ?>
<?php endif; ?>
                </div>
                <div class="content_right">
					<?php if ($this->_tpl_vars['class_id'] == 15): ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ditu.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?><?php endif; ?>
                   <p style="line-height: 30px;">
                       <?php echo ((is_array($_tmp=$this->_tpl_vars['newsshow']['intro'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

                       <?php echo ((is_array($_tmp=$this->_tpl_vars['newsshow']['content'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

                   </p>
				   <?php if ($this->_tpl_vars['class_id'] == 15): ?>
						<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ditu2.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
						<br/>
						<!--<p style="line-height: 30px;">陈家桥轻轨站报名点	大学城东路陈家桥轻轨站旁	023-67303999</p>
						<p style="line-height: 30px;">西永老街店	沙坪坝西永老街西永路252好	023-65612118</p>
						<p style="line-height: 30px;">医专院门店	沙坪坝区医药高等专科学校东门旁	</p>
						<p style="line-height: 30px;">城管校门店	沙坪坝区大学城城市管理学院内商业街	</p>
						<p style="line-height: 30px;">新桥报名店	重庆沙坪坝区新桥医院旁500米	</p>-->

				   
				   
				   <?php endif; ?>
				   
				<?php if ($this->_tpl_vars['iscourse']): ?>   
					<div class="tishi">
						温馨提示：所有班别如学车过程中出现补考，拿证时间将延期。
					</div>
					<div class="tishi2">
						服务流程
					</div>
					<p style="line-height: 30px;">
						 <?php echo ((is_array($_tmp=$this->_tpl_vars['newsshow']['liucheng'])) ? $this->_run_mod_handler('nl2br', true, $_tmp) : smarty_modifier_nl2br($_tmp)); ?>

					</p>
				 <?php endif; ?> 
				  
				  
				<?php if ($this->_tpl_vars['firstchild']['id'] == 17): ?>   
					<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ceshi.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
				 <?php endif; ?>
				   
				   
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