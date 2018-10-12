<?php
/*
	[CTB] (C) 2007-2009 
	$Id: class_mysql.php 2009-4-15 23:32:55 jerry $
*/

!defined('IN_CTB') && die('Access Denied');


class db {
	var $querynum = 0;
	var $link;
	var $charset;
	function connect($dbhost, $dbuser, $dbpw, $dbname = '', $pconnect = 0, $halt = TRUE) {
		if($pconnect) { 
			if(!$this->link = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$halt && $this->halt('Can not connect to MySQL server');
			}
		} else { 
			if(!$this->link = @mysql_connect($dbhost, $dbuser, $dbpw, 1)) {
				$halt && $this->halt('Can not connect to MySQL server');
			}
		}

		if($this->version() > '4.1') {
			if($this->charset) {
				@mysql_query("SET character_set_connection=$this->charset, character_set_results=$this->charset, character_set_client=binary", $this->link);
			}
			if($this->version() > '5.0.1') {
				@mysql_query("SET sql_mode=''", $this->link);
			}
		}
		if($dbname) {
			@mysql_select_db($dbname, $this->link);
		}
	}

	function select_db($dbname) {
		return mysql_select_db($dbname, $this->link);
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}
	
	/*function getall($sql, $type = '', $result_type = MYSQL_ASSOC) {
		$query = $this->query($sql, $type);
		$list = array();
		while ($value = $this->fetch_array($query, $result_type)) {
			$list[] = $value;
		}
		return $list;
	}*/
	
	function getall($sql, $filename='', $multi='', $type = '', $result_type = MYSQL_ASSOC) {
		$query = $this->query($sql, $type);
		$list = array();
		while ($value = $this->fetch_array($query, $result_type)) {
			if($filename && $multi){
				if(is_string($multi)){
					$list[$value[$filename]][$value[$multi]] = $value;
				}else{
					$list[$value[$filename]][] = $value;
				}
			}elseif($filename){
				$list[$value[$filename]] = $value;
			}else{
				$list[] = $value;
			}
		}
		return $list;
	}
	

	function getrow($sql, $type = '', $result_type = MYSQL_ASSOC) {
		$query = $this->query($sql, $type);
		return mysql_fetch_array($query, $result_type);
	}

	function query($sql, $type = '') {
		if(D_BUG) {
			global $_TGLOBAL;
			$sqlstarttime = $sqlendttime = 0;
			$mtime = explode(' ', microtime());
			$sqlstarttime = number_format(($mtime[1] + $mtime[0] - $_TGLOBAL['ctb_starttime']), 6) * 1000;
		}
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ?
			'mysql_unbuffered_query' : 'mysql_query';
		if(!($query = $func($sql, $this->link)) && $type != 'SILENT') {
			$this->halt('MySQL Query Error', $sql);
		}
		if(D_BUG) {
			$mtime = explode(' ', microtime());
			$sqlendttime = number_format(($mtime[1] + $mtime[0] - $_TGLOBAL['ctb_starttime']), 6) * 1000;
			$sqltime = round(($sqlendttime - $sqlstarttime), 3);

			$explain = array();
			$info = mysql_info();
			if($query && preg_match("/^(select )/i", $sql)) {
				$explain = mysql_fetch_assoc(mysql_query('EXPLAIN '.$sql, $this->link));
			}
			$_TGLOBAL['debug_query'][] = array('sql'=>$sql, 'time'=>$sqltime, 'info'=>$info, 'explain'=>$explain);
		}
		$this->querynum++;
		return $query;
	}

	function affected_rows() {
		return mysql_affected_rows($this->link);
	}

	function error() {
		return (($this->link) ? mysql_error($this->link) : mysql_error());
	}

	function errno() {
		return intval(($this->link) ? mysql_errno($this->link) : mysql_errno());
	}

	function result($query, $row) {
		$query = @mysql_result($query, $row);
		return $query;
	}

	function num_rows($query) {
		$query = mysql_num_rows($query);
		return $query;
	}

	function num_fields($query) {
		return mysql_num_fields($query);
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		return ($id = mysql_insert_id($this->link)) >= 0 ? $id : $this->result($this->query("SELECT last_insert_id()"), 0);
	}

	function fetch_row($query) {
		$query = mysql_fetch_row($query);
		return $query;
	}

	function fetch_fields($query) {
		return mysql_fetch_field($query);
	}

