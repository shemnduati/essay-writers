<?php
//to be changed to previous logins
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "galaxy_writing";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>