<?php
session_start();
?>

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
}/* CSS for the lightbox container */
.lightbox {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 999;
    text-align: center;
}

.lightbox-content {
    position: relative;
    margin: 10% auto;
    width: 80%;
    max-width: 800px;
}

.lightbox-image {
    max-width: 100%;
    max-height: 80vh;
}

.lightbox-close {
    position: absolute;
    top: 0;
    right: 0;
    font-size: 2em;
    cursor: pointer;
    color: white;
    padding: 10px 20px;
}

/* CSS for the image container */
.image-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
    gap: 10px;
    margin-top: 20px;
}

.preload-image {
    cursor: pointer;
    max-width: 100%;
    height: auto;
    border: 3px solid white;
    transition: transform 0.2s;
}

.preload-image:hover {
    transform: scale(1.05);
}

.loading-overlay {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.7);
    z-index: 999;
    color: white;
    font-size: 2em;
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
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$name2 = $_SESSION['Name1'];

$query = "SELECT * FROM reg WHERE Name1='$name2'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $Name = $row["Name1"];
    $ownerEmail = $row["email"];
    $mobileNumber = $row["MobileNo"];
}

?>

<form id="reservationForm" action="process_reservation.php" method="post">
    <input type="hidden" name="restaurantName" value="<?php echo $restaurantName; ?>">
    <input type="hidden" name="name" value="<?php echo $Name; ?>">
    <input type="hidden" name="email" value="<?php echo $ownerEmail; ?>">
    <input type="hidden" name="phone" value="<?php echo $mobileNumber; ?>">

    
<div class="section-2">
    <p>Table reservation</p>
    <div>
        <label for="reservationDate">Select Date: </label>
        <input type="date" name="date" id="reservationDate" min="<?php echo date('Y-m-d'); ?>">
    </div>

    <div>
        <label for="guestCount">Number of Guests: </label>
        <select id="guestCount"  name="guests">
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
        <div class="time-buttons">
        <button id="customTimeButton" type="button" onclick="showCustomTimeInput()">Select Time</button>
        </div>
        <input type="time"  name="time" id="customTimeInput" style="display: none;">
    </div>

    <script>
        function showCustomTimeInput() {
            const customTimeInput = document.getElementById('customTimeInput');
            customTimeInput.style.display = 'block';
        }
    </script>



        <h1>Menu</h1>
        <div class="image-container">
            <!-- Loading overlay -->
            <div class="loading-overlay" id="loading-overlay">
            </div>
            <?php
            // Database connection code
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "pictures";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch images from the database
            $sql = "SELECT * FROM `$restaurantName`";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Display each image with a data-image attribute
                    echo '<img class="preload-image" src="data:image/jpeg;base64,' . base64_encode($row['menu_images']) . '" alt="Image" data-image="' . base64_encode($row['menu_images']) . '">';
                }
            } else {
                echo "No images found.";
            }

            $conn->close();
            ?>
        </div>

<!-- Lightbox container -->
        <div class="lightbox" id="lightbox">
            <div class="lightbox-content">
                <span class="lightbox-close" id="lightbox-close">&times;</span>
                <img src="" alt="Large Image" class="lightbox-image" id="lightbox-image">
            </div>
        </div>

        <script>
            // JavaScript to handle lightbox functionality
            const preloadImages = document.querySelectorAll('.preload-image');
            const loadingOverlay = document.getElementById('loading-overlay');
            const lightbox = document.getElementById('lightbox');
            const lightboxImage = document.getElementById('lightbox-image');
            const lightboxClose = document.getElementById('lightbox-close');

            // Function to open the lightbox
            function openLightbox(imageData) {
                lightboxImage.src = 'data:image/jpeg;base64,' + imageData;
                lightbox.style.display = 'block';
            }

            // Function to close the lightbox
            function closeLightbox() {
                lightbox.style.display = 'none';
            }

            // Attach click event handlers to the images
            preloadImages.forEach(image => {
                image.addEventListener('click', function () {
                    const imageData = this.getAttribute('data-image');
                    openLightbox(imageData);
                });
            });

            // Close the lightbox when the close button is clicked
            lightboxClose.addEventListener('click', closeLightbox);

            // Check images loaded when the page is fully loaded
            window.addEventListener('load', checkImagesLoaded);

            // Check images loaded when each image loads
            preloadImages.forEach(image => {
                image.addEventListener('load', checkImagesLoaded);
            });

            // Function to check if all images are loaded
            function checkImagesLoaded() {
                const imagesLoaded = Array.from(preloadImages).filter(image => image.complete);
                if (imagesLoaded.length === preloadImages.length) {
                    // All images are loaded, hide the loading overlay
                    loadingOverlay.style.display = 'none';
                }
            }
        </script>

    <!-- <script>
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



    </script> -->

    <button id="bookButton" type="button" onclick="bookTable()">Book</button>

</div>
</form>

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

<script>
function bookTable() {
    // Check if the user is logged in (you can use a variable like 'loggedIn' to track this)
    // If the user is not logged in, display an alert
    <?php if (empty($_SESSION['Name1'])) : ?>
        alert("Please log in to make a reservation.");
    <?php else : ?>
        // If the user is logged in, you can perform other actions or submit the form.
        // For example, you can submit the form using JavaScript.
        // Replace 'reservationForm' with the ID of your form.
        document.getElementById('reservationForm').submit();
    <?php endif; ?>
}
</script>






