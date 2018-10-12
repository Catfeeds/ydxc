<?php /* Smarty version 2.6.22, created on 2016-09-05 17:15:09
         compiled from index_course.html */ ?>
<div class="class_about">
    <div class="dlsq">
        <div class="dlsq_top">
            <div class="sqform">
                <div style="visibility: hidden;">
                    <img src="images/icon_15.png">
                </div>
                <div class="sqfg"  style="visibility: hidden;"></div>
                <div class="sqfuwu" style="visibility: hidden;">
                    鼎吉驾校为您提供最优秀的解决方案，请您填写资料
                </div>
                <div class="sqipt"  style="visibility: hidden;">
                    <form action="index.php?do=daili" method="post" onSubmit="return Validator.Validate(this,2)">
                        <table>
                            <tr>
                                <td width="70" align="right">姓名：</td>
                                <td align="left" width="178"><input name="name" type="text" datatype="Require" msg="请填写姓名."></td>
                                <td align="center">*</td>
                            </tr>
                            <tr>
                                <td width="70" align="right">联系电话：</td>
                                <td align="left" width="178"><input name="tel" type="text" datatype="Require" msg="请填写联系电话."></td>
                                <td align="center">*</td>
                            </tr>
                            <tr>
                                <td width="70" align="right">所在地区：</td>
                                <td align="left" width="178"><input name="area" type="text" datatype="Require" msg="请填写区域."></td>
                                <td align="center">*</td>
                            </tr>
                            <tr>
                                <td width="70" align="right" style="vertical-align: top">留言：</td>
                                <td align="left" width="178"><textarea name="remark" id="" style="width:178px;height:80px;"></textarea></td>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td width="70" align="right"></td>
                                <td align="left" width="178">
                                    <input type="reset" class="btn" value="重置"/>
									<input type="hidden" name="daili" value="1">
                                    <input type="submit" class="btn" value="提交" style="margin-left:15px;"/>
                                </td>
                                <td align="center"></td>
                            </tr>
                            <tr>
                                <td align="center" colspan="3" height="40" style="line-height: 14px;">
                                    *温馨提示;为确保注册的有效性，请填写真实<br/>的姓名和联系方式我们将尽快与您取得联系
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
				
                <div class="fuwutop">
                    <?php $_from = $this->_tpl_vars['courses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cl'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cl']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['cl']['iteration']++;
?>
						<div class="fuwu">
							<div class="fuwuleft <?php if (($this->_foreach['cl']['iteration']-1)%2 == 1): ?>fright<?php endif; ?>">
								<div class="banji">
									<div>
										<div class="h1">
											<?php echo $this->_tpl_vars['item']['name']; ?>

										</div>
									</div>
									<div class="banjitext">
										<p>适应对象：</p><p class="p1"><?php echo $this->_tpl_vars['item']['obj']; ?>
</p>
									</div>
									<div class="banjitext">
										<p>练车时间：</p><p class="p1"><?php echo $this->_tpl_vars['item']['testdate']; ?>
</p>
									</div>
									<div class="banjitext">
										<p>拿证时间：</p><p class="p1"><?php echo $this->_tpl_vars['item']['getdate']; ?>
</p>
									</div>
									<div class="banjitext">
										<p>练车方式：</p><p class="p1"><?php echo $this->_tpl_vars['item']['type']; ?>
</p>
									</div>
									<div class="liaojie">
										<a href="index.php?do=intro&class_id=<?php echo $this->_tpl_vars['item']['classid']; ?>
"><img src="images/icon_liaojie.png" width="190" height="60"/></a>
									</div>
								</div>
							</div>
							<div class="fuwuright <?php if (($this->_foreach['cl']['iteration']-1)%2 == 1): ?>fleft<?php endif; ?>">
								<div>
									<img src="images/icon_bj1.png" width="552" height="260">
								</div>
							</div>
						</div>
					<?php endforeach; endif; unset($_from); ?>
					
					<!--
                    <div class="fuwu">
                        <div class="fuwuleft fright">
                            <div class="banji">
                                <div>
                                    <div class="h1">
                                        C1C2品质班
                                    </div>
                                </div>
                                <div class="banjitext">
                                    <p>适应对象：</p><p class="p1">成功精英阶层，注重服务细节的贵宾客户</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车时间：</p><p class="p1">周一至周日，单词练车可2小时以上</p>
                                </div>
                                <div class="banjitext">
                                    <p>拿证时间：</p><p class="p1">最快2个月左右可拿证</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车方式：</p><p class="p1">全程一对一练车，为您营造一个专业独享的学车环境</p>
                                </div>
                                <div class="liaojie">
                                    <img src="images/icon_liaojie.png" width="190" height="60"/>
                                </div>
                            </div>
                        </div>
                        <div class="fuwuright fleft">
                            <div>
                                <img src="images/icon_bj1.png" width="552" height="260">
                            </div>
                        </div>
                    </div>
                    <div class="fuwu">
                        <div class="fuwuleft">
                            <div class="banji">
                                <div>
                                    <div class="h1">
                                        C1C2品质班
                                    </div>
                                </div>
                                <div class="banjitext">
                                    <p>适应对象：</p><p class="p1">成功精英阶层，注重服务细节的贵宾客户</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车时间：</p><p class="p1">周一至周日，单词练车可2小时以上</p>
                                </div>
                                <div class="banjitext">
                                    <p>拿证时间：</p><p class="p1">最快2个月左右可拿证</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车方式：</p><p class="p1">全程一对一练车，为您营造一个专业独享的学车环境</p>
                                </div>
                                <div class="liaojie">
                                    <img src="images/icon_liaojie.png" width="190" height="60"/>
                                </div>
                            </div>
                        </div>
                        <div class="fuwuright">
                            <div>
                                <img src="images/icon_bj1.png" width="552" height="260">
                            </div>
                        </div>
                    </div>
                    <div class="fuwu">
                        <div class="fuwuleft fright">
                            <div class="banji">
                                <div>
                                    <div class="h1">
                                        C1C2品质班
                                    </div>
                                </div>
                                <div class="banjitext">
                                    <p>适应对象：</p><p class="p1">成功精英阶层，注重服务细节的贵宾客户</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车时间：</p><p class="p1">周一至周日，单词练车可2小时以上</p>
                                </div>
                                <div class="banjitext">
                                    <p>拿证时间：</p><p class="p1">最快2个月左右可拿证</p>
                                </div>
                                <div class="banjitext">
                                    <p>练车方式：</p><p class="p1">全程一对一练车，为您营造一个专业独享的学车环境</p>
                                </div>
                                <div class="liaojie">
                                    <img src="images/icon_liaojie.png" width="190" height="60"/>
                                </div>
                            </div>
                        </div>
                        <div class="fuwuright fleft">
                            <div>
                                <img src="images/icon_bj1.png" width="552" height="260">
                            </div>
                        </div>
                    </div>-->
                </div>
				
				
            </div>
        </div>
    </div>
</div>