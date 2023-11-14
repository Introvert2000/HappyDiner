<?php
session_start();

// ...

// Debugging: Dump the session variables
var_dump($_SESSION);

$yourVariable = ($_SESSION['totalAmount']);

echo "$yourVariable";
// ...
?>