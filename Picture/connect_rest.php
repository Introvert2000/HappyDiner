<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "restaurant";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
?>