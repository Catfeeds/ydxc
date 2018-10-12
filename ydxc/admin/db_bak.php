<?php
/*
	[CTB] (C) 2007-2009 51shop.org jerry
	$Id: db_bak.php 2010-01-12 17:54:33 jerry $
*/

!defined('IN_CTB') && die('Access Denied');

checkpermission(); //权限检查

$register_globals = get_cfg_var("register_globals");
if ($register_globals!=1) { 
	extract((array)$_POST, EXTR_SKIP); 
	extract((array)$_GET, EXTR_SKIP); 
}

if (isset($_POST['action'])) {
	$action = $_POST['action'];
} else if (isset($_GET['action'])) {
	$action = $_GET['action'];
}

if (function_exists("set_time_limit")==1 AND get_cfg_var("safe_mode")==0) {
	set_time_limit(0);
}

if (isset($action) AND ($action=="csvtable" or $action=="sqltable")) {
  $noheader=1;
}

//suppress gzipping
$nozip=1;

require("./bak/global.php");

ReadTableComment(); //取得所有表的注释

///adminlog(iif($table!="","Table = $table",""));

// data dump functions
function sqldumptable($table, $fp=0) {
  global $DB_site, $AryTableComment, $AryTableType, $date_start, $date_end;

  $tabledump = "DROP TABLE IF EXISTS $table;\n";
  $tabledump .= "CREATE TABLE $table (\n";

  $firstfield=1;

  // get columns AND spec
  $fields = $DB_site->query("SHOW FIELDS FROM $table");
  while ($field = $DB_site->fetch_array($fields)) {
    if (!$firstfield) {
      $tabledump .= ",\n";
    } else {
      $firstfield=0;
    }
    $tabledump .= "   $field[Field] $field[Type]";

//如果为日期或日期时间类型，则加上时间段的判断
//开始时间和结束时间都存在，同时，类型为日期或日期时间
if (($date_start != "" && $date_end != "" ) && ($field[Type] == "date" || $field[Type] == "datetime")) {
	$TmpSqlDate = " WHERE ($field[Field] BETWEEN '$date_start' AND '$date_end')";
}

    if (!empty($field["Default"])) {
      // get default value
      $tabledump .= " DEFAULT '$field[Default]'";
    }
		if ($field['Null'] != "YES") {
      // can field be null
      $tabledump .= " NOT NULL";
    }
    if ($field['Extra'] != "") {
      // any extra info?
      $tabledump .= " $field[Extra]";
    }
  }
  $DB_site->free_result($fields);

  // get keys list
  $keys = $DB_site->query("SHOW KEYS FROM $table");
  while ($key = $DB_site->fetch_array($keys)) {
    $kname=$key['Key_name'];
    if ($kname != "PRIMARY" AND $key['Non_unique'] == 0) {
      $kname="UNIQUE|$kname";
    }
    if(!is_array($index[$kname])) {
      $index[$kname] = array();
    }
    $index[$kname][] = $key['Column_name'];
  }
  $DB_site->free_result($keys);

  // get each key info
  $index = isset($index) ? $index : array();
  while(list($kname, $columns) = each($index)){
    $tabledump .= ",\n";
    $colnames=implode($columns,",");

    if($kname == "PRIMARY"){
      // do primary key
      $tabledump .= "   PRIMARY KEY ($colnames)";
    } else {
      // do stANDard key
      if (substr($kname,0,6) == "UNIQUE") {
        // key is unique
        $kname=substr($kname,7);
      }

      $tabledump .= "   KEY $kname ($colnames)";

    }
  }
if ($AryTableType[$table] == "")
	$table_type = "MyISAM";
else
	$table_type = $AryTableType[$table];

//print_r($AryTableType);exit;
 //ENGINE=MyISAM DEFAULT CHARSET=utf8

  //$tabledump .= "\n) TYPE=".$table_type." COMMENT='".$AryTableComment[$table]."';\n\n";

  $tabledump .= "\n) ENGINE=MyISAM DEFAULT CHARSET=utf8;\n\n";

//开始时间和结束时间都存在，同时，类型为日期或日期时间
//如果开始、结束时间存在，则不把sql语句删除
if ($date_start != "" && $date_end != "") {
	$tabledump = "";
}

  if ($fp) {
    fwrite($fp,$tabledump);
  } else {
    echo $tabledump;
  }

  // get data
  $rows = $DB_site->query("SELECT * FROM $table $TmpSqlDate");
  $numfields=$DB_site->num_fields($rows);
  while ($row = $DB_site->fetch_array($rows)) {
    $tabledump = "INSERT INTO $table VALUES(";

    $fieldcounter=-1;
    $firstfield=1;
    // get each field's data
    while (++$fieldcounter<$numfields) {
      if (!$firstfield) {
        $tabledump.=", ";
      } else {
        $firstfield=0;
      }

      if (!isset($row[$fieldcounter])) {
        $tabledump .= "NULL";
      } else {
        $tabledump .= "'".mysql_escape_string($row[$fieldcounter])."'";
      }
    }

    $tabledump .= ");\n";
    
    if ($fp) {
      fwrite($fp,$tabledump);
    } else {
      echo $tabledump;
    }
  }
  $DB_site->free_result($rows);

  //return $tabledump;
}

