<?php
session_start();


$host = 'localhost';
$username = 'root';
$password = '';
$database = 'login';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user's location is in the database
$name = ($_SESSION['Name1']);
$sql = 'SELECT * FROM reg WHERE Name1 = ?';
$userStmt = $conn->prepare($sql);
$userStmt->bind_param('s', $name);

if ($userStmt->execute()) {
    // Location found in the database
    $result = $userStmt->get_result();
    $data = $result->fetch_assoc();
    $latitude = $data['lat'];
    $longitude = $data['lon'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>Map Modal</title>
    <!-- Add Bootstrap CSS and JavaScript links -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Add Leaflet CSS and JavaScript links -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        #map {
            height: 300px;
        }
    </style>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .grid-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-gap: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        p {
            font-weight: bold;
        }

        #totalAmountDisplay {
            color: #333;
            text-align: right;
        }

        form {
            margin-top: 20px;
        }

        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }

        #map {
            height: 400px;
        }
    </style>
</head>
<body>
    <!-- Header and other content -->

    <main>
    <div class="grid-container">
            <div class="map-card">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                            Open Map Modal
                        </button>
                    </div>
                </div>
            </div>

            <div class="container">
                <div>
                    <h1>Payment Details</h1>

                    <!-- Order Summary -->
                    <h2>Order Summary</h2>
                    <table>
                        <tr>
                            <th>Item</th>
                            <th>Quantity</th>
                            <th>Price</th>
                        </tr>
                        <!-- JavaScript will dynamically add rows here -->
                    </table>

                    <!-- Display the total amount -->
                    <p>Total Amount: <span id="totalAmountDisplay">0.00</span></p>

                    <!-- Payment Form and Location Form -->
                    <!-- Your forms here -->
                    <form action="payscript2.php" method="post">
                        <input type="hidden" id="totalAmount" name="totalAmount" value="0">
                        <input type="hidden" name="restaurantName" id="restaurantName" value="">
                        <!-- Add a hidden input field for cart items -->
                        <input type="hidden" id="cartItems" name="cartItems" value="">
                        <button type="submit">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mapModalLabel">Location Map</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Map container -->
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>

            

        <script>
          const urlParams = new URLSearchParams(window.location.search);
        const restaurantName = urlParams.get('restaurantName');

        // Set the restaurantName hidden input field
        document.getElementById("restaurantName").value = restaurantName;

        const storedCartItems = JSON.parse(localStorage.getItem("cartItems"));
        const orderSummaryTable = document.querySelector("table");
        let totalAmount = 0;

        if (storedCartItems && storedCartItems.length > 0) {
            // Loop through the storedCartItems and add rows to the table
            storedCartItems.forEach(item => {
                const row = orderSummaryTable.insertRow();
                const itemNameCell = row.insertCell(0);
                const quantityCell = row.insertCell(1);
                const priceCell = row.insertCell(2);

                itemNameCell.textContent = item.name;
                quantityCell.textContent = 1; // You can adjust this as needed
                priceCell.textContent = `$${item.price.toFixed(2)}`;
                totalAmount += item.price;
            });

            // Update the totalAmount input field
            document.getElementById("totalAmount").value = totalAmount.toFixed(2);

            // Display the total amount
            const totalAmountDisplay = document.getElementById("totalAmountDisplay");
            totalAmountDisplay.textContent = `$${totalAmount.toFixed(2)}`;

            // Set the cartItems input field with the JSON string
            const cartItemsInput = document.getElementById("cartItems");
            cartItemsInput.value = JSON.stringify(storedCartItems);
        } else {
            // Handle the case where there are no items in the cart
            alert("Your cart is empty. Please add items to your cart.");
            // Redirect the user to the restaurant menu page or another appropriate page
            window.location.href = "restaurant_menu.php";
        }
    </script>

    </main>



    
    <script>
        // Check if latitude and longitude are available
        <?php if (isset($latitude) && isset($longitude)) : ?>
            // Display location on the map
            var map = L.map('map').setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map)
                .bindPopup('User Location');
        <?php else : ?>
            // Location not found, prompt user to enter their location
            alert("Location not found in the database. Please enter your location.");
            window.location.href = "addlocation.php";
                        // You can display a form to collect the user's location and save it to the database.
        <?php endif; ?>
    </script>



</body>
</html>
