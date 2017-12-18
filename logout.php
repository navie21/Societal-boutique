<?php
include'../core/init.php';
unset($_SESSION['sbuser']);
session_destroy();
header('location:login.php');
?>