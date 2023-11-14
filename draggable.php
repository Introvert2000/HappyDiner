<!DOCTYPE html>
<html lang="en">
<head>
<style>
/* Add these CSS styles to your styles.css file */

body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
}

header {
    background-color: #007BFF;
    color: #fff;
    text-align: center;
    padding: 20px 0;
}

h1 {
    margin: 0;
    font-size: 2rem;
}

.orders {
    text-align: center;
    margin-top: 20px;
}

h2 {
    font-size: 1.5rem;
    margin: 0 0 20px;
}

.order-cards {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-around;
    padding: 20px;
}

.order-card {
    border: 1px solid #ccc;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 15px;
    margin: 10px;
    width: calc(30% - 20px); /* Adjust the width as needed based on your layout */
    transition: transform 0.2s;
    cursor: pointer;
}

.order-card:hover {
    transform: translateY(-5px);
}

.order-card h3 {
    margin: 0;
    font-size: 1.25rem;
    color: #007BFF;
}

.order-card p {
    color: #555;
    margin: 5px 0;
}

.process-button {
    display: block;
    background-color: #007BFF;
    color: #fff;
    padding: 5px 10px;
    text-align: center;
    text-decoration: none;
    border-radius: 3px;
    margin-top: 10px;
    transition: background-color 0.3s;
}

.process-button:hover {
    background-color: #0056b3;
}

/* The modal container */
/* Modal container */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.4);
}

/* Modal content */
.modal-content {
    background-color: #fefefe;
    margin: 10% auto; /* Center the modal vertically and horizontally */
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    max-width: 500px; /* Limit maximum width if needed */
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
    position: relative;
}

/* Close button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover,
.close:focus {
    color: #000;
}

/* Position the modal */
.modal-content {
    position: relative;
}

/* Style the form inside the modal */
form {
    text-align: center;
}

/* Style the select element */
select {
    padding: 10px;
    width: 100%;
}

/* Style the update button */
button[type="submit"] {
    background-color: #007BFF;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    margin-top: 10px;
    cursor: pointer;
}

button[type="submit"]:hover {
    background-color: #0056b3;
}


.order-card.pending {
    border: 1px solid #007BFF;
    background-color: #007BFF10; /* Blue background */
}

.order-card.processing {
    border: 1px solid #FFD500;
    background-color: #FFD50010; /* Yellow background */
}

.order-card.delivering {
    border: 1px solid #FF5733;
    background-color: #FF573310; /* Orange background */
}

.order-card.cancelled {
    border: 1px solid #FF3333;
    background-color: #FF333310; /* Red background */
}

.order-card.completed {
    border: 1px solid #3CB043;
    background-color: #3CB04310; /* Green background */
}

/* Add more styles as needed */

</style>
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

                $sql = "SELECT * FROM orders";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
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
            
            </div>
        </section>
    </main>
</body>
</html>
