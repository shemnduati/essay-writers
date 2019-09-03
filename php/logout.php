<?php
unset($_SESSION['writingSite_sessid']);
session_start();
session_destroy();
header('location:../login.php')
?>
