<!DOCTYPE html>
<html lang="en">
<head>
    <title>Display City Name and Map</title>
    <!-- Include Leaflet.js library -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
      /* Set the map container's size */
      #map {
        height: 400px;
        width: 100%;
      }
    </style>
</head>
<body>
    <?php
    // Step 1: Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "login";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Retrieve latitude, longitude, and restaurant ID from the database
    $query = "SELECT restaurant_id, latitude, longitude FROM restaurant ";
    $result = $conn->query($query);

    $markers = []; // Array to store marker coordinates and restaurant IDs

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $id = $row["restaurant_id"];
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
            $restaurantName = $row["restaurant_name"];
            $markers[] = ["restaurant_id" => $id, "coordinates" => [$latitude, $longitude],"restaurant_info" =>$restaurantName];
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "No results found in the database.";
    }
    ?>

    <!-- Create a map container -->
    <div id="map"></div>

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
            echo "restaurantMarker.bindTooltip('<p>Restaurant Info</p><p>Restaurant Name : " . $marker["restaurant_info"] . "</p>').openTooltip();\n";
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
            navigator.geolocation.getCurrentPosition(function(position) {
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
</body>
</html>
