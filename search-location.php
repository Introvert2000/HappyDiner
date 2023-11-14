<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="./search3.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        /* Set the map container's size */
        #map {
            height: 400px;
            width: 100%;
        }

        /* Add this to your CSS file (search3.css or index.css) */
        .search-bar {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .search-bar form {
            display: flex;
            align-items: center;
        }

        .search-bar input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
            width: 300px;
            font-size: 16px;
        }

        .search-button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Happy Diner</a>
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
                    <?php } else { ?>
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
                    <?php } ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="search-bar">
            <form action='search-location.php' method="POST">
                <input type="text" name="query" placeholder="Search products">
                <button type="submit" class="search-button">Search</button>
            </form>
        </div>
        <div class="result-container">
            <!-- Left section for search results -->
            <div class="search-results">
                <?php
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "login";

// Create a database connection
$conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if a search query is provided
if (isset($_POST["query"])) {
    $query = $_POST["query"];
    $_SESSION['place'] = $query;
    // Modify your database query to search for products based on the query
    $stmt = $conn->prepare("SELECT * FROM restaurant WHERE city LIKE ?");
    $searchQuery = "%" . $query . "%";
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display search results
    if ($result->num_rows > 0) {
        $markers = []; // Array to store marker coordinates and restaurant IDs

        while ($row = $result->fetch_assoc()) {
            $id = $row["restaurant_id"];
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
            $restaurantName = $row["restaurant_name"];
            $markers[] = ["restaurant_id" => $id, "coordinates" => [$latitude, $longitude], "restaurant_info" => $restaurantName];
            ?>
    
            <div class="card2">
                <div class="image2">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />
                </div>
                <div class="caption">
                    <form method="POST" action="test6.php">
                        <h1 class="product_name">
                            <?php echo $restaurantName; ?>
                        </h1>
                        <button type="button" class="button" onclick="displaySelectedOptionOrder('<?php echo $restaurantName; ?>')">Order</button>
                        <button type="button" class="button" onclick="displaySelectedOptionBook('<?php echo $restaurantName; ?>')">Book</button>

                        <script>
                            function displaySelectedOptionOrder(restaurantName) {
                                window.location.href = `delivery_product.php?restaurantName=${restaurantName}`;
                            }

                            function displaySelectedOptionBook(restaurantName) {
                                window.location.href = `book_table.php?restaurantName=${restaurantName}`;
                            }
                        </script>
                    </form>
                </div>
            </div>
        <?php
        }
    } else {
        echo "No results found for: " . htmlspecialchars($query);
    }
}                ?>
            </div>

            <!-- Right section for the map -->
            <div class="map-container">
                <div id="map"></div>
            </div>
        </div>
        <?php
        // Database configuration
        
        ?>


        

        <script>
            // Create a map with a default view
            var map = L.map("map").setView([<?php echo $markers[0]["coordinates"][0]; ?>, <?php echo $markers[0]["coordinates"][1]; ?>], 12);

            // Add a tile layer to the map (you can use different map tile providers)
            L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                maxZoom: 19,
            }).addTo(map);

            // Add markers for each restaurant location
            <?php
            foreach ($markers as $marker) {
                echo "var restaurantMarker = L.marker([" . $marker["coordinates"][0] . ", " . $marker["coordinates"][1] . "]).addTo(map);\n";
                // Add a tooltip with information for each restaurant
                echo "restaurantMarker.bindTooltip('<p>" . $marker["restaurant_info"] . "</p>').openTooltip();\n";
                // Add a click event to open a new PHP page
                echo "restaurantMarker.on('click', function() { window.location.href = 'restaurant_details.php?id=" . $marker["restaurant_id"] . "'; });\n";
            }
            ?>

            // Add a marker for the user's current location (if available)
            var userMarkerIcon = L.divIcon({
                className: 'user-marker',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34],
                html: '<div class="user-marker-icon"></div>'
            });

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var userLatitude = position.coords.latitude;
                    var userLongitude = position.coords.longitude;
                    var userMarker = L.marker([userLatitude, userLongitude], { icon: userMarkerIcon }).addTo(map);
                    // Add a tooltip for the user's marker
                    userMarker.bindTooltip('<p>Your Location</p><p>Latitude: ' + userLatitude + '</p><p>Longitude: ' + userLongitude + '</p>').openTooltip();
                });
            } else {
                console.log("Geolocation is not available in this browser.");
            }
        </script>

        <style>
            /* Define CSS for the custom marker icon */
            .user-marker {
                width: 25px;
                height: 41px;
            }

            .user-marker-icon {
                width: 100%;
                height: 100%;
                border-radius: 50%;
            }
        </style>
    </main>
</body>

</html>