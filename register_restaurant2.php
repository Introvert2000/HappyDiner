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
    <h1>Restaurant Registration</h1>
    <div class="registration-form">
        <form method="POST" action="restaurant_reg_form.php" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label" for="name">Restaurant_Name:</label>
                <input type="text" id="name" name="restaurant_name" required>
            </div>
            

            <div class="form-group">
                <label class="form-label" for="name">Owner Name:</label>
                <input type="text" id="name" name="owner_name" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="name">Email:</label>
                <input type="text" id="name" name="owner_email" required>
            </div>
            <!-- <div class="autocomplete" id="autocomplete">
                <label class="form-label" for="name">Address:</label>
            <input type="text" id="search-input" >
            <div class="autocomplete-items" id="autocomplete-items"></div>
            </div> -->

            <div id="map" style="width: 50%; height: 50vh"></div>
            <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"></script>
            <!-- <form method="post" action="process_location.php"> -->
            <input type="text" name="location" id="search-input" placeholder="Enter a location">
            <input type="hidden" name="latitude" id="latitude" value="">
            <input type="hidden" name="longitude" id="longitude" value="">
            <!-- </form> -->
            <div id="autocomplete-items"></div>
            <div id="latlon"></div>
            <script src="location.js"></script>

            <button class="submit-button" type="submit">Register</button>
        </form>
    </div>
    <script src="autocomplete.js"></script>
</body>
</html>
