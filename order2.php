<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Orders Page</title>
    <link rel="stylesheet" href="order.css"> <!-- Add your CSS styles if needed -->
</head>
<body>
    <header>
        <!-- Add your header content here -->
    </header>

    <main>
        <div class="container">
            <h1>Orders List</h1>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Order Date</th>
                    <th>Order Time</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    
                    <th>Special Instructions</th>
                    <th>Restaurant Name</th>
                    <th>Order Summary</th>
                    <th>Action</th> <!-- Add a new column for order summary -->
                </tr>

                <?php
                session_start();
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "login";

                // Create a connection
                $conn = new mysqli($servername, $username, $password, $dbname);
                ///////
                // Check the connection

                $new_status = $_SESSION['restaurant_name'];
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT * FROM orders WHERE restaurant_name = ?";
                $stmt = $conn->prepare($sql);

                // Bind the parameter (in this case, a string)
                $stmt->bind_param("s", $new_status);

                // Execute the statement
                $stmt->execute();

                // Get the result set
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                // Fetch and display the data
                while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["order_id"] . "</td>";
                        echo "<td>" . $row["customer_username"] . "</td>";
                        echo "<td>" . $row["customer_email"] . "</td>";
                        echo "<td>" . $row["order_date"] . "</td>";
                        echo "<td>" . $row["order_time"] . "</td>";
                        echo "<td>" . $row["total_amount"] . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["special_instructions"] . "</td>";
                        echo "<td>";
                    
                        // Fetch order summary for this order from the "order_items" table
                        $order_id = $row["order_id"];
                        $orderSummary = getOrderSummary($conn, $order_id);
                    
                        if (!empty($orderSummary)) {
                            echo "<ul>";
                            foreach ($orderSummary as $summaryItem) {
                                echo "<li>{$summaryItem['item_name']} (Qty: {$summaryItem['quantity']})</li>";
                            }
                            echo "</ul>";
                        }
                    
                        echo "</td>";
                        
                        // Add buttons for order status updates
                        echo "<td>";
                        if ($row["status"] === "Pending") {
                            echo '<button onclick="updateOrderStatus(' . $row["order_id"] . ', \'Processing\')">Processing</button>';
                        } elseif ($row["status"] === "Processing") {
                            echo '<button onclick="updateOrderStatus(' . $row["order_id"] . ', \'Delivered\')">Delivered</button>';
                        } elseif ($row["status"] === "Delivered") {
                            echo "Completed";
                        }
                        echo "</td>";
                    
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No orders found.</td></tr>";
                }

                // Close the database connection
                $conn->close();

                // Function to fetch order summary
                function getOrderSummary($connection, $order_id) {
                    $orderSummary = array();
                    $sql = "SELECT item_name, quantity FROM order_items WHERE order_id = $order_id";
                    $result = $connection->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $orderSummary[] = $row;
                        }
                    }

                    return $orderSummary;
                }
                ?>
            </table>
        </div>
    </main>

    <!-- JavaScript function to update order status -->
    <script>
        function updateOrderStatus(orderId, newStatus) {
            // Replace this URL with your actual server endpoint for order status updates
            const updateStatusURL = 'https://your-api-endpoint.com/updateOrderStatus';

            // Data to send to the server
            const data = {
                orderId: orderId,
                newStatus: newStatus
            };

            // Options for the fetch request
            const fetchOptions = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            };

            // Make the AJAX request
            fetch(updateStatusURL, fetchOptions)
                .then(response => {
                    if (response.ok) {
                        alert("Status of Order ID " + orderId + " updated to " + newStatus);
                        // You can update the UI here
                    } else {
                        alert("Failed to update status for Order ID " + orderId);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

    <footer>
        <!-- Add your footer content here -->
    </footer>
</body>
</html>
