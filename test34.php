


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
<script>
        function search() {
            var query = document.getElementById("searchInput").value;
            if (query.trim() !== "") {
                // Perform an AJAX request to fetch search results
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("searchResults").innerHTML = xmlhttp.responseText;
                    }
                };
                xmlhttp.open("GET", "search.php?query=" + query, true);
                xmlhttp.send();
            } else {
                document.getElementById("searchResults").innerHTML = "Please enter a search query.";
            }
        }
    </script>
</head>


<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="#">Happy Diner</a>
                </div>
                <div class="search-bar">
                    <input type="text" id="searchInput" placeholder="Search for names">
    
                </div>
                <button onclick="search()">Search</button>
                
            
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
         
         <a class="btn btn-primary" href="delivery.php" role="button">Order Food</a>
     </div>
     <div class="card">
         <div class="image">
             <img src="Picture/Dining.avif" />
         </div>
         <div class="caption">
                  
         </div>
         
         <a class="btn btn-primary" href="book.php" role="button">Book</a>
     </div>
     <div id="searchResults"></div>     
</main>

</body>
</html>