function csvdumptable($tablelist,$separator,$quotes,$showhead) {
  global $DB_site;

  // get columns for header row

	foreach($tablelist AS $table) { //选中的所有表

	  if ($showhead) {
		$firstfield=1;
		$fields = $DB_site->query("SHOW FIELDS FROM $table");
		while ($field = $DB_site->fetch_array($fields)) {
		  if (!$firstfield) {
			$contents.=$separator;
		  } else {
			$firstfield=0;
		  }
		  $contents.=$quotes.$field['Field'].$quotes;
		}
		$DB_site->free_result($fields);
	  }
	  $contents.="\n";


	  // get data
	  $rows = $DB_site->query("SELECT * FROM $table");
	  $numfields=$DB_site->num_fields($rows);
	  while ($row = $DB_site->fetch_array($rows)) {

		$fieldcounter=-1;
		$firstfield=1;
		while (++$fieldcounter<$numfields) {
		  if (!$firstfield) {
			$contents.=$separator;
		  } else {
			$firstfield=0;
		  }

		  if (!isset($row[$fieldcounter])) {
			$contents .= "NULL";
		  } else {
			$contents .= $quotes.addslashes($row[$fieldcounter]).$quotes;
		  }
		}

		$contents .= "\n";
	  }
	  $DB_site->free_result($rows);

	}

  return $contents;
}

if ($_POST['action']=="csvtable") {
	header("Content-type:text/csv");
	header("Content-Disposition:attachment;filename=CSV_DATA.csv");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public'); 


  echo csvdumptable($table,$separator,$quotes,$showhead);

  exit;

}

if ($_POST['action']=="sqltable") {
	  //得到日期的值
  $date_start = $_POST['date_start'];
  $date_end = $_POST['date_end'];

	header("Content-type:text/csv");
	header("Content-Disposition:attachment;filename=dbbackup-".date("m-d-Y",time()).".sql");
	header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
	header('Expires:0');
	header('Pragma:public'); 

	$result=$DB_site->query("SHOW tables");
	while (list($key,$val)=each($table)) {
		if ($val==1) {
		  sqldumptable($key);
		  echo "\n\n\n";
		}
  }

  exit;

}

cpheader();

