<?php

require_once 'connection.php';



    $select_query = mysqli_query($connection,"SELECT * FROM restaurant ");


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link rel="stylesheet" href="font.css">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <link rel="stylesheet" href="book.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
</head>


<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Happy Diner</a>
                </div>
                
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
                        <div class="dropdown">
                                <ul>
                                    <li id="username"><a>
                                        <?php if (!empty($_SESSION['Name1'])) {
                                            echo $_SESSION['Name1'];
                                        } ?>
                                    </a></li>
                                </ul>
                         button class="dropdown-button">&#9660;</button>
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
            $_SESSION['restaurant']=$restaurantName;
            ?>
                <div>
                   <p class="product_name"><?php echo $restaurantName; ?></p>
                </div>
            
            <button type="button" id="button_colour" onclick="displaySelectedOption(`<?php echo $restaurantName; ?>`)">Book</button>
   
            <script>
                    function displaySelectedOption(restaurantName) {
                        window.location.href = `book_table.php?restaurantName=${restaurantName}`;
                    }
            </script>
        </div>
    </div>
    
     <?php
}
     ?>
</main>

</body>
</html>

