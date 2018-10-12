<?php
	/*
		[CTB] (C) 2007-2009 copytaobao.com
		$Id: sign_init.php 2010-01-12 13:27:57 jerry $
	*/
	
	!defined('IN_CTB') && die('Access Denied');
	
	//权限检查
	checkpermission(); //权限检查
	
	if (isset($_POST['btnsubmit'])) {
		$aryid = simplode($_POST['itemid']);
		$_TGLOBAL['db']->query("DELETE FROM ".tname('sign')." WHERE id IN($aryid)");
		showmsg('报名删除成功！');
	}

	//排序方式
	$field  = isset($_GET['field']) ? $_GET['field'] : 'id';
	$order = isset($_GET['order']) ? $_GET['order'] : 'DESC' ;

	$perpage = 15;
	$page = empty($_GET['page']) ? 0 : intval($_GET['page']);
	$page<1 && $page = 1;
	$start = ($page-1)*$perpage;
	//检查开始数
	ckstart($start, $perpage);
	$where = " WHERE ispay=1";
	$count = $_TGLOBAL['db']->result($_TGLOBAL['db']->query("SELECT COUNT(*) FROM ".tname('sign').$where), 0);
	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('sign')." $where ORDER BY $field $order LIMIT $start,$perpage");
	$multi = multi($count, $perpage, $page, get_current_url());
	
	print_r("1111"); exit;
	
	while ($value = $_TGLOBAL['db']->fetch_array($query)) {
		$coach = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('news')." WHERE id=".$value['coach_id']);
		$value['coach_name'] = $coach['xingming'];
		if(!empty($value['inv'])){
			$captain = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$value['inv']);
	
			if(!empty($captain['cptid'])){ //如果有上级，就显示队员和队员的上级（合伙人）；否则只显示合伙人
				$value['captain_name'] = $captain['name'];
				$duiyuan = $_TGLOBAL['db']->getrow("SELECT * FROM ".tname('captain')." WHERE id=".$captain['cptid']);
				$value['duiyuan_name'] = $duiyuan['name'];
			} else {
				$value['duiyuan_name'] = $captain['name']; //显示合伙人
			}
		}
	}
?>
