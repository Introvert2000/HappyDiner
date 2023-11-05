<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <header>
        <h1>Admin Panel</h1>
        
    </header>
    <main>
        <section class="orders">
            <h2>Orders for Delivery</h2>
            <div class="order-cards">
    <?php
                // Database connection parameters
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "login";
                session_start();
                // Create a connection to the MySQL database
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check the connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Function to display the modal dialog
                echo '<div id="myModal" class="modal">
                        <div class="modal-content">
                            <span class="close">&times;</span>
                            <form method="post" action="">
                                <label for="new_status">Select Status:</label>
                                <select name="new_status" id="new_status">
                                    <option value="Pending">Pending</option>
                                    <option value="Processing">Processing</option>
                                    <option value="Delivering">Delivering</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                                <input type="hidden" id="order_id" name="order_id">
                                <button type="submit" name="update_status">Update</button>
                            </form>
                        </div>
                    </div>';

                

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_status"])) {
                    $order_id = $_POST["order_id"];
                    $new_status = $_POST["new_status"];
                    // Update the status of the order
                    $update_sql = "UPDATE `orders` SET `status` = ? WHERE `orders`.`order_id` = ?";
                    $stmt = $conn->prepare($update_sql);
                    $stmt->bind_param("si", $new_status, $order_id);
                
                    // Execute the prepared statement to update the status
                    if ($stmt->execute()) {
                        // Status updated successfully
                        header('Location: draggable.php'); // Redirect to your admin dashboard
                    } else {
                        // Check for SQL errors
                        echo "Error executing SQL statement: " . $stmt->error;
                    }
                
                    $stmt->close(); // Close the prepared statement after execution
                }
                
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
                        // Determine the CSS class based on the status
                        $statusClass = '';
                        switch ($row['status']) {
                            case 'Pending':
                                $statusClass = 'pending';
                                break;
                            case 'Processing':
                                $statusClass = 'processing';
                                break;
                            case 'Delivering':
                                $statusClass = 'delivering';
                                break;
                            case 'Cancelled':
                                $statusClass = 'cancelled';
                                break;
                            case 'Completed':
                                $statusClass = 'completed';
                                break;
                            default:
                                $statusClass = ''; // No specific class for other statuses
                        }

                        // Apply the CSS class to the order card
                        echo "<div class='order-card $statusClass'>";
                        echo "<h3>Order ID: " . $row['order_id'] . "</h3>";
                        echo "<p>Customer: " . $row['customer_username'] . "</p>";
                        echo "<p>Date: " . $row['order_date'] . "</p>";
                        echo "<p>Status: " . $row['status'] . "</p>";
                        echo "<button class='update-button' data-order-id='" . $row['order_id'] . "'>Update</button>";
                        echo "</div>";
                    }
                } 
                else {
                    echo "<div class='no-orders'>No orders found for delivery.</div>";
                }

                // Close the database connection
                $conn->close();
    ?>
                
            
            <!-- Add the Back to Dashboard button as a button element -->
            <button class="back-button" onclick="window.location.href='dashboard_restaurant.php'">Back to Dashboard</button>

            </div>
        </section>

    </main>
</body>
</html>

<script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Get the button that opens the modal
        var buttons = document.getElementsByClassName("update-button");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal
        for (var i = 0; i < buttons.length; i++) {
            buttons[i].onclick = function() {
                var orderId = this.getAttribute("data-order-id");
                document.getElementById("order_id").value = orderId;
                modal.style.display = "block";
            }
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
</script>