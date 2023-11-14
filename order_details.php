<?php
// Define a function to fetch order items
function getOrderItems($orderID, $conn) {
    $orderItems = array();

    $sql = "SELECT item_name, item_price FROM order_items WHERE order_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $orderID); // "i" represents an integer, adjust if needed

        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $orderItems[] = $row;
        }

        $stmt->close();
    }

    return $orderItems;
}

// Start the session and retrieve the orderID from the query string
session_start();
$orderID = $_GET['orderID'];

// Database connection information
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details from the database based on orderID
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $orderID); // "i" represents an integer, adjust if needed

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Order found, fetch and display order details
        $row = $result->fetch_assoc();

        // Retrieve order details
        $customerName = $row['customer_username'];
        $totalAmount = $row['total_amount'];
        $restaurant = $row['restaurant_name'];

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "Order not found.";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Fetch order items based on the orderID using the getOrderItems function
$orderItems = getOrderItems($orderID, $conn);


$Name1 = $_SESSION['Name1'];

// Define the SQL query
$sql = "SELECT * FROM reg WHERE Name1 = ?";
$stmt = $conn->prepare($sql);

if ($stmt) {
    // Bind the parameter
    $stmt->bind_param("s", $Name1); // "s" represents a string, adjust as needed

    // Execute the prepared statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Loop through the results
        while ($row = $result->fetch_assoc()) {
            // Retrieve data from the database
            $location = $row['location'];
            $mobileNumber = $row['MobileNo'];
            
            // Use the retrieved data as needed
        }
    }
}
// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <style>
body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
    }

    .container {
        background-color: #fff;
        border-radius: 5px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    h1 {
        color: #333;
        font-size: 24px;
    }

    h2 {
        color: #333;
        font-size: 20px;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    p {
        font-size: 18px;
    }

    #totalAmountDisplay {
        font-weight: bold;
    }

    /* Style the table rows */
    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    /* Style the table cells */
    td {
        padding: 10px;
    }

    form {
        text-align: center;
        margin-top: 20px;
    }

    button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        font-size: 16px;
    }

    button:hover {
        background-color: #0056b3;
    }
    
    /* ... Existing CSS styles ... */

    .hidden {
        display: none;
    }

</style></head>
<body>
    <!-- Header and other content -->

    <main>
        <div class="container">
            <h1>Order Details</h1>

            <!-- Display order details in a table -->
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Restaurant Name</th>
                </tr>
                <tr>
                    <td><?php echo $orderID; ?></td>
                    <td><?php echo $customerName; ?></td>
                    <td>$<?php echo number_format($totalAmount, 2); ?></td>
                    <td><?php echo $restaurant; ?></td>
                </tr>
            </table>

            <h2>Order Items</h2>

            <!-- Display order items in a table -->
            <table>
                <tr>
                    <th>Item</th>
                    <th>Price</th>
                </tr>
                <!-- Retrieve and display order items here -->
                <?php
                foreach ($orderItems as $orderItem) {
                    echo "<tr>";
                    echo "<td>" . $orderItem['item_name'] . "</td>";
                    echo "<td>$" . number_format($orderItem['item_price'], 2) . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>

            <h2>Custom Details</h2>
            <span id="locationDetails" class="hidden">
                            <?php echo $location; ?><br>
                            <?php echo $mobileNumber; ?>
            </span>
            <button id="toggleLocation">Show Location</button>
        </div>
    </main>

    <!-- Footer and other content -->
</body>
</html>
<script>
    const locationDetails = document.getElementById("locationDetails");
    const toggleLocationButton = document.getElementById("toggleLocation");

    toggleLocationButton.addEventListener("click", () => {
        if (locationDetails.classList.contains("hidden")) {
            locationDetails.classList.remove("hidden");
            toggleLocationButton.textContent = "Hide Location";
        } else {
            locationDetails.classList.add("hidden");
            toggleLocationButton.textContent = "Show Location";
        }
    });
</script>
