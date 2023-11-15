<?php
session_start();
require_once 'connection.php';
$city = $_GET['city'];

if(empty($_SESSION['citylocation'])){
    $select_query = mysqli_query($connection,"SELECT * FROM restaurant WHERE city = '{$city}' AND status = 'Approved'");
    
}
else{
    $select_query = mysqli_query($connection, "SELECT * FROM restaurant WHERE city = '{$_SESSION['citylocation']}' AND status = 'Approved' ");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="book.css">
    <link rel="stylesheet" href="dropdown.css">


    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
<style>
    header {

background-color: #333;
color: #fff;
}
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
.logo a {
    text-decoration: none;
    color: #bb732b;
    font-size: 24px;
    font-weight: bold;
}
.logo{
    height: 100px;
}

.search-button {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    padding: 10px 20px;
    font-weight: bold;
}

/* Hover effect for the search button */
.search-button:hover {
    background-color: #0056b3;
}
</style>
</head>


<body>
<header>
        <nav>
            <div class="container">
            <div >
            <a href="index.php"> <img src="Picture\logo.png" alt="" class="logo"></a>
            </div>
            <div class="search-bar">
                <form action='search3.php' method="POST">
                    <input  type="text" name="query" placeholder="Search products">
                    <button type="submit" class="search-button">Search</button>
                </form>
            </div>            
                <div class="menu">
                   <?php
                   
                   if(empty($_SESSION['Name1']))
                   {
                   
                   ?>
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                    <?php }
                    else {?>
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
                <?php }
                    ?>
                </div>
            </div>
        </nav>
</header>
<main>
     <?php
        while($row = mysqli_fetch_assoc($select_query)){

    ?>
     <div class="card">
            <div class="image">
             
             <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />

        
            </div>
        <div class="caption">
           
                <?php 
                $restaurantName=$row['restaurant_name'];
                $rating = $row['restauant_rating'];
                $price = $row['recommen_price'];
                $_SESSION['restaurant']=$restaurantName;
                ?>

            <div>
                   <p class="product_name"><?php echo $restaurantName; ?></p>
                </div>
                <div class="mainart">
                <p class="price">₹<?php echo $price; ?></p>
                <div class="revi">
                <p class="price"><?php echo $rating?></p>
                <img class="star" src="star-svgrepo-com.svg" alt="">
                </div>
                </div>
            <button type="button" id="button_colour" onclick="displaySelectedOption(`<?php echo $restaurantName; ?>`)">Order</button>
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
     ?>
</main>

</body>
</html>