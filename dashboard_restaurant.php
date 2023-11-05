<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add custom styles for the side drawer */
        #sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        #sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #555;
        }

        #menu-content {
            display: flex; /* Use flexbox for layout */
            margin-left: 250px;
            padding: 15px;
        }

        #menu-items {
            flex: 1; /* The first column takes up 50% of the width */
            padding-right: 20px;
        }

        #dashboard-actions {
            flex: 1; /* The second column takes up 50% of the width */
        }

        /* Add this to your existing CSS */
.action-button {
    margin-bottom: 10px;
}

.action-button button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.action-button button:hover {
    background-color: #45a049;
}

/* Add this to your existing CSS */
.menu-items-container {
    margin-top: 20px;
}

.menu-items-container table {
    width: 100%;
    border-collapse: collapse;
}

.menu-items-container table th,
.menu-items-container table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.menu-items-container table th {
    background-color: #f2f2f2;
    color: #333;
}

.menu-items-container table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.menu-items-container table tr:nth-child(odd) {
    background-color: #fff;
}

.menu-items-container table a.delete-link {
    color: #f44336;
    text-decoration: none;
    margin-right: 10px;
}

.menu-items-container table a.delete-link:hover {
    text-decoration: underline;
}
/* Add this to your existing CSS */
.add-item-button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 0;
    cursor: pointer;
    border-radius: 5px;
}

.add-item-button:hover {
    background-color: #45a049;
}

#sidenav {
            height: 100%;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        #sidenav a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        #sidenav a:hover {
            background-color: #555;
        }

        #menu-content {
            margin-left: 250px;
            padding: 15px;
        }

        .summary-cards {
    display: flex;
    justify-content: space-between;
}

.summary-card {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    padding: 20px;
    flex: 1;
    margin-right: 10px;
}
    </style>
</head>
<body>
<!-- <header>
        <nav>
            <div class="container">
                <div class="logo">
                </div>
                <div class="search-bar">
                </div>
                <div class="menu">
                   <ul>
                        <li id="restaurant_name"> <a><?php if(!empty($_SESSION['restaurant_name'])){ echo $_SESSION['restaurant_name']; }?></a> </li>
                       <li>
                        <?php
                            echo '<button onclick="location.href=\'upload_image.php\'">Upload Restaurant Picture</button>';
                        ?>
                       </li>
                    </ul>
                </div>
            </div>
        </nav>
</header> -->
<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

// Create a connection to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define the restaurant name
$restaurantName = $_SESSION['restaurant_name'];

// SQL query to select orders for a specific restaurant
$sql = "SELECT * FROM orders WHERE restaurant_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $restaurantName);

$stmt->execute();
$result = $stmt->get_result();

// Get the number of rows (results)
$numRows = mysqli_num_rows($result);

// Define the restaurant name
$sql = "SELECT * FROM reservations WHERE restaurant_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $restaurantName);

$stmt->execute();
$result = $stmt->get_result();

// Get the number of rows (results)
$numRows3 = mysqli_num_rows($result);

// SQL query to select the total revenue for a specific restaurant
$sql = "SELECT SUM(total_amount) as total_amount FROM orders WHERE restaurant_name = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $restaurantName);

$stmt->execute();
$result = $stmt->get_result();

// Fetch the total revenue
if ($row = $result->fetch_assoc()) {
    $totalRevenue = $row['total_amount'];
} else {
    $totalRevenue = 0; // Set the total revenue to 0 if no orders found
}
$sql = "SELECT COUNT(DISTINCT customer_username) AS customer_username FROM orders";

// Execute the SQL query
$result = $conn->query($sql);

if ($result) {
    // Fetch the result as an associative array
    $row = $result->fetch_assoc();

    // Get the count of distinct customer usernames
    $distinctCustomersCount = $row['customer_username'];


} 

// Close the database connection
$conn->close();

// Close the database connection

?>

<div id="menu-content">
    <!-- Right Column: Dashboard Actions -->
    <div id="sidenav">
        <a href="reservation.php">Check Bookings</a>
        <a href="order.php">Check Orders</a>
        <a href="logout_rest.php">Logout</a>
        <!-- Add more navigation links as needed -->
    </div>
   
    <!-- Left Column: Menu Items -->
    <div id="menu-items">
            <div class="summary-cards">
                <div class="summary-card">
                    <h2>Total revenue</h2>
                    <p style="font-size: 24px;"><?php echo $totalRevenue?></p>

                </div>
                <div class="summary-card">
                    <h2>No of orders</h2>
                    <p style="font-size: 24px;"><?php echo $numRows?></p>
                </div>
                <div class="summary-card">
                    <h2>No of Customers</h2>
                    <p style="font-size: 24px;"><?php echo $distinctCustomersCount?></p>
                </div>
                <div class="summary-card">
                    <h2>No of Reservation</h2>
                    <p style="font-size: 24px;"><?php echo $numRows3?></p>
                </div>
            </div>
        <h2>Menu Items</h2>
        <div class="menu-items-container">
        <table>
            <tr>
                <th>Item Name</th>
                <th>Item Price</th>
                <th>Actions</th>
            </tr>
            <?php
            
                    include 'connect_rest.php';
                    $restaurant = $_SESSION['restaurant_name'];
                    $sql = "SELECT * FROM `$restaurant`";
                    $result = mysqli_query($connection, $sql);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['food_item'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
            ?>
        </table>
        </div>
        <div class="action-button">
            <form action="add_item2.php" method="post" enctype="multipart/form-data">
            <button type="submit" class="add-item-button">Add Item</button>
            </form>
        </div>
    </div>

</div>
</body>
</html>
