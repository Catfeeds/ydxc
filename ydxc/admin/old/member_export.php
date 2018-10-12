<?php
/*
	[CTB] (C) 2007-2009 zwon.net
	$Id: member_export.php 2012-7-4 9:03:01 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

$array = array(
    'username' => '会员编号',
    'usertype' => '会员等级',
    'lastip' => '最后登录IP',
    'times' => '登录次数',
    'regdate' => '注册时间',
    'nums' => '总推荐人数',
    'recomm_id' => '推荐人',
    'name' => '姓名',
    'phone' => '电话',
    'company' => '公司',
    'qq' => 'QQ号',
    'email' => '邮箱',
    'address' => '地址',
    'birthday' => '生日',
    'remark' => '备注',
);

//组合，将所有字段设为选中
$fields = $comm = '';
foreach($array AS $k => $v) {
    $fields .= $comm . $k;
    $comm = ',';
    //$arytitle[] = $k;
}

if ($_POST['btnexport']) { //导出

    set_time_limit(0);

    $arytitle = array();
    foreach($array AS $k => $v) {
        if(in_array($k, $_POST['fields'])) {
            $arytitle[$k] = $v;
        }
    }
    $arydata  = array();

    $keywords = trim($_POST['keywords'] ? $_POST['keywords'] : $_GET['keywords']);
    $date_start = trim($_POST['date_start'] ? $_POST['date_start'] : $_GET['date_start']);
    $date_end = trim($_POST['date_end'] ? $_POST['date_end'] : $_GET['date_end']);
    $usertype = trim($_POST['usertype'] ? $_POST['usertype'] : $_GET['usertype']);

    $where = ' WHERE 1';

    if ($keywords) {
        $where .= " AND (";
        $where .= " username LIKE '%$keywords%'";
        $where .= " OR company LIKE '%$keywords%'";
        $where .= " OR name LIKE '%$keywords%'";
        $where .= " OR email LIKE '%$keywords%'";
        $where .= " OR phone LIKE '%$keywords%'";
        $where .= " OR recomm_id LIKE '%$keywords%'";
        $where .= " OR address LIKE '%$keywords%')";
    }

    //处理日期段搜索
    if ($date_start && $date_end) {
        $date_start = strtotime($date_start.' 00:00:00'); //转换输入的时间为时间戳的方式
        $date_end = strtotime($date_end. ' 23:59:59');
        $where .= " AND (regdate between '$date_start' and '$date_end')";
    }

    $usertype && $where .= " AND usertype='$usertype'";

    $ff = implode($_POST['fields'], ',');
    $query = $_TGLOBAL['db']->query("SELECT $ff FROM ".tname('members')."$where ORDER BY uid DESC");
    while ($value = $_TGLOBAL['db']->fetch_array($query)) {
        if (in_array('valid', $_POST['fields'])) {
            $value['valid'] = $value['valid'] > 0 ? date('Y-m-d H:i', $value['valid']) : '';
        }

        if (in_array('usertype', $_POST['fields'])) {
            $value['usertype'] = $_TGLOBAL['member_group'][$value['usertype']]['name'];
        }

        $arydata[] = $value;
    }
    //echo "<PRE>";print_r($arytitle);print_r($arydata);exit;
    $filename = '会员信息';
    makeexcel($filename, $arytitle, $arydata); //文件名，标题数组，数据数组
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
    <TITLE>CTB V2.0</TITLE>
    <META http-equiv=Content-Type content="text/html; charset=utf-8">
    <LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
    <SCRIPT language=JavaScript src="js/common.js"></SCRIPT>
    <script language="JavaScript" src="js/selectTime.js"></script>
</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
<DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>批量导出会员信息</DIV>
    <form  method="post" enctype="multipart/form-data" name="FormEdit" onSubmit="return Validator.Validate(this,3)">
        <table width="80%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#FFFFFF" bordercolorlight="cccccc" bgcolor="#FFFFFF" class="list_table">
            <tbody>
            <tr>
                <td class="caption">&nbsp;</td>
                <td>&nbsp;关键词搜索
                    <input name="keywords" type="text" id="keywords" value="<?php echo $keywords; ?>" size="30">
                    <span class="p">注册日期 </span>
                    <input name="date_start" type="text" value="<?php echo $date_start; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
                    -
                    <input name="date_end" type="text" value="<?php echo $date_end; ?>" size="10" maxlength="10" onClick="SelectDate(this,'yyyy-MM-dd hh:mm:ss');">
                    会员级别查询
                    <?php GetSelect($_TGLOBAL['member_group'], 'usertype', $usertype, 'name', 'onChange="this.form.submit();"'); ?></td>
            </tr>
            <tr>
                <td width="16%" class="caption">选择导出的字段</td>
                <td width="84%"><?php GetCheckbox($array, 'fields', $fields); ?></td>
            </tr>
            <tr>
                <td class="caption">&nbsp;</td>
                <td><input name="btnexport" type="submit" class="button" id="btnexport" value="批量导出会员信息"></td>
            </tr>
            </tbody>
        </table>
    </form>
</DIV>
<?php include 'footer.php'; ?>
</BODY>
</HTML>