<?php

########## MySql details (Replace with yours) #############
$username = "root"; //mysql username
$password = ""; //mysql password
$hostname = "localhost"; //hostname
$databasename = 'galaxy_writing'; //databasename


$link = mysqli_connect($hostname,$username,$password);
mysqli_select_db($link, $databasename)or die(mysql_error($link));

$url = "http://brecagalaxy.com/admin";


?>