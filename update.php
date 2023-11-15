<!DOCTYPE html>
<html>
<head>
    <title>Restaurant Registration</title>
    <link rel="stylesheet" href="restaurant_reg.css">

    <link rel="stylesheet" href="autocomplete.css">
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
    <h1>Add Location</h1>
    <div class="registration-form">
        <form method="post" action="process_location2.php" enctype="multipart/form-data">
            

            
            <div class="form-group">
                <label class="form-label" for="name">Address Line:</label>
                <input type="text" id="name" name="address" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="name">District:</label>
                <input type="text" id="name" name="District" required>
            </div>

            <div id="map" style="width: 50%; height: 50vh"></div>
            <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
            
            <input type="text" name="location" id="search-input" placeholder="Enter a location">
            <input type="hidden" name="latitude" id="latitude" value="">
            <input type="hidden" name="longitude" id="longitude" value="">
            <!-- </form> -->
            <div id="autocomplete-items"></div>
            <div id="latlon"></div>

            <script src="location.js"></script>

            <button class="submit-button" type="submit" name = "submit">Save Location</button>
        </form>
    </div>
    <script src="autocomplete.js"></script>
</body>
</html>


