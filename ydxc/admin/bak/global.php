<?php 
error_reporting(7);

require("./bak/config.php");
require("./bak/adminfunctions.php");

$dbservertype = strtolower($dbservertype);
$dbclassname="./bak/db_$dbservertype.php";
require($dbclassname);


$DB_site=new DB_Sql_vb;

$DB_site->database=$dbname;
$DB_site->server=$servername;
$DB_site->user=$dbusername;
$DB_site->password=$dbpassword;

$DB_site->connect();



$db=new DB_Sql_vb;

$db->database=$dbname;
$db->server=$servername;
$db->user=$dbusername;
$db->password=$dbpassword;

$db->connect();
?>