<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- You can link to your CSS file here -->
</head>
<body>
    

    <main>
        <div class="center-form">
            <h2>Reservation Details</h2>
            <?php
            // Connect to the database
            $conn = new mysqli("localhost", "root", "", "login");

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Retrieve reservation details from the database based on a unique identifier (e.g., reservation ID)
            $reservation_id = $_GET['reservation_id']; // Assuming you have a unique identifier for reservations

            $sql = "SELECT * FROM reservations WHERE id = " . $reservation_id;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $name = $row['name'];
                $date = $row['reservation_date'];
                $time = $row['reservation_time'];
                $email = $row['email'];
                $phone = $row['phone'];
                $num_of_guests = $row['num_of_guests'];
                $restaurant_name = $row['restaurant_name'];

                echo "<p><strong>Name:</strong> $name</p>";
                echo "<p><strong>Date:</strong> $date</p>";
                echo "<p><strong>Time:</strong> $time</p>";
                echo "<p><strong>Email:</strong> $email</p>";
                echo "<p><strong>Phone:</strong> $phone</p>";
                echo "<p><strong>Number of Guests:</strong> $num_of_guests</p>";
                echo "<p><strong>Restaurant Name:</strong> $restaurant_name</p>";
            } else {
                echo "Reservation not found.";
            }

            $conn->close();
            ?>
        </div>
    </main>

    <footer>
        <p>&copy;
            <?php echo date("Y"); ?>
        </p>
    </footer>
</body>
</html>
