
        var map = L.map('map').setView([15.286691, 73.969780], 10);
        mapLink = "<a href='http://openstreetmap.org'>OpenStreetMap</a>";
        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', { attribution: 'Leaflet &copy; ' + mapLink + ', contribution', maxZoom: 18 }).addTo(map);

        var marker;

        // Event listener for input changes
        var searchInput = document.getElementById("search-input");
        var autocompleteItems = document.getElementById("autocomplete-items");
        var latitudeInput = document.getElementById("latitude");
        var longitudeInput = document.getElementById("longitude");

        // Function to set latitude and longitude and show the marker
        function setLatLngAndMarker(lat, lon) {
            var lat = parseFloat(lat);
            var lon = parseFloat(lon);
            document.getElementById('latlon').textContent = 'Latitude: ' + lat + ', Longitude: ' + lon;

            latitudeInput.value = lat;
            longitudeInput.value = lon;

            // Remove the existing marker if it exists
            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lon]).addTo(map);
        }

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
                            const street = feature.properties.street;
                            const suburb = feature.properties.suburb;
                            const county = feature.properties.county;
                            const city = feature.properties.city;
                            const postcode = feature.properties.postcode;
                            const state = feature.properties.state;

                            if (street !== undefined || suburb !== undefined || county !== undefined || city !== undefined || postcode !== undefined || state !== undefined) {
                                const itemElement = document.createElement("div");
                                itemElement.classList.add("autocomplete-item");
                                let suggestion = "";

                                if (street) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${street}`;
                                }

                                if (suburb) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${suburb}`;
                                }

                                if (city) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${city}`;
                                }
                                if (postcode) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${postcode}`;
                                }
                                if (state) {
                                    if (suggestion) {
                                        suggestion += `, `;
                                    }
                                    suggestion += ` ${state}`;
                                }

                                // Set data attributes for latitude and longitude
                                itemElement.setAttribute("data-lat", feature.geometry.coordinates[1]);
                                itemElement.setAttribute("data-lon", feature.geometry.coordinates[0]);

                                itemElement.textContent = suggestion;
                                itemElement.addEventListener("click", function() {
                                    searchInput.value = suggestion;
                                    autocompleteItems.style.display = "none";

                                    // Extract the latitude and longitude from data attributes
                                    const selectedLat = this.getAttribute("data-lat");
                                    const selectedLon = this.getAttribute("data-lon");

                                    // Call the function to set latitude, longitude, and show the marker
                                    setLatLngAndMarker(selectedLat, selectedLon);
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

        document.addEventListener("click", function(e) {
            if (e.target !== searchInput && e.target !== autocompleteItems) {
                autocompleteItems.style.display = "none";
            }
        });

        map.on('click', function(e) {
            var lat = e.latlng.lat;
            var lon = e.latlng.lng;
            document.getElementById('latlon').textContent = 'Latitude: ' + lat + ', Longitude: ' + lon;

            latitudeInput.value = lat;
            longitudeInput.value = lon;

            if (marker) {
                map.removeLayer(marker);
            }

            marker = L.marker([lat, lon]).addTo(map);
        });
