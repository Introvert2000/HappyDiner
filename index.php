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
                    <form method="post" action="display.php"><input type="text" placeholder="Search..." name= "search">
                </div>
                <input type="submit" name="submit">
            </form>
                <div class="menu">
                   <?php
                   session_start();
                   if(empty($_SESSION['Name1']))
                   {
                   
                   ?>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                    <?php }
                    else{
                        ?>

                        <ul>
                        <li id="username"> <a><?php if(!empty($_SESSION['Name1'])){ echo $_SESSION['Name1']; }?></a> </li>
                        </ul>
                        
                        <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
<main>
    
     <div class="card">
         <div class="image">
             <img src="Picture/Order_Food.avif" />
         </div>
         <div class="caption">
                  
         </div>
         
         <!-- <a class="btn btn-primary" href="delivery.php" id="get-location" role="button">Order Food</a> -->
         <button id= "get-location-order">Order</button>

     </div>
     <div class="card">
         <div class="image">
             <img src="Picture/Dining.avif" />
         </div>
         <div class="caption">
                  
         </div>
         
         <!-- <a class="btn btn-primary" href="book.php" id="get-location" role="button">Book</a> -->
         <button id= "get-location-book">Book</button>
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

