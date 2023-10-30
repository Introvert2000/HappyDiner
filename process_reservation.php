<?php
session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $restaurantName = $_POST['restaurantName'];
        $name = $_POST["name"];
        $date = $_POST["date"];
        $time = $_POST["time"];

        // Create a database connection (replace with your database credentials)
        $conn = new mysqli("localhost", "root", "", "login");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        
        {
            // The date and time are available, so proceed with the reservation
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $num_of_guests = $_POST["guests"];
            

            // Insert the reservation into the database
            $stmt = $conn->prepare("INSERT INTO reservations (name, date, email, phone, time, num_of_guests, restaurant_name) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssis", $name, $date, $email, $phone, $time, $num_of_guests, $restaurantName);

            if ($stmt->execute()) {

                                        $stmt1 = $conn->prepare("SELECT id FROM your_table WHERE name = ?");
                        $stmt1->bind_param("s", $name); // "s" means the variable is a string

                        // Execute the prepared statement
                        $stmt1->execute();

                        // Bind the result
                        $stmt->bind_result($id);

                        // Fetch the result
                        if ($stmt1->fetch()) {
                            echo "ID: " . $id;
                        } else {
                            echo "No record found with the given name.";
                        }
                header('location:detail.php');
                                    }
            else {
                echo "Error: " . $stmt->error;
            }
        }

        $stmt->close();
        $conn->close();
    }
    ?>

    