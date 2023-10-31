<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "login";
$connection = mysqli_connect("$server", "$username", "$password");
$select_db = mysqli_select_db($connection, $database);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your stylesheet -->
    <link rel="stylesheet" href="delivery_product.css">
    <link rel="stylesheet" href="dropdown.css">
    
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
                        <button class="dropdown-button">&#9660;</button>
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

<?php
require_once 'connect_rest.php';
$restaurantName = $_GET['restaurantName'];
$select_query = mysqli_query($connection, "SELECT * FROM `$restaurantName`");
?>

<div class="restaurant">
    <h2><?php echo $restaurantName; ?></h2>
    <!-- <p>Restaurant Description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam auctor, odio ac vehicula mattis, dolor tortor varius lectus, vel fermentum odio mi in dui.</p>
    <p>Location: Restaurant Address, City, Country</p> -->
    <!-- <img src="restaurant-image.jpg" alt="Restaurant Image"> -->

    <h2>Menu</h2>

    <?php
    while ($row = mysqli_fetch_assoc($select_query)) {
    ?>
        <div class="menu-item">
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" alt="Item 1 Image" class="item-image" />
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
        <button id="proceed-to-checkout">Proceed to Checkout</button>
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

    // Add event listener for "Proceed to Checkout" button
    const proceedToCheckoutButton = document.getElementById("proceed-to-checkout");
    proceedToCheckoutButton.addEventListener("click", proceedToCheckout);

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

    function proceedToCheckout() {
        // Redirect to the payment.php page
        window.location.href = 'payment.php';
    }
</script>
</body>
</html>
