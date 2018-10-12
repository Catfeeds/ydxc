<?php /* Smarty version 2.6.22, created on 2016-09-05 17:15:26
         compiled from showmessage_admin.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<title>智能后台</title>
</head>
<body>
<div class="showmessage" align="center">
  <div class="ye_r_t">
    <div class="ye_l_t">
      <div class="ye_r_b">
        <div class="ye_l_b">
          <caption>
          <h2>信息提示</h2>
          </caption>
          <p><?php echo $this->_tpl_vars['message']; ?>
</p>
          <p class="op"> <?php if ($this->_tpl_vars['url_forward']): ?> <a href="<?php echo $this->_tpl_vars['url_forward']; ?>
">页面跳转中...</a> <?php else: ?> <a href="javascript:history.back();">返回上一页</a> | <a href="module.php?ac=system&mod=admin">返回首页</a> <?php endif; ?> </p>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>