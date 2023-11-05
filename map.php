<!DOCTYPE html>
<html>
<head>
    <title>Map Display</title>
    <!-- Include Leaflet CSS and JavaScript -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        /* Define a size for the map */
        #map {
            width: 50%;
            height: 400px;
        }
    </style>
</head>
<body>
    <!-- Create a map container -->
    <div id="map"></div>

    <!-- Include your JavaScript code for displaying the map -->
    <script>
        console.log("Hello");
        let marker;
        let lat, lon; // Variables to store latitude and longitude

        const map = L.map('map').setView([15.496777, 73.827827], 13);

        // Add OpenStreetMap tiles
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Function to handle map click event for adding a marker and capturing lat/lng
        function handleMapClick(event) {
            if (marker) {
                marker.remove();
            }

            const { lat: clickLat, lng: clickLng } = event.latlng;
            lat = clickLat; // Store latitude in variable
            lon = clickLng; // Store longitude in variable

            const apiKey = '6280fa3f1f5e4b7ca8931c01979b1e88'; // Replace with your Geoapify API key

            fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${clickLat}&lon=${clickLng}&apiKey=${apiKey}`)
                .then((response) => response.json())
                .then(data => {
                    if (data.features.length === 0) {
                        console.log("The address is not found");
                        return;
                    }
                    console.log(data);
                    const foundAddress = data.features[0];
                    const city = foundAddress.properties.city;

                    alert(`You chose ${city}`);
                    console.log(city);
                    console.log(foundAddress);
                    marker = L.marker(new L.LatLng(foundAddress.properties.lat, foundAddress.properties.lon)).addTo(map);

                    // Show a button for confirming and saving coordinates
                    const confirmButton = document.getElementById('confirm-button');
                    if (confirmButton) {
                        confirmButton.style.display = 'block';
                    }
                });
        }

        // Add a click event listener to the map to handle adding markers
        map.on('click', handleMapClick);

        // Function to save coordinates to the database
        function saveCoordinates() {
            // Send latitude and longitude to the PHP script for database storage
            fetch('save_coordinates.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `lat=${lat}&lon=${lon}`,
            }).then(response => {
                if (response.ok) {
                    alert('Coordinates saved to the database!');
                } else {
                    alert('Failed to save coordinates.');
                }
            });
        }
    </script>
    
    <button id="confirm-button" style="display: none;" onclick="saveCoordinates()">Confirm and Save</button>
</body>
</html>
