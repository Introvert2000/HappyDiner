<?php
    // Start the session
    session_start();

    // Retrieve cart data from the session
    $cartData = isset($_GET['cartItems']) ? json_decode($_GET['cartItems'], true) : [];
    $restaurantName = $_GET['restaurantName'];
    $_SESSION['cartItem'] = $cartData;
    // Clear the session variable to prevent displaying the same data on page refresh
    unset($_GET['cartItems']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
</style>
    <title>Payment Page</title>
</head>
<body>
<form action="payscript2.php" method="post">

<?php
$totalAmount = 0;
?>
<!-- Add your page content here -->

<div class="container">
<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($cartData as $item): ?>
            <tr>
                <td><?php echo $item['name']; ?></td>
                <td>$<?php echo $item['price']; ?></td>
                <td><?php echo $item['quantity']; ?></td>
            </tr>
            <?php
                $totalAmount += $item['price'] * $item['quantity'];
                $_SESSION['totalamount'] = $totalAmount;
            endforeach; ?>
    </tbody>
    <tfoot>
            <tr>
                <td colspan="2"></td>
                <td>Total: $<?php echo number_format($totalAmount, 2); ?></td>
            </tr>
        </tfoot>
</table>

    <button type="submit" class="submit-button">Submit Order</button>
</form>
</body>
</html>
