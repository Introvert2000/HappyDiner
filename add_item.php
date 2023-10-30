<?php
include 'connect_rest.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $item_name = $_POST['item_name'];
    $item_description = $_POST['item_description'];
    $item_price = $_POST['item_price'];

    $sql = "INSERT INTO menu_items (item_name, item_description, item_price) VALUES ('$item_name', '$item_description', '$item_price')";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: dashboard.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
