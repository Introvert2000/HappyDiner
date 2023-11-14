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
</head>
<body>
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mapModal">
                Open Map Modal
            </button>
        </div>
    </div>

    <!-- Map Modal -->
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
            // You can display a form to collect the user's location and save it to the database.
        <?php endif; ?>
    </script>
</body>
</html>
