<?php /* Smarty version 2.6.22, created on 2016-09-07 18:59:29
         compiled from footer.html */ ?>
<div class="footer">
    <!--分割线-->
    <div class="bg3"></div>
    <div class="footer_body">
        <div class="footer_left">
            <div class="footer_img">
                <!--<img src="images/icon6.png" width="365" height="125">-->
                <img src="images/logo_03.png" width="332" height="103">
            </div>
            <div class="footer_msg">
                <div style="margin: 0px 0px 5px 20px">更多咨询服务请致电</div>
                <div class="footer_phone"><?php echo $this->_tpl_vars['_TCONFIG']['sitetel']; ?>
</div>
            </div>
        </div>
        <div class="footer_right">
            <!--<ul>
                <span>关于我们</span>
                <li>公司简介</li>
                <li>教练风采</li>
                <li>代理中心</li>
                <li>新闻中心</li>
            </ul>
            <ul>
                <span>场地实景</span>
                <li>车辆图片</li>
                <li>场地图片</li>
                <li>场地位置</li>
            </ul>
            <ul>
                <span>接送班车</span>
                <li>班车接送安排</li>
            </ul>
            <ul>
                <span>班级价格</span>
                <li>品质班</li>
                <li>快速版</li>
                <li>实惠班</li>
                <li>分期班</li>
            </ul>
            <ul>
                <span>模拟题库</span>
                <li>科目一</li>
                <li>科目二</li>
                <li>科目三</li>
                <li>科目四</li>
            </ul>
			-->
			
		<?php $_from = $this->_tpl_vars['_TGLOBAL']['tree_news_class']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['class'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['class']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['class']['iteration']++;
?>
		
			<?php if ($this->_tpl_vars['item']['pid'] == 0 && $this->_tpl_vars['key'] < 16): ?>
				<ul>
					<span><?php echo $this->_tpl_vars['item']['name']; ?>
</span>
					<?php $_from = $this->_tpl_vars['_TGLOBAL']['tree_news_class']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
						<?php if ($this->_tpl_vars['vv']['pid'] == $this->_tpl_vars['item']['id']): ?>
							<li><a href="<?php if ($this->_tpl_vars['vv']['jumpto']): ?><?php echo $this->_tpl_vars['vv']['jumpto']; ?>
#miaodian<?php else: ?>index.php?do=intro&class_id=<?php echo $this->_tpl_vars['vv']['id']; ?>
#miaodian<?php endif; ?>"<?php if ($this->_tpl_vars['vv']['isnew']): ?>target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['vv']['name']; ?>
</a></li>
						<?php endif; ?>
					<?php endforeach; endif; unset($_from); ?> 
				</ul>	
			<?php endif; ?>
		
		<?php endforeach; endif; unset($_from); ?>
			
        </div>
    </div>
    <div class="footer_fg"></div>
    <div class="footer_address">
		公司地址：<?php echo $this->_tpl_vars['_TCONFIG']['siteaddress']; ?>
  <?php if ($this->_tpl_vars['_TCONFIG']['sitefax']): ?>传真：<?php echo $this->_tpl_vars['_TCONFIG']['sitefax']; ?>
<?php endif; ?>  <br/>
		<?php echo $this->_tpl_vars['_TCONFIG']['siteicpno']; ?>
 <?php echo $this->_tpl_vars['_TCONFIG']['statcode']; ?>

    </div>
</div>