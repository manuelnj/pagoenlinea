<?php

// Configuraci�n DB
$server = 'localhost';
$db = 'cal_pagosweb';
$user = 'root';
$pass = 'paraque';


 // Connect to Database
 $connection = mysql_connect($server, $user, $pass) 
 or die ("Could not connect to server ... \n" . mysql_error ());
 mysql_select_db($db) 
 or die ("Could not connect to database ... \n" . mysql_error ());
mysql_query("SET NAMES 'utf8'")
 or die ("Could not connect to database ... \n" . mysql_error ());
?>