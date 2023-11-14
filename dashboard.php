<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
	
    <style>
        /* Add your CSS styles here */
		
        <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .containerz {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    h1 {
        text-align: center;
    }

    .account-info {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
    }

    .booking-history,
    .orders-history {
        border: 1px solid #ccc;
        padding: 10px;
        margin-bottom: 20px;
    }

    .orders-history {
        float: right; /* Float to the right for a separate column */
        width: 45%; /* Adjust the width as needed */
    }

    .order-details {
        margin-top: 10px;
    }

    /* Clear float to avoid overlapping columns */
    .clear {
        clear: both;
    }
</style>

		</style>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Happy Diner</a>
                </div>
                

                <div class="menu">
                   
                    
                    <?php 
                        session_start();
                    {
                        ?>
                        <ul>
                       
                        </ul>                     
                        <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
</header>
    <div class="containerz">
        <h1>Dashboard</h1>

        <div class="account-info">
            <h2>Account Information</h2>
            <p><strong>Account Name:</strong>  <?php if(!empty($_SESSION['Name1'])){ echo $_SESSION['Name1']; }?></p>
        </div>

    <div class="booking-history">
        <?php
               $host = 'localhost';
               $username = 'root';
               $password = '';
               $database = 'login';
               
               // Create a connection to the MySQL database
               $mysqli = new mysqli($host, $username, $password, $database);
               
               if ($mysqli->connect_error) {
                   die("Connection failed: " . $mysqli->connect_error);
               }
               
               // First, select the email associated with Name1
               $sql = "SELECT email FROM reg WHERE Name1 = ?";

               if ($stmt = $mysqli->prepare($sql)) {
                   $stmt->bind_param('s', $_SESSION['Name1']);
                   $stmt->execute();
                   $result = $stmt->get_result();
               
                   if ($result->num_rows > 0) {
                       $row = $result->fetch_assoc();
                       $email = $row['email']; // Save the email from the result
                       $stmt->close();
               
                       // Now, use the email to fetch booking data
                       $query = "SELECT * FROM reservations WHERE email = ?";
                       if ($stmt = $mysqli->prepare($query)) {
                           $stmt->bind_param('s', $email);
                           $stmt->execute();
                           $result = $stmt->get_result();
               
                           if ($result->num_rows > 0) {
                               while ($row = $result->fetch_assoc()) {
                                   // Process the reservation data for this email
                                   echo "Booking ID: " . $row['booking_id'] . "<br>";
                                   echo "Restaurant: " . $row['restaurant_name'] . "<br>";
                                   echo "Date: " . $row['booking_date'] . "<br>";
                                   // Add more fields as needed
                                   echo "<br>";
                               }
                           }
                           $stmt->close();
                       } else {
                           echo "Error: " . $mysqli->error;
                       }
                   }
               } else {
                   echo "Error: " . $mysqli->error;
               }
               
               // Close the database connection
               $mysqli->close();
               
?>
</div>
<div class="orders-history">
<?php
// Connect to the database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'login';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you have the username stored in a session variable
if (isset($_SESSION['Name1'])) {
    $username = $_SESSION['Name1'];
    // Step 1: Fetch the user's information (e.g., email) from the registration table
    
    $userSql = "SELECT Username FROM reg WHERE Name1 = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("s", $username);
    
    if ($userStmt->execute()) {
        $userResult = $userStmt->get_result();
        $userData = $userResult->fetch_assoc();
        $user_name = $userData['Username'];
    }
    // Step 2: Fetch the user's orders from the orders table
    // $ordersSql = "SELECT * FROM orders WHERE customer_username = ?";
    // $ordersStmt = $conn->prepare($ordersSql);
    // $ordersStmt->bind_param("s", $username);
    
    $ordersSql = "SELECT * FROM orders WHERE customer_username = ?";
$ordersStmt = $conn->prepare($ordersSql);
$ordersStmt->bind_param("s", $user_name);

if ($ordersStmt->execute()) {
    $ordersResult = $ordersStmt->get_result();

    if ($ordersResult->num_rows === 0) {
        echo "No orders found.";
    } else {
        echo "Function executed3";
        while ($orderData = $ordersResult->fetch_assoc()) {
            echo "<h2>Order ID: " . $orderData['order_id'] . "</h2>";
            echo "Order Date: " . $orderData['order_date'] . "<br>";
            echo '<a href="order_details.php?orderID=' . $orderData['order_id'] . '" class="btn-link">View Details</a>';

            // Place the code to fetch and display order items here
            $orderItemsSql = "SELECT item_name, item_price FROM order_items WHERE order_id = ?";
            $orderItemsStmt = $conn->prepare($orderItemsSql);
            $orderItemsStmt->bind_param("i", $orderData['order_id']);

            if ($orderItemsStmt->execute()) {
                $orderItemsResult = $orderItemsStmt->get_result();

                if ($orderItemsResult->num_rows === 0) {
                    echo "No items found for this order.";
                } else {
                    echo "<ul>";
                    while ($itemData = $orderItemsResult->fetch_assoc()) {
                        echo "<li>Product: " . $itemData['item_name'] . ", Price: " . $itemData['item_price'] . "</li>";
                    }
                    echo "</ul>";
                }
            } else {
                echo "Error fetching order items: " . $conn->error;
            }
        }
    }
} else {
    echo "Error fetching orders: " . $conn->error;
}

    
}
else{ 
    echo "test";
  }

// Close the database connection
$conn->close();
?>


        <form action="logout.php" method="post">
        <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>

