<?php /* Smarty version 2.6.22, created on 2016-09-05 17:15:09
         compiled from index_news.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('block', 'get', 'index_news.html', 4, false),array('modifier', 'truncate', 'index_news.html', 6, false),array('modifier', 'getthumbimg', 'index_news.html', 29, false),)), $this); ?>
    <div class="bottom">
        <div class="bottom_left">
            <div class="bottom_jj">
                <!--<?php $this->_tag_stack[] = array('get', array('sql' => "select * from ctb_news where class_id=2",'row' => 1,'return' => 'jianjie')); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
					<?php echo $this->_tpl_vars['get_all_pic']; ?>

					<?php echo ((is_array($_tmp=$this->_tpl_vars['get_all_pic'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 780) : smarty_modifier_truncate($_tmp, 780)); ?>

					<a href="index.php?do=intro&class_id=2">查看详情》</a>
				<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>-->
				<?php echo ((is_array($_tmp=$this->_tpl_vars['content'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 780) : smarty_modifier_truncate($_tmp, 780)); ?>
<a href="index.php?do=intro&class_id=2">查看详情》</a>
            </div>
            <div>
                <img src="images/jxdz.png" width="397" height="89">
            </div>
            <div width="754" height="746">
                <!--<img src="images/dizhi.png" width="754" height="746">-->
				<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "ditu2.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
            <div style="height:20px;"></div>
        </div>
        <div class="bottom_right">
            <div>
                <h3>行业资讯 <span>news</span></h3><span><a href="index.php?do=intro&class_id=20">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
                <div>
					<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, img FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows' => 1,'return' => 'new1')); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
						<a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['new1']['id']; ?>
"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['new1']['img'])) ? $this->_run_mod_handler('getthumbimg', true, $_tmp) : getthumbimg($_tmp)); ?>
" width="374" height="123"></a>
					<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                </div>
                <div class="list">
                    <ul>
                        <!--<li>长城汽车不走高端很快会死</li>
                        <li>抢先买拍猎豹CS10 霸气时尚2.0T涡轮增压</li>
                        <li>买房还是炒股，2015买房无法拒绝的五大理由</li>
                        <li>长城汽车不走高端很快会死</li>
                        <li>抢先买拍猎豹CS10 霸气时尚2.0T涡轮增压</li>-->
						<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=20 ORDER BY flag DESC ,id DESC",'rows' => 5)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?>
</a>
							</li>
						<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    </ul>
                </div>
            </div>
            <div>
                <h3>最新公告 <span>news</span></h3><span><a href="index.php?do=intro&class_id=21">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
					<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, img FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows' => 1,'return' => 'new1')); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
						<a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['new1']['id']; ?>
"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['new1']['img'])) ? $this->_run_mod_handler('getthumbimg', true, $_tmp) : getthumbimg($_tmp)); ?>
" width="374" height="123"></a>
					<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                <div class="list">
                    <ul>
						<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=21 ORDER BY flag DESC ,id DESC",'rows' => 5)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?>
</a>
							</li>
						<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    </ul>
                </div>
            </div>
            <div>
                <h3>媒体报道 <span>news</span></h3><span><a href="index.php?do=intro&class_id=23">MORE</a></span>
                <div>
                    <img src="images/xian_03.png" width="376" height="4">
                </div>
                <div style="height:10px;"></div>
                <div>
					<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, img FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows' => 1,'return' => 'new1')); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
						<a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['new1']['id']; ?>
"><img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['new1']['img'])) ? $this->_run_mod_handler('getthumbimg', true, $_tmp) : getthumbimg($_tmp)); ?>
" width="374" height="123"></a>
					<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                </div>
                <div class="list">
                    <ul>
						<?php $this->_tag_stack[] = array('get', array('sql' => "SELECT id, title, date FROM ctb_news WHERE display=1 AND class_id=23 ORDER BY flag DESC ,id DESC",'rows' => 5)); $_block_repeat=true;smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>			 	
							<li>
								 <a href="index.php?do=newshow&id=<?php echo $this->_tpl_vars['r']['id']; ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['r']['title'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 40) : smarty_modifier_truncate($_tmp, 40)); ?>
</a>
							</li>
						<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo smarty_block_get($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>