	function version() {
		return mysql_get_server_info($this->link);
	}

	function close() {
		return mysql_close($this->link);
	}

	function halt($message = '', $sql = '') {
		$dberror = $this->error();
		$dberrno = $this->errno();
		//echo 'db error';exit;

		$help_link = "http://www.baidu.com/s?wd=mysql+".rawurlencode($dberrno)."+".rawurlencode($dberror);
		$error =  "<div style=\"font-size:11px;font-family:verdana,arial;background:#EBEBEB;padding:0.5em;\">
				<b>MySQL Error</b><br>
				<b>Message</b>: $message<br>
				<b>SQL</b>: <pre>$sql<?pre><br>
				<b>Error</b>: $dberror<br>
				<b>Errno.</b>: $dberrno<br>
				<a href=\"$help_link\" target=\"_blank\">Click here to seek help.</a>
				</div>";

		runlog('syslog', "出错：{$error}\r\n");
		echo $error;

		exit();
	}
	
/*
* 获取特定条件的某一时间内记录数量
* $tablename  表名
* $wheresql   查询条件 可以是数组 也可以是where语句
* 				如果不存在条件就是查询表中有多少条记录
// 运用 ： 查询特定条件下的数据数量
//				如：会员车辆是否存在

* $datefile   指定这个表中的时间字段
*				如果没有 $type 和上面一样
* $type       时间规则 年：Y 月：m 日：d 时：H 分：i
* $count      与查询时间组合 n年，n月，n日 内有数据记录条数
*				如果没有$count 默认为当年、当月、当天等
// 运用： 查询特定条件下的某时间内的记录数量
//			如：今天是否签到，2小时内一个ip只能投票一次，本月是否执行某一事项
*/

function getcount($tablename, $wheresql=1, $datefile='', $type='',$count=0){
	global $_TGLOBAL;
	//查询条件
	$comma = '';
	if(is_array($wheresql)){
		foreach ($wheresql as $key => $value) {
			$where .= $comma.$key.'=\''.$value.'\'';
			$comma = ' AND ';
		}
	}else{
		$where = $wheresql;
	}
	
	//如果不存在日期直接执行返回数据
	if(!$datefile){
		$sql = "SELECT COUNT(*) FROM ".tname($tablename)." WHERE $where";
		$query = $this->query($sql);
		return $this->result($query,0);
	}
	
	
	//如果存在日期就先查询 在判断是不是存在
	if($datefile){
		$sql = "SELECT $datefile FROM ".tname($tablename)." WHERE $where";
		$list = $this -> getall($sql);
		switch ($type) {
			case 'Y':  //N年有多少条记录
				$date = strtotime(date("Y-1-1 0:0:0", strtotime("-$count year",$_TGLOBAL['timestamp'])));
				foreach($list as $key=>$val){
					if($val[$datefile] < $date) {
						unset($list[$key]);
					}
				}
				return count($list);
				break; 
				
			case 'm':  //N月有多少条记录
				$date = strtotime(date("Y-m-1 0:0:0", strtotime("-$count month",$_TGLOBAL['timestamp'])));
				$date = strtotime("-$count month",$_TGLOBAL['timestamp']);
				foreach($list as $key=>$val){
					if($val[$datefile] < $date) {
						unset($list[$key]);
					}
				}
				return count($list);
				break; 
				
			case 'd':  //N天有多少条记录
				$date = strtotime(date("Y-m-d 0:0:0", strtotime("-$count day",$_TGLOBAL['timestamp'])));
				foreach($list as $key=>$val){
					if($val[$datefile] < $date) {
						unset($list[$key]);
					}
				}
				return count($list);
				break; 
				
			case 'H':  //N时有多少条记录
				$date = strtotime(date("Y-m-d H:0:0", strtotime("-$count hours",$_TGLOBAL['timestamp'])));
				foreach($list as $key=>$val){
					if($val[$datefile] < $date) {
						unset($list[$key]);
					}
				}
				return count($list);
				break; 
				
			case 'i':  //N分钟有多少条记录
				$date = strtotime(date("Y-m-d H:i:0", strtotime("-$count minute",$_TGLOBAL['timestamp'])));
				foreach($list as $key=>$val){
					if($val[$datefile] < $date) {
						unset($list[$key]);
					}
				}
				return count($list);
				break; 
				
			default:
				return count($list);
				break; 
		} // 结束switch
	} //结束if
}

	
	
}

?>