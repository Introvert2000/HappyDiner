<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "login";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link rel="stylesheet" href="styles.css">

    <style>
        /* Basic CSS for styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .restaurant {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .restaurant img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        h1 {
            color: #333;
        }

        p {
            color: #777;
        }

        /* Styles for the menu */
        .menu-item {
            display: flex;
            align-items: center; /* Vertically align items */
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        /* Style for the Order button */
        .order-button {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }

        /* Style for the item image */
        .item-image {
            max-width: 100px; /* Adjust the width as needed */
            margin-right: 20px; /* Spacing between image and text */
            height: 130px;
            width:130px;
        }
    </style>
</head>
<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="home.php">Happy Diner</a>
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
    
    
<?php

require_once 'connect_rest.php';
$restaurantName = $_GET['restaurantName'];

$select_query = mysqli_query($connection,"SELECT * FROM `$restaurantName`");



?>
   
    <div class="restaurant">
    <h2><?php echo $restaurantName; ?></h2>
     <p>Restaurant Description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, odio ac vehicula mattis, dolor tortor varius lectus, vel fermentum odio mi in dui.</p>
        <p>Location: Restaurant Address, City, Country</p>
        <img src="restaurant-image.jpg" alt="Restaurant Image">

        <h2>Menu</h2>

        
        <?php
        while($row = mysqli_fetch_assoc($select_query)){

    ?>
        <div class="menu-item">
        
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt="Item 1 Image" class="item-image"/>
            <div>
                <h3><?php echo $row["food_item"]; ?></h3>
                
                <p><?php echo $row["price"]; ?></p>
                <button class="order-button" data-name="<?php echo $row["food_item"]; ?>" data-price="<?php echo $row["price"]; ?>">Order</button>
            </div>
        </div>

        <?php
}
     ?>
     <div id="cart">
        <h2>Cart</h2>
        <ul id="cart-items">
            <!-- Cart items will be added here dynamically -->
        </ul>
        <p>Total: $<span id="cart-total">0</span></p>
    </div>
        <!-- Add more menu items as needed -->
    </div>
    <script>
        // JavaScript code for cart functionality
        const cartItems = [];
        let total = 0;

        // Add event listeners to all "Order" buttons
        const orderButtons = document.querySelectorAll(".order-button");
        orderButtons.forEach(button => {
            button.addEventListener("click", addToCart);
        });

        function addToCart(event) {
            const itemName = event.target.getAttribute("data-name");
            const itemPrice = parseFloat(event.target.getAttribute("data-price"));

            cartItems.push({ name: itemName, price: itemPrice });
            total += itemPrice;

            // Update the cart display
            updateCartDisplay();
        }

        function updateCartDisplay() {
            const cartList = document.getElementById("cart-items");
            const cartTotal = document.getElementById("cart-total");

            // Clear existing cart items
            cartList.innerHTML = "";

            // Add updated cart items
            cartItems.forEach(item => {
                const listItem = document.createElement("li");
                listItem.textContent = `${item.name} - $${item.price}`;
                cartList.appendChild(listItem);
            });

            // Update the total
            cartTotal.textContent = total.toFixed(2); // Display total with two decimal places
        }
    </script>
</body>
</html>
