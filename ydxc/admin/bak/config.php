<?php 
require "../config.php";

/////////////////////////////////////////////////////////////
// Please note that if you get any errors when connecting, //
// that you will need to email your host as we cannot tell //
// you what your specific values are supposed to be        //
/////////////////////////////////////////////////////////////

// type of database running
// (only mysql is supported at the moment)
$dbservertype='mysql';

// hostname or ip of server
$servername=$_CTB['dbhost'];

// username and password to log onto db server
$dbusername=$_CTB['dbuser'];
$dbpassword=$_CTB['dbpassword'];

// name of database
$dbname=$_CTB['dbname'];

// technical email address - any error messages will be emailed here
$technicalemail='';

// use persistant connections to the database
// 0 = don't use
// 1 = use
$usepconnect=0;

?>