if (isset($action)==0) {
  $action="choose";
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>CTB V2.0</TITLE>
<META http-equiv=Content-Type content="text/html; charset=utf-8">
<LINK media=screen href="images/admin.css" type=text/css rel=stylesheet>
<SCRIPT language=JavaScript src="js/common.js"></SCRIPT>

</HEAD>
<BODY onLoad="return write_nav('<?php echo $_TGLOBAL['menu']['main'][$ac]; ?> &raquo; <?php echo $_TGLOBAL['menu'][$ac][$mod]; ?> &raquo; ');">
  <DIV class=datacontainer2 style="WIDTH: 98%">
    <DIV class=header>数据库备份 </DIV>
<?php
if ($action=="choose") {

  ?>
    在这里, 你可以备份你的 网站 数据库
    <?php 
  doformheader("","sqltable");
  maketableheader("备份包括的数据表");

  echo "<tr class='firstalt'><td colspan='3'><font color=blue>开始日期 <input type=\"text\" size=\"12\" name=\"date_start\"> 结束日期 <input type=\"text\" size=\"12\" name=\"date_end\"> 日期格式为：年-月-日 如果开始日期、结束日期同时存在，将备份时间段的信息，但此备份的数据中没有建表的SQL语句。</font></td></tr>\n";
  
  $result=$DB_site->query("SHOW tables");
  while ($currow=$DB_site->fetch_array($result)) {
      //当表的前缀不等于系统设置的前缀时,则进行下一个循环
	  if ($_CTB['tablepre'] && substr($currow[0], 0, strlen($_CTB['tablepre'])) != $_CTB['tablepre']) continue;
	  makeyesnocode($currow[0],"table[$currow[0]]",1);
  }

  doformfooter("备份","重选",3);


  doformheader("","sqlfile");
  maketableheader("保存文件到服务器:");
  makeinputcode("在服务器上的路径和文件名","filename","./bak/dbbackup-".date("m-d-Y",time()).".sql",0,60);
  echo "<tr class='firstalt'><td colspan='2'><p><b>在这个目录必须有PHP写入权限</b> (一般设置 chmod 0777)</p></td></tr>\n";
  echo "<tr class='firstalt'><td colspan='2'><p><b>警告:</b> 不要把你的备份置于一个Internet可访问的目录. 如果可能最好把它放到WEB根目录以外!</p></td></tr>\n";
  doformfooter("保存文件");

  doformheader("","csvtable");
  maketableheader("CSV 方式导出:");

  echo "<tr class='".getrowbg()."'>\n<td><p>选择数据表:</p></td>\n<td><p>";
  echo "<select name=\"table[]\" size=\"8\" multiple=\"multiple\">\n";

  $result=$DB_site->query("SHOW tables");
  while ($currow=$DB_site->fetch_array($result)) {
      //当表的前缀不等于系统设置的前缀时,则进行下一个循环
	  if ($_CTB['tablepre'] && substr($currow[0], 0, strlen($_CTB['tablepre'])) != $_CTB['tablepre']) continue;
	  echo "<option value=\"$currow[0]\">$currow[0]</option>\n";
  }

  echo "</SELECT> 按CTRL或SHIFT键可多选</p></td></tr>\n\n";

  makeinputcode("分隔","separator",",");
  makeinputcode("注释","quotes","'");
  makeyesnocode("显示 column 名字","showhead",1);

  doformfooter("确定");

}

if ($_POST['action']=="sqlfile") {

  //得到日期的值
  $date_start = $_POST['date_start'];
  $date_end = $_POST['date_end'];

  $filehANDle=fopen($filename,"w");
  $result=$DB_site->query("SHOW tables");
  while ($currow=$DB_site->fetch_array($result)) {		
		//当表的前缀不等于系统设置的前缀时,则进行下一个循环
		if ($_CTB['tablepre'] && substr($currow[0], 0, strlen($_CTB['tablepre'])) != $_CTB['tablepre']) continue;
		
		sqldumptable($currow[0], $filehANDle);
		fwrite($filehANDle, "\n\n\n");
		echo "<p>正在导出 $currow[0]</p>";
  }
  fclose($filehANDle);

  echo "<p>数据成功导出!</p>";

}

cpfooter();
?>
  </DIV>
  <?php include 'footer.php'; ?>
</BODY>
</HTML>