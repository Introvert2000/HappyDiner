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

        /* Styles for the modal */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto; /* 10% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 5px;
        }

        .close {
            color: #888;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
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
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                   
                </div>
                <input type="submit" name="submit" value="Search">

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

        <!-- Add more menu items as needed -->
        <button id="openCartModal">Proceed to payment</button>
    </div>

    <!-- The Cart Modal -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeCartModal">&times;</span>
            <h2>Your Cart</h2>
            <ul id="cart-items-modal">
                <!-- Cart items will be added here dynamically -->
            </ul>
            <p>Total: $<span id="cart-total-modal">0</span></p>
            <button id="proceedToPayment">Proceed to Payment</button>
        </div>
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

        // Check if the item is already in the cart
        const existingItem = cartItems.find(item => item.name === itemName);
        if (existingItem) {
            existingItem.quantity++; // Increment quantity
        } else {
            cartItems.push({ name: itemName, price: itemPrice, quantity: 1 });
        }

        total += itemPrice;

        // Update the cart display
        updateCartDisplay();
    }

    function updateCartDisplay() {
        const cartListModal = document.getElementById("cart-items-modal");
        const cartTotalModal = document.getElementById("cart-total-modal");
        const cartQuantity = document.getElementById("cart-quantity");

        // Clear existing cart items in the modal
        cartListModal.innerHTML = "";

        // Add updated cart items to the modal
        cartItems.forEach(item => {
            const listItem = document.createElement("li");
            listItem.innerHTML = `
                ${item.name} - $${item.price} x ${item.quantity} 
                <button class="remove-button" data-name="${item.name}">Remove</button>
            `;
            cartListModal.appendChild(listItem);
        });

        // Update the total in the modal
        cartTotalModal.textContent = total.toFixed(2); // Display total with two decimal places

        // Update the cart quantity display
        cartQuantity.textContent = cartItems.length;
    }

    const openCartModalButton = document.getElementById("openCartModal");
    const closeCartModalButton = document.getElementById("closeCartModal");
    const cartModal = document.getElementById("cartModal");
    const proceedToPaymentButton = document.getElementById("proceedToPayment");

    openCartModalButton.addEventListener("click", () => {
        // Display the cart modal
        cartModal.style.display = "block";

        // Populate the cart modal with cart items
        updateCartDisplay();
    });

    closeCartModalButton.addEventListener("click", () => {
        // Close the cart modal
        cartModal.style.display = "none";
    });

    // Remove an item from the cart
    cartModal.addEventListener("click", (event) => {
        if (event.target.classList.contains("remove-button")) {
            const itemName = event.target.getAttribute("data-name");
            const removedItem = cartItems.find(item => item.name === itemName);

            if (removedItem) {
                total -= removedItem.price * removedItem.quantity;
                cartItems.splice(cartItems.indexOf(removedItem), 1);
                updateCartDisplay();
            }
        }
    });

    // Proceed to payment page when the "Proceed to Payment" button is clicked
    proceedToPaymentButton.addEventListener("click", () => {
        // You can add logic to redirect the user to the payment page
        // For example, window.location.href = "payment.php";
    });

    // Close the cart modal when the user clicks anywhere outside the modal
    window.addEventListener("click", (event) => {
        if (event.target === cartModal) {
            cartModal.style.display = "none";
        }
    });
    </script>
</body>
</html>
