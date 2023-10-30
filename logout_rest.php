<?php
session_start();
unset($_SESSION['restaurant1']);
header('location:index.php');
?>