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
    <div id="map" style="width: 50%; height: 50vh"></div>
    <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
    <form method="post" action="process_location.php">
        <input type="text" name="location" id="search-input" placeholder="Enter a location">
        <input type="hidden" name="latitude" id="latitude" value="">
        <input type="hidden" name="longitude" id="longitude" value="">
        <button type="submit" name="submit">Submit to Database</button>
    </form>
    <div id="autocomplete-items"></div>
    <div id="latlon">Latitude: N/A, Longitude: N/A</div>
    <script src="location.js"></script>
</body>
</html>
