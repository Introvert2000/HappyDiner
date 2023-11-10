<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>

    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dropdown.css">
    
</head>
<header>
    <nav>
        <div class="container">
            <div class="logo">
                <a href="#">Happy Diner</a>
            </div>
            <div class="search-bar">
                <form action='search3.php' method="POST">
                    <input  type="text" name="query" placeholder="Search products">
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
<body>
<div class="space" >
    <h1>Happy Diner</h1>
             <!-- <img class="img-des" src="main.jpeg" > -->
        </div>
    <main>
        
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
<div class="abt" >
<h1>About us</h1>
    <p class="tag" >Lorem, ipsum dolor sit amet consectetur adipisicing elit. Nemo, perspiciatis! A assumenda dicta harum quasi dolorem praesentium minus, tempora ipsa quo consequuntur quibusdam nam culpa placeat? Odio obcaecati dolor recusandae!</p>
</div>
</body>
<footer class="food-footer">
        <div class="container">
            <div class="footer-contact">
                <h3>Contact Us</h3>
                <p>For Reservations and Inquiries:</p>
                <ul>
                    <li><a href="tel:+1234567890">Phone: +91 9370568242</a></li>
                    <li><a href="tel:+9876543210">Phone: +9 (876) 543-210</a></li>
                </ul>
            </div>
            <div class="footer-review">
                <h3>Customer Reviews</h3>
                <p>Have you dined with us? Share your experience and read what others have to say.</p>
                <a class="btn-review" href="add_review.php" >Write a Review</a>
                <a class="btn-review" href="reviews.php" >View Reviews</a>
            </div>
        </div>
    </footer>
</html>