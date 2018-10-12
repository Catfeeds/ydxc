<?php /* Smarty version 2.6.22, created on 2016-09-26 10:03:08
         compiled from left.html */ ?>


<div class="left">
	<div class="title_left">
		<div style="padding: 10px 0px 5px 20px;width: 100%;border-bottom: 1px solid #ccc">
			<div><img src="images/icon2.png" width="32" height="32"></div>
			<div style="padding-left: 5px;">
				<?php echo $this->_tpl_vars['topparent']['name']; ?>

			</div>
		</div>
		<ul>
			<?php $_from = $this->_tpl_vars['left']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li <?php if ($this->_tpl_vars['item']['id'] == $this->_tpl_vars['class_id']): ?>class="title_on"<?php endif; ?>><a href="<?php if ($this->_tpl_vars['item']['jumpto']): ?><?php echo $this->_tpl_vars['item']['jumpto']; ?>
<?php else: ?>index.php?do=intro&class_id=<?php echo $this->_tpl_vars['item']['id']; ?>
<?php endif; ?>#miaodian" <?php if ($this->_tpl_vars['item']['isnew']): ?>target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['item']['name']; ?>
</a></li>
			<?php endforeach; endif; unset($_from); ?>
		</ul>
		<div style="clear:both;height: 0px;"></div>
		
	</div>

</div>

<!--右侧QQ
	<div style="position:relative;">
		<div style="margin-top:40px;">
			<a href="tencent://Message/?Uin=<?php echo $this->_tpl_vars['_TCONFIG']['qq']; ?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png"></a>
		</div>
		<div style="position: relative;top:230px;right:-1px;">
			<a href="tel:<?php echo $this->_tpl_vars['_TCONFIG']['sitetel']; ?>
"><img src="images/lxdh_03.png"></a>
		</div>
	</div>-->


<!--右侧QQ-->
<div class="QQ">
    <div style="float:right;margin-right: 5px;cursor:pointer" onclick="yc()">X</div>
	<div>
        <a href="tencent://Message/?Uin=<?php echo $this->_tpl_vars['_TCONFIG']['siteQQ']; ?>
&websiteName=www.weihangye.cn=&Menu=yes"><img src="images/QQ_03.png" width="150px" ></a>
    </div>
    <div style="position: relative;top:-5px;"><!--right:-1px;-->
        <a href="tel:<?php echo $this->_tpl_vars['_TCONFIG']['sitetel']; ?>
"><img src="images/lxdh_03.png" width="150px"></a>
    </div>
</div>
<!--右侧QQ-->
<script>
    function yc(){
        $(".QQ").addClass("yc");
    }
</script>


