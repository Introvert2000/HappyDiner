<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Reservation Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }

        h1 {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            text-decoration: none;
        }

        button {
            background-color: #333;
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    
<?php
session_start();

if (empty($_SESSION['restaurant_name'])) {
    // Redirect or handle the case where the restaurant admin is not logged in
    header('Location: login.php'); // Change the URL as needed
    exit;
}

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

$restaurantName = $_SESSION['restaurant_name'];

// Query to fetch reservations for the specific restaurant
$query = "SELECT * FROM reservations WHERE restaurant_name = ?";

// Prepare the query
$stmt = $conn->prepare($query);

if ($stmt) {
    // Bind the restaurant name to the query
    $stmt->bind_param('s', $restaurantName);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display reservation data
        echo "<h1>Reservation Data for $restaurantName</h1>";
        echo "<table border='1'>";
        echo "<tr><th>Reservation ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Time</th><th>Guests</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['booking_id'] . "</td>";
            echo "<td>" . $row['Name1'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td>" . $row['phone'] . "</td>";
            echo "<td>" . $row['booking_date'] . "</td>";
            echo "<td>" . $row['booking_time'] . "</td>";
            echo "<td>" . $row['num_of_guests'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo '<a href="dashboard_restaurant.php"><button>Return to Dashboard</button></a>';

    } else {
        echo "No reservations found for $restaurantName.";
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

// Close the database connection
$conn->close();
?>

</body>
</html>
