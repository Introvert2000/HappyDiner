<?php
session_start();
// Assuming you have retrieved the restaurant name from your database
$restaurantName = "Restaurant XYZ"; // Replace this with your actual data

// Set the restaurant name in a session variable
$_SESSION['restaurant'] = $restaurantName;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Page</title>
</head>
<body>
    <p class="product_name"><?php echo $restaurantName; ?></p>
    <button type="button" onclick="displaySelectedOption('<?php echo $restaurantName; ?>')">Option 1</button>
    <script>
        function displaySelectedOption(restaurantName) {
            window.open(`otherpage.php?restaurantName=${restaurantName}`, "_blank");
        }
    </script>
</body>
</html>
