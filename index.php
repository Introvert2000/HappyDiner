<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
?
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dropdown.css">
    
</head>
<body>
<header>
    <nav>
        <div class="container">
            <div class="logo">
                <a href="#">Happy Diner</a>
            </div>
            <div class="search-bar">
                <form method="get">
                    <input type="text" name="query" placeholder="Search products">
                    <button type="submit" class="search-button">Search</button>
                </form>
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
        
        
        <?php
        // Database configuration
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "login";

        // Create a database connection
        $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if a search query is provided
        if (isset($_GET["query"])) {
            $query = $_GET["query"];
            // Modify your database query to search for products based on the query
            $stmt = $conn->prepare("SELECT * FROM restaurant WHERE restaurant_name LIKE ?");
            $searchQuery = "%" . $query . "%";
            $stmt->bind_param("s", $searchQuery);
            $stmt->execute();
            $result = $stmt->get_result();

           
//displaying search result of index 
            if ($result->num_rows > 0) {
            
                while ($row = $result->fetch_assoc()) {
                    ?>
                   <div class="card">
         <div class="image">
             
             <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />

        
            </div>
         <div class="caption">
        <form method="POST" action="test6.php" >
            <?php 
            $restaurantName=$row['restaurant_name'];
            $_SESSION['restaurant']=$restaurantName;
            ?>
        <p class="product_name"><?php echo $restaurantName; ?></p>
            <!-- <p class="product_name". ><?php echo $row["restaurant_name"]; ?></p>  -->
            
            <!-- <input type="submit" id="Submit" name="Submit" value="Book" class="btn btn-success" /> -->
            <button  type="button" onclick="displaySelectedOptionOrder(`<?php echo $restaurantName; ?>`)">Order</button>
            <button    type="button" onclick="displaySelectedOptionBook(`<?php echo $restaurantName; ?>`)">Book</button>
    
    
    
    <script>
        function displaySelectedOptionOrder(restaurantName) {
            window.location.href = `delivery_product.php?restaurantName=${restaurantName}`;
        }
        function displaySelectedOptionBook(restaurantName) {
            window.location.href = `book_table.php?restaurantName=${restaurantName}`;
        }
    </script>
</div>
         

         </form>

     </div>
                <?php
                
                }
               
            } else {
                echo "No results found for: " . htmlspecialchars($query);
            }
        } else {
            // If no search query is provided, display the general product list
            $stmt = $conn->prepare("SELECT * FROM restaurant");
            $stmt->execute();
            $result = $stmt->get_result();

           

            if ($result->num_rows > 0) {
                echo '
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
            </div>';
            } else {
                echo "No products found in the database.";
            }
        }

        // Close the database connection
        $conn->close();
        ?>
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
