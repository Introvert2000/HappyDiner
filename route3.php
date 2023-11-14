<!DOCTYPE html>
<html>
<head>
    <title>Geolocation Autocomplete</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* Styling for the autocomplete dropdown */
        #autocomplete-items {
            position: absolute;
            border: 1px solid #ccc;
            border-top: none;
            max-height: 150px;
            overflow-y: auto;
            display: none;
        }

        .autocomplete-item {
            padding: 10px;
            cursor: pointer;
        }

        .autocomplete-item:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div id="latlon">Latitude: N/A, Longitude: N/A</div>
    <div id="map" style="width: 50%; height: 50vh"></div>
    <input type="text" id="search-input" placeholder="Enter a location">
    <button onclick="geocodeLocation()">Geocode Location</button>
    <div id="autocomplete-items"></div>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([15.286691, 73.969780], 10);
        mapLink = "<a href='http://openstreetmap.org'>OpenStreetMap</a>";
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { attribution: 'Leaflet &copy; ' + mapLink + ', contribution', maxZoom: 18 }).addTo(map);

        var marker;

        // Event listener for input changes
        var searchInput = document.getElementById("search-input"); // Corrected reference to the input field
        var autocompleteItems = document.getElementById("autocomplete-items"); // Corrected reference to the dropdown

        searchInput.addEventListener("input", function() {
            const inputValue = this.value.toLowerCase();
            autocompleteItems.innerHTML = "";

            if (!inputValue) {
                autocompleteItems.style.display = "none";
                return;
            }

            const apiUrl = `https://api.geoapify.com/v1/geocode/autocomplete?text=${inputValue}&apiKey=6280fa3f1f5e4b7ca8931c01979b1e88`;

            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    if (data.features && data.features.length > 0) {
                        data.features.forEach(feature => {
                            const county = feature.properties.county;
                            const city = feature.properties.city;
                            const postcode = feature.properties.postcode;
                            const state = feature.properties.state;
                            // Check if these properties are defined before including them
                            if (county !== undefined || city !== undefined || postcode !== undefined || state !== undefined) {
                                const itemElement = document.createElement("div");
                                itemElement.classList.add("autocomplete-item");
                                let suggestion = "";

                                if (city) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${city}`;
                                }

                                if (state) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${state}`;
                                }

                                itemElement.textContent = suggestion;
                                itemElement.addEventListener("click", function() {
                                    searchInput.value = suggestion;
                                    autocompleteItems.style.display = "none";
                                    geocodeLocation();
                                });
                                autocompleteItems.appendChild(itemElement);
                            }
                        });
                        autocompleteItems.style.display = "block";
                    } else {
                        autocompleteItems.style.display = "none";
                    }
                })
                .catch(error => {
                    console.error("Error fetching data from the API: " + error);
                });
        });

        // Close the autocomplete dropdown when clicking outside of the search box
        document.addEventListener("click", function(e) {
            if (e.target !== searchInput && e.target !== autocompleteItems) {
                autocompleteItems.style.display = "none";
            }
        });

        // Add a click event handler for the map to display lat and lon on click
        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;
            document.getElementById('latlon').textContent = 'Latitude: ' + lat + ', Longitude: ' + lon;

            // Remove the existing marker if it exists
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lon]).addTo(map);
        });

        function geocodeLocation() {
            var locationInput = document.getElementById('search-input').value;
            fetch('https://nominatim.openstreetmap.org/search?format=json&q=' + locationInput)
                .then(response => response.json())
                .then(data => {
                    if (data && data[0]) {
                        var lat = parseFloat(data[0].lat);
                        var lon = parseFloat(data[0].lon);
                        document.getElementById('latlon').textContent = 'Latitude: ' + lat + ', Longitude: ' + lon;

                        // Remove the existing marker if it exists
                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker([lat, lon]).addTo(map);
                        map.setView([lat, lon], 11);
                    } else {
                        alert('Location not found');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</body>
</html>
