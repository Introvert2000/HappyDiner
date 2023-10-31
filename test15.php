<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="font.css">
    <link rel="stylesheet" href="styles.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
<style>
    .custom-button {
  display: inline-block;
  padding: 10px 20px;
  background-color: #007bff; /* Button background color */
  color: #fff; /* Button text color */
  border: none; /* Remove default border */
  border-radius: 5px; /* Add rounded corners */
  cursor: pointer; /* Change cursor on hover to indicate interactivity */
  text-align: center; /* Center text horizontally */
  text-decoration: none; /* Remove underlines for <a> elements */
}

.custom-button:hover {
  background-color: #0056b3; /* Change background color on hover */
}

.custom-button:active {
  background-color: #00479e; /* Change background color when clicked */
}
/* Basic button styles */
.btn {
  display: inline-block;
  padding: 10px 20px; /* Adjust padding as needed */
  background-color: #007bff; /* Change the background color to your desired color */
  color: #fff; /* Text color */
  text-decoration: none; /* Remove underline */
  border: none; /* Remove border */
  border-radius: 4px; /* Rounded corners */
  cursor: pointer;
  font-weight: bold;
}

/* Hover effect */
.btn:hover {
  background-color: #0056b3; /* Change the background color on hover */
}
.username{

}

/* Style for the search button */
.search-button {
    background-color: #007bff; /* Button background color */
    color: #fff; /* Button text color */
    border: none; /* Remove default button border */
    border-radius: 4px; /* Add rounded corners */
    cursor: pointer; /* Change cursor on hover to indicate interactivity */
    padding: 5px 10px; /* Adjust padding as needed */
    font-weight: bold; /* Make the text bold */
    transition: background-color 0.3s; /* Add a smooth transition effect */
}

/* Hover effect for the search button */
.search-button:hover {
    background-color: #0056b3; /* Change background color on hover */
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
            <div class="search-bar">
                    <form method="get">
                        <input type="text" name="query" placeholder="Search products">
                        <button type="submit">Search</button>
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
                    <ul>
                        <li id="username"><a>
                            <?php if (!empty($_SESSION['Name1'])) {
                                echo $_SESSION['Name1'];
                            } ?>
                            </a></li>
                    </ul>
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
            <button type="button" onclick="displaySelectedOption(`<?php echo $restaurantName; ?>`)">Book</button>
    <script>
        function displaySelectedOption(restaurantName) {
            window.location.href = `delivery_product.php?restaurantName=${restaurantName}`;
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
                <button id="get-location-order">Order</button>
            </div>
            <div class="card">
                <div class="image">
                    <img src="Picture/Dining.avif" />
                </div>
                <div class="caption">
                    <!-- Add any relevant content for this card -->
                </div>
                <button id="get-location-book">Book</button>
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
