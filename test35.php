<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation List</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        h1 {
            text-align: center;
            padding: 20px;
            background-color: #007BFF;
            color: #fff;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            padding: 20px;
        }

        .reservation-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            width: 300px;
            margin: 10px;
        }

        .reservation-card h2 {
            font-size: 1.5rem;
            color: #007BFF;
            margin: 0 0 10px;
        }

        .reservation-card p {
            color: #555;
            margin: 5px 0;
        }

        .view-details-button {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .view-details-button:hover {
            background-color: #0056b3;
        }

        .change-status-button {
            background-color: #ccc;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .change-status-button:hover {
            background-color: #555;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            max-width: 500px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .close {
            color: #aaaaaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover, .close:focus {
            color: #000;
        }

        .modal-content label {
            display: block;
            margin-top: 10px;
        }

        .modal-content input[type="number"] {
            width: 100%;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .modal-content button[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .modal-content button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Reservation List</h1>
    <div class="container">
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

        // SQL query to retrieve reservations
        $sql = "SELECT * FROM reservations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="reservation-card">';
                echo '<h2>Reservation ID: ' . $row['booking_id'] . '</h2>';
                echo '<p>Customer Name: ' . $row['Name1'] . '</p>';
                echo '<p>Reservation Date: ' . $row['booking_date'] . '</p>';
                echo '<p>Status: ' . $row['status'] . '</p>';
                echo '<button class="view-details-button" data-reservation-id="' . $row['booking_id'] . '">View Details</button>';
                
                echo '</div>';
                $status = $row['status'];
                $amount = $row['amount'];
            }
        }
        ?>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Reservation Details</h2>
            <div id="reservationDetails">
                <!-- Reservation details will be displayed here -->
            </div>
            <?php
            
            if ($status === 'dining' && empty($amount)) {
                echo '<form id="amountForm">';
                echo '<label for="amount">Amount:</label>';
                
                if (in_array($row['status'], ['reserved', 'completed', 'cancelled', 'dining'])) {
                    echo '  <select id="statusSelect" name="status" required>
                            <option value="reserved">Reserved</option>
                            <option value="dining">Dining</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                            </select>';
                    
                    echo '<input type="number" id="amount" name="amount" step="0.01" required>';
                    echo '<button type="submit" id="submitAmount">Save Amount and Status</button>';
                }
                
                echo '</form>';
            }
            $conn->close();
            ?>
        </div>
    </div>


    <script>
        // Get the modal and close button elements
        var modal = document.getElementById("myModal");
        var closeBtn = document.querySelector(".close");

        // Get all the "View Details" buttons
        var viewDetailButtons = document.querySelectorAll(".view-details-button");

        // Store the current reservation ID for amount submission
        var currentReservationId;

        // When a "View Details" button is clicked, open the modal and fetch/display details
        viewDetailButtons.forEach(function (button) {
    button.addEventListener("click", function () {
        var reservationId = this.getAttribute("data-reservation-id");
        currentReservationId = reservationId;

        // Make an AJAX request to get reservation details
        fetch('get_reservation_details.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'booking_id=' + reservationId,
        })
        .then(response => response.json())
        .then(data => {
            displayReservationDetails(data);
            modal.style.display = "block";  // Corrected line
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});

        // Close the modal when the close button is clicked
        closeBtn.addEventListener("click", function () {
            modal.style.display = "none";
        });

        // Close the modal when the user clicks outside of it
        window.addEventListener("click", function (event) {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        });

        // Function to display reservation details in the modal
        function displayReservationDetails(details) {
            var reservationDetailsElement = document.getElementById("reservationDetails");
            if (details) {
                reservationDetailsElement.innerHTML = `
                    <p><strong>Reservation ID:</strong> ${details.booking_id}</p>
                    <p><strong>Customer Name:</strong> ${details.Name1}</p>
                    <p><strong>Reservation Date:</strong> ${details.booking_date}</p>
                    <p class="status"><strong>Status :</strong> ${details.status}</p>
                `;
            } else {
                reservationDetailsElement.innerHTML = "No reservation details found.";
            }
        }

        // Add an event listener for the form submission
        document.getElementById("amountForm").addEventListener("submit", function (e) {
            e.preventDefault();

            // Get the amount from the form
            var amount = document.getElementById("amount").value;

            // Make an AJAX request to update the database with the amount
            fetch('update_amount.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    booking_id: currentReservationId,
                    amount: amount,
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close the modal
                    modal.style.display = "none";
                } else {
                    console.error('Error:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
