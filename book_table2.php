<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Table Booking</title>
    <link rel="stylesheet" href="book_table.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-Rf8PMTZiP7Q9fSAnjYDEExSLFWS13mpOv3JWea1ylpdiBtBqgF5tDDzwe5f5f5Cym" crossorigin="anonymous">

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <style>
        /* Set the map container's size */
        #map {
            height: 400px;
            width: 100%; /* Adjust width to take the full available width */
        }
    </style>
    <style>
        .section-container {
            display: flex;
        }

        .section-1 {
    flex: 3;
    background-color: #007BFF;
    color: #fff;
    padding: 20px;
}

.restaurant-info {
    display: flex;
    align-items: center;
}

.restaurant-image {
    flex: 1;
    margin-right: 20px;
}

.restaurant-image img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.restaurant-details {
    flex: 2;
}

.restaurant-details h2 {
    font-size: 24px;
    margin: 0;
}

.restaurant-details p {
    font-size: 16px;
    margin: 8px 0;
}


.section-2 {
    flex: 2;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.time-selection-container {
    margin-top: 20px;
}

.time-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 10px;
}

/* Customize the guest count dropdown */
#guestCount {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    width: 100px; /* Adjust the width as needed */
}

/* Style the date selection input */
#reservationDate {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    width: 150px; /* Adjust the width as needed */
}

/* Remove the browser's default date input arrow button */
#reservationDate::-webkit-inner-spin-button,
#reservationDate::-webkit-calendar-picker-indicator {
    display: none;
}

.time-buttons button {
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.time-buttons button:hover {
    background-color: #0056b3;
}

#customTimeButton {
    background-color: #007BFF;
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 10px 15px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-right: 10px;
}

#customTimeButton:hover {
    background-color: #0056b3;
}

#customTimeInput {
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    margin-right: 10px;
}

#customTimeInput:focus {
    border-color: #007BFF;
    outline: none;
}

    </style>
</head>
<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="./index.php">Happy Diner</a>
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
                    <?php } else {
                        ?>
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
                    <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
</header>
    <main>
        
        <div class="section-container"> <!-- Add this div to contain both sections -->
        <div class="section-1">
            <div class="restaurant-det">
            <?php
    $restaurantName = $_GET['restaurantName'];
    ?>

        <?php
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

            $sql = "SELECT * FROM restaurant WHERE restaurant_name = ?";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $restaurantName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='restaurant-info'>";
                    echo "<div class='restaurant-image'>";
                    echo "<img src='data:image/jpg;charset=utf8;base64," . base64_encode($row['image']) . "' />";
                    echo "</div>";
                    echo "<div class='restaurant-details'>";
                    echo "<h2>{$restaurantName}</h2>";
                    echo "<p>Address: " . $row["city"] . "</p>";
                    echo "<p>Email: " . $row["owner_email"] . "</p>";
                    echo "<p>Cost for 2: " . $row["recommen_price"] . "</p>";
                    echo "<p>" . $row["restauant_rating"] . "/5</p>";
                    echo "<p>Cuisine: " . $row["cuisine"] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "0 results";
            }

            $stmt->close();
        ?>

</div>
<?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "login";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT latitude, longitude FROM restaurant WHERE restaurant_name='$restaurantName'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $latitude = $row["latitude"];
            $longitude = $row["longitude"];
        }
        ?>
<div class="map" id="map">

<script>

var map = L.map("map").setView([<?php echo $latitude; ?>, <?php echo $longitude; ?>], 12);

        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
            maxZoom: 19,
        }).addTo(map);

        L.marker([<?php echo $latitude; ?>, <?php echo $longitude; ?>]).addTo(map);

        var userMarkerIcon = L.divIcon({
            className: "user-marker",
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            html: '<div class="user-marker-icon"></div>',
        });

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var userLatitude = position.coords.latitude;
                var userLongitude = position.coords.longitude;
                L.marker([userLatitude, userLongitude], {
                    icon: userMarkerIcon
                }).addTo(map);
            });
        }

        // Define waypoints here if needed
        var waypoints = [
            [15.4965743, 73.8254905],
            [15.5403071, 73.8455048]
        ];

        L.Routing.control({
            waypoints: waypoints,
            routeWhileDragging: true,
            geocoder: L.Control.Geocoder.nominatim(),
        }).addTo(map);

</script>
</div>
    
</div>


<div class="section-2">
    <p>Table reservation</p>
    <div>
        <label for="reservationDate">Select Date: </label>
        <input type="date" id="reservationDate" min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div>
        <label for="guestCount">Number of Guests: </label>
        <select id="guestCount">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
        </select>
    </div>

    <div class="time-selection-container">
        <div class="time-buttons"></div>
        <button id="customTimeButton" onclick="showCustomTimeInput()">+</button>
        <input type="time" id="customTimeInput" style="display: none;">
        <script>
    // Get the current date and format it as YYYY-MM-DD
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;

    // Set the default value for the date input
    document.getElementById('reservationDate').value = currentDate;
</script>

    </div>

    <script>
        // Get the current time
const now = new Date();
const currentHour = now.getHours();
const currentMinute = now.getMinutes();

// Calculate the next 4 hours
const timeButtons = document.querySelector('.time-buttons');
for (let i = 0; i <= 4; i++) {
    const nextHour = new Date(now);
    nextHour.setHours(currentHour + i, currentMinute);
    const formattedTime = padZero(nextHour.getHours()) + ':' + padZero(nextHour.getMinutes());
    const button = document.createElement('button');
    button.textContent = formattedTime;
    button.addEventListener('click', () => selectTime(formattedTime));
    timeButtons.appendChild(button);
}

        // JavaScript code to handle button clicks
        document.getElementById("selectDateButton").addEventListener("click", function() {
            const selectedDate = document.getElementById("reservationDate").value;
            alert("Selected Date: " + selectedDate);
        });

        document.getElementById("selectGuestCountButton").addEventListener("click", function() {
            const selectedGuestCount = document.getElementById("guestCount").value;
            alert("Selected Guest Count: " + selectedGuestCount);
        });

        // Function to add leading zero for single-digit numbers
        function padZero(number) {
            return (number < 10 ? '0' : '') + number;
        }

        // Get the current time
        const now = new Date();

        // Calculate the next 4 hours
        const timeButtons = document.querySelector('.time-buttons');
        for (let i = 1; i <= 4; i++) {
            const nextHour = new Date(now);
            nextHour.setHours(now.getHours() + i);
            const formattedTime = padZero(nextHour.getHours()) + ':' + padZero(nextHour.getMinutes());
            const button = document.createElement('button');
            button.textContent = formattedTime;
            button.addEventListener('click', () => selectTime(formattedTime));
            timeButtons.appendChild(button);
        }

        function selectTime(time) {
            // Handle the selected time, e.g., display it or store it in a variable
            alert('Selected time: ' + time);
        }

        function showCustomTimeInput() {
            const customTimeInput = document.getElementById('customTimeInput');
            customTimeInput.style.display = 'block';
        }
    </script>
</div>
I'v
</body>
</html>
                
            </div>
        </div>
        <!-- Rest of your main content -->
    </main>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> <?php echo $restaurantName; ?></p>
    </footer>
</body>
</html>
