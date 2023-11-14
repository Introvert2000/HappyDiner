<!DOCTYPE html>
<html>
<head>
    <title>Table Reservation</title>
</head>
<body>
    <h2>Table Reservation</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        // Create a database connection (replace with your database credentials)
        $conn = new mysqli("localhost", "root", "", "login");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the requested date and time are available
        // $stmt = $conn->prepare("SELECT id FROM reservations WHERE date = ? AND time = ?");
        // $stmt->bind_param("ss", $date, $time);
        // $stmt->execute();
        // $stmt->store_result();

        // if ($stmt->num_rows > 0) {
        //     echo "Sorry, the requested date and time are not available. Please choose a different date and time.";
        // } else 
        {
            // The date and time are available, so proceed with the reservation
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $num_of_guests = $_POST["num_of_guests"];
            $restaurant_name = $_POST["restaurant_name"];

            // Insert the reservation into the database
            $stmt = $conn->prepare("INSERT INTO reservations (name, date, email, phone, time, num_of_guests, restaurant_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssis", $name, $date, $email, $phone, $time, $num_of_guests, $restaurant_name);

            if ($stmt->execute()) {
                echo "Reservation saved successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="time" name="time" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br>

        <label for="num_of_guests">Number of Guests:</label>
        <input type="number" name="num_of_guests" required><br>

        <label for="restaurant_name">Restaurant Name:</label>
        <input type="text" name="restaurant_name" required><br>

        <input type="submit" value="Submit Reservation">
    </form>
</body>
</html>
