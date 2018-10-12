<?php /* Smarty version 2.6.22, created on 2016-09-22 15:48:32
         compiled from header.html */ ?>

<script type="text/javascript" src="js/validator.js"></script>
<div class="header">
    <div class="logo">
        <div class="logoimg">
            <img src="images/logo_03.png" alt="鼎吉驾校" width="332" height="103">
        </div>
        <div class="logomsg">
            军旅特色 鼎吉服务
        </div>
        <div class="baoming">
            <div class="baomingimg">
                <img src="images/rexian.gif">
            </div>
            <div class="phone">
               <?php echo $this->_tpl_vars['_TCONFIG']['sitetel']; ?>

            </div>
            <div class="baoming3">
                 <!--<a href="tencent://Message/?Uin=<?php echo $this->_tpl_vars['_TCONFIG']['qq']; ?>
&websiteName=www.weihangye.cn=&Menu=yes">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>-->
                 <a href="index.php?do=tousu#miaodian">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>
            </div>
        </div>
    </div>
    <div class="daohang">
        <div class="nav">
            <div class="index<?php if (! $this->_tpl_vars['do']): ?>active<?php endif; ?>">
                <a href="./">首页</a>
            </div>
            
			
		<?php $_from = $this->_tpl_vars['_TGLOBAL']['tree_news_class']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['class'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['class']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['class']['iteration']++;
?>
			<?php if ($this->_tpl_vars['item']['pid'] == 0): ?>
				<div class="dh <?php if ($this->_tpl_vars['topparent']['id'] == $this->_tpl_vars['item']['id']): ?>active<?php endif; ?>">
					<a href="<?php if ($this->_tpl_vars['item']['jumpto']): ?><?php echo $this->_tpl_vars['item']['jumpto']; ?>
<?php else: ?>index.php?do=intro&class_id=<?php echo $this->_tpl_vars['item']['id']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['item']['name']; ?>
</a>
					<ul>
						<?php $_from = $this->_tpl_vars['_TGLOBAL']['tree_news_class']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['vv']):
?>
							<?php if ($this->_tpl_vars['vv']['pid'] == $this->_tpl_vars['item']['id']): ?>
								<li><a href="<?php if ($this->_tpl_vars['vv']['jumpto']): ?><?php echo $this->_tpl_vars['vv']['jumpto']; ?>
<?php else: ?>index.php?do=intro&class_id=<?php echo $this->_tpl_vars['vv']['id']; ?>
<?php endif; ?>#miaodian"<?php if ($this->_tpl_vars['vv']['isnew']): ?>target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['vv']['name']; ?>
</a></li>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?> 
					</ul>
				</div>	
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
    <!--<div class="bg1">
        <div class="zixun">
            <form action="index.php?do=baoming" method="post" onSubmit="return Validator.Validate(this,2)">
                <div class="zixun1">报名咨询</div>
                <div class="zixun2"><input type="text" class="xm" name="name" datatype="Require" msg="请填写姓名."></div>
                <div class="zixun3"><input type="text" class="dh" name="tel"  datatype="Require" msg="请填写电话号码."></div>
				<input type="hidden" name="sign" value="1">
                <div class="zixun4"><input type="submit" class="subzx" value=" "></div>
            </form>
        </div>
    </div>-->
    <style>
        .banner .banner_img{
            width:100%;
            height:596px;
        }
        .banner_img img{
            width:100%;
            height:596px;
        }
        .banner_xz{
            position: relative;
            bottom: 45px;
            left:930px;
        }
        .banner_xz li{
            list-style: none;
            float:left;
            margin-left: 5px;
            cursor:pointer;
        }
    </style>
    <div class="banner">
        <ul class="banner_img">
		<?php $_from = $this->_tpl_vars['banners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
            <li>
				<?php if ($this->_tpl_vars['item']['link']): ?><a href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><img src="<?php echo $this->_tpl_vars['item']['img']; ?>
"></a>
				<?php else: ?><img src="<?php echo $this->_tpl_vars['item']['img']; ?>
"><?php endif; ?>
			</li>
		<?php endforeach; endif; unset($_from); ?>
        </ul>
        <ul class="banner_xz">
			<?php $_from = $this->_tpl_vars['banners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
				<li></li>
			<?php endforeach; endif; unset($_from); ?>
        </ul>
    </div>
	
	<a href="#miaodian" name="miaodian"></a>
	
    <div class="bg2">
        <div class="notice">
            <ul>
                <li>已有经累计超过 <font color="red"><?php echo $this->_tpl_vars['_TCONFIG']['jiazhao']; ?>
</font> 人在鼎吉驾校拿到驾照，已有 <font color="red"><?php echo $this->_tpl_vars['_TCONFIG']['zixun']; ?>
</font> 人咨询</li>
                <li>已有经累计超过 <font color="red"><?php echo $this->_tpl_vars['_TCONFIG']['jiazhao']; ?>
</font> 人在鼎吉驾校拿到驾照，已有 <font color="red"><?php echo $this->_tpl_vars['_TCONFIG']['zixun']; ?>
</font> 人咨询</li>
            </ul>
        </div>
    </div>
</div>