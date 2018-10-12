<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: function_cron.php 2009-5-31 15:07:08 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

function runcron($cronid = 0) {
	global $_TGLOBAL;

	$query = $_TGLOBAL['db']->query("SELECT * FROM ".tname('crons')." WHERE ".($cronid ? "cronid='$cronid'" : "available>'0' AND nextrun<='$_TGLOBAL[timestamp]'")." ORDER BY nextrun LIMIT 1");

	if($cron = $_TGLOBAL['db']->fetch_array($query)) {

		$lockfile = S_ROOT.'./data/runcron_'.$cron['cronid'].'.lock';

		$cron['filename'] = str_replace(array('..', '/', '\\'), '', $cron['filename']);
		$cronfile = S_ROOT.'./lib/crons/'.$cron['filename'];

		if(is_writable($lockfile) && filemtime($lockfile) > $_TGLOBAL['timestamp'] - 600) {
			return NULL;
		} else {
			@touch($lockfile);
		}

		@set_time_limit(1000);
		@ignore_user_abort(TRUE);

		$cron['minute'] = explode("\t", $cron['minute']);
		cronnextrun($cron);

		extract($GLOBALS, EXTR_SKIP);
		if(!@include $cronfile) {
			runlog('CRON', $cron['name'].' : Cron script('.$cron['filename'].') not found or syntax error', 0);
		}

		file_exists($lockfile) && unlink($lockfile);
	}

	$nextrun = getcount('crons', "available>'0' ORDER BY nextrun", 'nextrun');
	//if(!$nextrun === FALSE) {
		require_once S_ROOT.'./source/function_cache.php';
	//	$_TGLOBAL['setting']['cronnextrun'] = $nextrun;
		config_cache();
	//}
}

function cronnextrun($cron) {
	global $_TGLOBAL;

	if(empty($cron)) return FALSE;

	list($yearnow, $monthnow, $daynow, $weekdaynow, $hournow, $minutenow) = explode('-', gmdate('Y-m-d-w-H-i', $_TGLOBAL['timestamp'] + $_TGLOBAL['setting']['timeoffset'] * 3600));

	if($cron['weekday'] == -1) {
		if($cron['day'] == -1) {
			$firstday = $daynow;
			$secondday = $daynow + 1;
		} else {
			$firstday = $cron['day'];
			$secondday = $cron['day'] + gmdate('t', $_TGLOBAL['timestamp'] + $_TGLOBAL['setting']['timeoffset'] * 3600);
		}
	} else {
		$firstday = $daynow + ($cron['weekday'] - $weekdaynow);
		$secondday = $firstday + 7;
	}

	if($firstday < $daynow) {
		$firstday = $secondday;
	}

	if($firstday == $daynow) {
		$todaytime = crontodaynextrun($cron);
		if($todaytime['hour'] == -1 && $todaytime['minute'] == -1) {
			$cron['day'] = $secondday;
			$nexttime = crontodaynextrun($cron, 0, -1);
			$cron['hour'] = $nexttime['hour'];
			$cron['minute'] = $nexttime['minute'];
		} else {
			$cron['day'] = $firstday;
			$cron['hour'] = $todaytime['hour'];
			$cron['minute'] = $todaytime['minute'];
		}
	} else {
		$cron['day'] = $firstday;
		$nexttime = crontodaynextrun($cron, 0, -1);
		$cron['hour'] = $nexttime['hour'];
		$cron['minute'] = $nexttime['minute'];
	}

	$nextrun = @gmmktime($cron['hour'], $cron['minute'] > 0 ? $cron['minute'] : 0, 0, $monthnow, $cron['day'], $yearnow) - $_TGLOBAL['setting']['timeoffset'] * 3600;

	$availableadd = $nextrun > $_TGLOBAL['timestamp'] ? '' : ', available=\'0\'';
	$_TGLOBAL['db']->query("UPDATE ".tname('crons')." SET lastrun='$_TGLOBAL[timestamp]', nextrun='$nextrun' $availableadd WHERE cronid='$cron[cronid]'");
	return TRUE;
}

function crontodaynextrun($cron, $hour = -2, $minute = -2) {
	global $_TGLOBAL;

	$hour = $hour == -2 ? gmdate('H', $_TGLOBAL['timestamp'] + $_TGLOBAL['setting']['timeoffset'] * 3600) : $hour;
	$minute = $minute == -2 ? gmdate('i', $_TGLOBAL['timestamp'] + $_TGLOBAL['setting']['timeoffset'] * 3600) : $minute;

	$nexttime = array();
	if($cron['hour'] == -1 && !$cron['minute']) {
		$nexttime['hour'] = $hour;
		$nexttime['minute'] = $minute + 1;
	} elseif($cron['hour'] == -1 && $cron['minute'] != '') {
		$nexttime['hour'] = $hour;
		if(($nextminute = cronnextminute($cron['minute'], $minute)) === false) {
			++$nexttime['hour'];
			$nextminute = $cron['minute'][0];
		}
		$nexttime['minute'] = $nextminute;
	} elseif($cron['hour'] != -1 && $cron['minute'] == '') {
		if($cron['hour'] < $hour) {
			$nexttime['hour'] = $nexttime['minute'] = -1;
		} elseif($cron['hour'] == $hour) {
			$nexttime['hour'] = $cron['hour'];
			$nexttime['minute'] = $minute + 1;
		} else {
			$nexttime['hour'] = $cron['hour'];
			$nexttime['minute'] = 0;
		}
	} elseif($cron['hour'] != -1 && $cron['minute'] != '') {
		$nextminute = cronnextminute($cron['minute'], $minute);
		if($cron['hour'] < $hour || ($cron['hour'] == $hour && $nextminute === false)) {
			$nexttime['hour'] = -1;
			$nexttime['minute'] = -1;
		} else {
			$nexttime['hour'] = $cron['hour'];
			$nexttime['minute'] = $nextminute;
		}
	}

	return $nexttime;
}

function cronnextminute($nextminutes, $minutenow) {
	foreach($nextminutes as $nextminute) {
		if($nextminute > $minutenow) {
			return $nextminute;
		}
	}
	return false;
}
?>