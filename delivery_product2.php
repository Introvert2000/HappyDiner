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
$_SESSION['delivery_restaurant']=$restaurantName;
$select_query = mysqli_query($connection, "SELECT * FROM `$restaurantName`");
?>

<div class="restaurant">
    <h2><?php echo $restaurantName; ?></h2>

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
</div>

<!-- Modal for Order Confirmation -->
<div id="orderConfirmationModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeOrderModal">&times;</span>
        <h2>Order Confirmation</h2>
        <div id="orderSummary">
                <!-- Order summary will be displayed here dynamically -->
        </div>
        <p>Are you sure you want to proceed with your order?</p>
        <button id="confirmOrderButton">Confirm Order</button>
    </div>
</div>

<script>
    const cartItems = [];
    let total = 0;
    const proceedToCheckoutButton = document.getElementById("proceed-to-checkout");
        proceedToCheckoutButton.addEventListener("click", function () {
            // Check if the user is logged in
            const isUserLoggedIn = <?php echo empty($_SESSION['Name1']) ? 'false' : 'true'; ?>;
            
            if (isUserLoggedIn) {
                // Redirect to the payment.php page if logged in
                proceedToCheckoutButton.addEventListener("click", openOrderConfirmationModal);

        // Get the order confirmation modal and buttons
        const orderConfirmationModal = document.getElementById("orderConfirmationModal");
        const closeOrderModalButton = document.getElementById("closeOrderModal");
        const confirmOrderButton = document.getElementById("confirmOrderButton");

        function openOrderConfirmationModal() {
            orderConfirmationModal.style.display = "block";
        }

        closeOrderModalButton.addEventListener("click", closeOrderConfirmationModal);
        confirmOrderButton.addEventListener("click", proceedToCheckout);

        function closeOrderConfirmationModal() {
            orderConfirmationModal.style.display = "none";
        }

        function proceedToCheckout() {
            // Redirect to the payment.php page
            const restaurantName = "<?php echo $restaurantName; ?>";
        window.location.href = `payment2.php?restaurantName=${restaurantName}`;
        }

        function openOrderConfirmationModal() {
            // Clear previous order summary
            document.getElementById("orderSummary").innerHTML = "";

            // Populate order summary
            cartItems.forEach(item => {
                const orderSummaryItem = document.createElement("div");
                orderSummaryItem.textContent = `${item.name} - $${item.price}`;
                document.getElementById("orderSummary").appendChild(orderSummaryItem);
            });

            orderConfirmationModal.style.display = "block";
        }
            } else {
                // Display an alert if the user is not logged in
                alert("Please log in before proceeding to checkout.");
            }
        });

    // JavaScript code for cart functionality

    // Add event listeners to all "Order" buttons
    const orderButtons = document.querySelectorAll(".order-button");
    orderButtons.forEach(button => {
        button.addEventListener("click", addToCart);
    });

    // Add event listener for "Proceed to Checkout" button
    // const proceedToCheckoutButton = document.getElementById("proceed-to-checkout");
    

    function addToCart(event) {
        const itemName = event.target.getAttribute("data-name");
        const itemPrice = parseFloat(event.target.getAttribute("data-price"));

        cartItems.push({ name: itemName, price: itemPrice });
        total += itemPrice;

        // Update the cart display
        updateCartDisplay();

        localStorage.setItem("cartItems", JSON.stringify(cartItems));

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

<style>
    /* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.7);
}

.modal-content {
    background-color: #fff;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 50%;
    text-align: center;
}

.close {
    float: right;
    cursor: pointer;
    font-size: 24px;
}

.close:hover {
    color: red;
}

</style>
</body>
</html>
