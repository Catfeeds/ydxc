<?php /* Smarty version 2.6.22, created on 2016-11-28 23:57:04
         compiled from news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'nl2br', 'news.html', 11, false),array('modifier', 'truncate', 'news.html', 37, false),array('modifier', 'date_format', 'news.html', 37, false),array('block', 'get', 'news.html', 35, false),)), $this); ?>
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
                > 重庆鼎吉驾校 ><?php echo $this->_tpl_vars['curr_class']; ?>

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
                    新闻中心
                </div>
                <div class="content_right">
                    <div>
                        <h3>行业动态</h3>
                        <div>
                            <ul>
								<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows' => 6)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
#miaodian"><div><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 48) : smarty_modifier_truncate($_tmp, 48)); ?>
 <span><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</span></div></a>
									</li>
								<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <h3>最近公告</h3>
                        <div>
                            <ul>
								<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows' => 6)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
#miaodian"><div><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 48) : smarty_modifier_truncate($_tmp, 48)); ?>
 <span><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</span></div></a>
									</li>
								<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                            </ul>
                        </div>
                    </div>
                    <div>
                        <h3>媒体报道</h3>
                        <div>
                            <ul>
								<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows' => 6)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
									<li>
										 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
#miaodian"><div><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 48) : smarty_modifier_truncate($_tmp, 48)); ?>
 <span><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y-%m-%d") : smarty_modifier_date_format($_tmp, "%Y-%m-%d")); ?>
</span></div></a>
									</li>
								<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                            </ul>
                        </div>
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