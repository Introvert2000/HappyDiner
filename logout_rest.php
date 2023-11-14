<?php
session_start();
unset($_SESSION['restaurant_name']);
header('location:index.php');
?>