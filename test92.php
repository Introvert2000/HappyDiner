<?php
                session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dropdown.css">
    <style>
        .nav-links a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-size: 1.2em;
}

.nav-links a:hover {
    border-bottom: 2px solid white;
}

    </style>
</head>







<body>
<header>
    <nav>
        <div class="container">
            <div class="logo">
                <a href="#">Happy Diner</a>
            </div>

            <div class="nav-links">
            <?php
if (isset($_SESSION['Name1']) && !empty($_SESSION['Name1'])) {
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "login";

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    $userId = $_SESSION['Name1']; // Assuming UserID is the user ID column in your users table
    $query = "SELECT location ,District FROM reg WHERE Name1 = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($userLocation , $district);
    $stmt->fetch();
    $stmt->close();

    $_SESSION['citylocation'] = $district ;
    ?>
    <div class="nav-links" id="locationLink">
        <?php if (!empty($userLocation)) { ?>
            <a href='search-location.php'><?php echo $userLocation; ?></a>
        <?php } else { ?>
            <a href='addlocation.php'>Add Location</a>
        <?php } ?>
    </div>

    <script>
        // Assuming you have jQuery included in your project
        $(document).ready(function () {
            // You can use AJAX to dynamically update the link without refreshing the page
            $.ajax({
                url: 'update_location_link.php', // Create a PHP file to handle the update
                type: 'POST',
                success: function (data) {
                    $('#locationLink').html(data); // Update the link based on the response from the server
                }
            });
        });
    </script>
<?php
}
?>


            </div>


            <div class="search-bar">
                <form action='search3.php' method="POST">
                    <input  type="text" name="query" placeholder="Search products">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>
            <div class="menu">
                <?php
                if (empty($_SESSION['Name1'])) {
                ?>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                <?php } else { ?>
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
                <?php } ?>
            </div>
        </div>
    </nav>
</header>

    <main>
        <!-- Add a search form -->
        
        
           

          
                <div class="card">
                <div class="image">
                    <img src="Picture/Order_Food.avif" />
                </div>
                <div class="caption">
                    <!-- Add any relevant content for this card -->
                </div>
                <button class="order-button" id="get-location-order">Order</button>
            </div>
            <div class="card">
                <div class="image">
                    <img src="Picture/Dining.avif" />
                </div>
                <div class="caption">
                    <!-- Add any relevant content for this card -->
                </div>
                <button class="book-button" id="get-location-book">Book</button>
            </div>
    </main>

    <script>
    document.getElementById("get-location-book").onclick = function(){
    
    window.location.href = `book.php`
    } 


    document.getElementById("get-location-order").onclick = function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(gotLocation_order, failed);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    };

   

    function gotLocation_order(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;

        // Pass latitude and longitude to the Geoapify API
        fetch(`https://api.geoapify.com/v1/geocode/reverse?lat=${latitude}&lon=${longitude}&apiKey=6280fa3f1f5e4b7ca8931c01979b1e88`)
            .then(response => response.json())
            .then(data => {
                if (data.features && data.features.length > 0) {
                    const county = data.features[0].properties.county;
                    
                    // Redirect to the next PHP page with the city as a query parameter
                    window.location.href = `delivery.php?city=${county}`;
                } else {
                    alert("City not found");
                }
            })
            .catch(error => {
                console.error("Error fetching data from the API:", error);
                alert("Error fetching data from the API");
            });
    }

    function failed() {
        alert("Error getting location");
    }

</script>
</body>
</html>