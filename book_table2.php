<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Table Booking</title>
    <link rel="stylesheet" href="book_table.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        /* Set the map container's size */
        #map {
            height: 400px;
            width: 50%;
        }
    </style>

    <style>
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="./index.php">Happy Diner</a>
                </div>
                <div class="menu">
                    <?php
                    session_start();
                    if (empty($_SESSION['Name1'])) {
                        ?>
                        <ul>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    <?php } else {
                        ?>
                        <div class="dropdown">
                            <ul>
                                <li id="username"><a>
                                        <?php if (!empty($_SESSION['Name1'])) {
                                            echo $_SESSION['Name1'];
                                        } ?>
                                    </a></li>
                            </ul>
                            <button class="dropdown-button">&#9660;</button>
                            <div class="dropdown-content">
                                <a href="dashboard.php">Dashboard</a>
                                <a href="logout.php">Logout</a>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="center-form">
            <?php
            $restaurantName = $_GET['restaurantName'];
            ?>

            <h2><?php echo $restaurantName; ?></h2>

            <section class="center-form" id="booking-form">
                <div>
                    <h2>Reservation Details</h2>
                    <form action="process_reservation.php" method="post">
                        <input type="hidden" name="restaurantName" value="<?php echo $restaurantName; ?>">

                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required><br><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required><br><br>

                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required><br><br>

                        <label for="time">Time:</label>
                        <input type="time" id="time" name="time" required><br><br>

                        <label for="guests">Number of Guests:</label>
                        <input type="number" id="guests" name="guests" required><br><br>

                        <input type="submit" id="sub_button" value="Submit Reservation">
                    </form>
                </div>
            </section>
        </div>

        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT latitude, longitude FROM restaurant WHERE restaurant_name='$restaurantName'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
        }
        ?>


<script>
    var map = L.map("map").setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);

        var userMarkerIcon = L.divIcon({
            className: "user-marker",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            html: '<div class="user-marker-icon"></div>',
        });

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;
                L.marker([userLatitude, userLongitude], {
                    icon: userMarkerIcon
                }).addTo(map);
            });
        }

        // Define waypoints here if needed
        var waypoints = [
            [15.4965743, 73.8254905],
            [15.5403071, 73.8455048]
        ];

        L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim(),
        }).addTo(map);
        </script>

<div id="orderConfirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeOrderModal">&times;</span>
        <div id="map"></div>        
        <button id="confirmOrderButton">Confirm Order</button>
    </div>
</div>
<div class="review">
    <!-- Fetch reviews from the source and display them here -->
</div>
</main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo $restaurantName; ?></p>
    </footer>
</body>

</html>
