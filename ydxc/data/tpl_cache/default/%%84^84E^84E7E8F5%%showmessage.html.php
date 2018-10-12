<?php /* Smarty version 2.6.22, created on 2016-09-10 10:16:26
         compiled from showmessage.html */ ?>
﻿<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>信息提示_<?php echo $this->_tpl_vars['_TCONFIG']['sitename']; ?>
</title>

</head>
<body>

<link href="css/zt.css" rel="stylesheet" type="text/css">
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
                 <a href="tencent://Message/?Uin=<?php echo $this->_tpl_vars['_TCONFIG']['qq']; ?>
&websiteName=www.weihangye.cn=&Menu=yes">&nbsp;|&nbsp;投诉&nbsp;<img src="images/QQ.gif" alt=""></a>
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
<?php endif; ?>"<?php if ($this->_tpl_vars['vv']['isnew']): ?>target="_blank"<?php endif; ?>><?php echo $this->_tpl_vars['vv']['name']; ?>
</a></li>
							<?php endif; ?>
						<?php endforeach; endif; unset($_from); ?> 
					</ul>
				</div>	
			<?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
        </div>
    </div>
    <div class="bg1">
        <div class="zixun">
            <form action="index.php?do=baoming" method="post" onSubmit="return Validator.Validate(this,2)">
                <div class="zixun1">报名咨询</div>
                <div class="zixun2"><input type="text" class="xm" name="name" datatype="Require" msg="请填写姓名."></div>
                <div class="zixun3"><input type="text" class="dh" name="tel"  datatype="Require" msg="请填写电话号码."></div>
				<input type="hidden" name="sign" value="1">
                <div class="zixun4"><input type="submit" class="subzx" value=" "></div>
            </form>
        </div>
    </div>
</div>

<div class="list_main">
  <div class="showmessage" align="center">
    <caption>
    <h2>&nbsp;</h2>
    <h2>信息提示</h2>
    </caption>
    <p><?php echo $this->_tpl_vars['message']; ?>
</p>
    <p class="op"> <?php if ($this->_tpl_vars['url_forward']): ?> <a href="<?php echo $this->_tpl_vars['url_forward']; ?>
">页面跳转中...</a> <?php else: ?> <a href="<?php echo $this->_tpl_vars['_TGLOBAL']['refer']; ?>
">返回上一页</a> | <a href="index.php">返回首页</a> <?php endif; ?> </p>
    <br />
    <br />
    <br />
    <br />
    <br />
  </div>
  <div class="clear"></div>
</div>
<div class="clear"></div>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "footer.html", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</body>
</html>