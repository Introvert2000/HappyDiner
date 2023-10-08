<?php
session_start();
$restaurantName = $_GET['restaurantName'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Other Page</title>
</head>
<body>
    <h2>Restaurant Name: <?php echo $restaurantName; ?></h2>
</body>
</html>
