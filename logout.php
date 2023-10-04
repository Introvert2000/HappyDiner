<?php
session_start();
unset($_SESSION['Name1']);
header('location:index.php');
?>