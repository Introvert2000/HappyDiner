<!DOCTYPE html>
<html>
<head>
    <title>Display City Name and Map</title>
    <!-- Include Leaflet.js library -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    />
    <script
      src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
    ></script>
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
    $dbname = "data";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Step 2: Retrieve latitude and longitude from the database
    $query = "SELECT latitude, longitude FROM coordinates WHERE id=3";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Assuming only one row is retrieved, you can loop through the results if needed
        $row = $result->fetch_assoc();
        $latitude = $row["latitude"];
        $longitude = $row["longitude"];

        // Step 3: Use the latitude and longitude values in your API request
        $api_key = "your_api_key";
        $url = "https://api.geoapify.com/v1/geocode/reverse?lat={$latitude}&lon={$longitude}&format=json&apiKey=6280fa3f1f5e4b7ca8931c01979b1e88";
        // $url = "https://api.example.com/endpoint?lat=$latitude&lon=$longitude&apikey=$api_key";

        // You can now make an API request using $url
        // You may use cURL or any other method to make the request
        // Example:
        $response = file_get_contents($url);

        // Handle the API response as JSON
        $responseData = json_decode($response);

        if ($responseData && isset($responseData->features[0])) {
            $city = $responseData->features[0]->properties->city;
            // Display the city name in an alert box
            // echo "<script>alert('You chose $city');</script>";
        } else {
            // echo "City name not found in the API response.";
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
        // Use the retrieved latitude and longitude to create a map
        var map = L.map("map").setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 12);

        // Add a tile layer to the map (you can use different map tile providers)
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        // Add a marker to the map at the specified latitude and longitude
        L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);

        var userMarkerIcon = L.divIcon({
            className: 'user-marker',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            html: '<div class="user-marker-icon"></div>'
        });

        // Get the user's current location
        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;
                console.log(userLatitude);
                console.log(userLongitude);
                // Add a marker for the user's current location with the custom icon
                L.marker([userLatitude, userLongitude], { icon: userMarkerIcon }).addTo(map);
            });
        } else {
            console.log("Geolocation is not available in this browser.");
        }

        var map = L.map("map").setView([15.5186, 73.8274], 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        // Define the waypoints (latitude and longitude)
        var waypoints = [
            [15.4965743, 73.8254905],
            [15.5403071, 73.8455048]
        ];

        // Create a routing control with the specified waypoints
        L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim(),
        }).addTo(map);
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
            background-color: #ff5733; /* Change the color here */
            border-radius: 50%;
        }
    </style>
</body>
</html>
