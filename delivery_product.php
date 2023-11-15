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
                <div class="quantity-container">
                    <button class="add-to-cart" data-name="<?php echo $row["food_item"]; ?>" data-price="<?php echo $row["price"]; ?>">+</button>
                    <span class="quantity"></span>
                    <button class="remove-from-cart" data-name="<?php echo $row["food_item"]; ?>">-</button>
                </div>           
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
        <button id="submitOrderButton">Submit Order</button>
    </div>
</div>

<!-- Add this code to your HTML just before the closing </body> tag -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Cart-related functions
  const cartItems = [];
  let total = 0;

  const addButtons = document.querySelectorAll(".add-to-cart");
  const removeButtons = document.querySelectorAll(".remove-from-cart");

  addButtons.forEach(button => {
    button.addEventListener("click", addToCart);
  });

  removeButtons.forEach(button => {
    button.addEventListener("click", removeFromCart);
  });

  function addToCart(event) {
    const itemName = event.target.getAttribute("data-name");
    const itemPrice = parseFloat(event.target.getAttribute("data-price"));

    const cartItem = cartItems.find(item => item.name === itemName);

    if (cartItem) {
      cartItem.quantity += 1;
    } else {
      cartItems.push({ name: itemName, price: itemPrice, quantity: 1 });
    }

    total += itemPrice;
    updateCartDisplay();

    localStorage.setItem("cartItems", JSON.stringify(cartItems));
    updateQuantityDisplay(itemName);
    updateTotalAmountDisplay();
  }

  function removeFromCart(event) {
    const itemName = event.target.getAttribute("data-name");
    const cartItem = cartItems.find(item => item.name === itemName);

    if (cartItem) {
      if (cartItem.quantity > 1) {
        cartItem.quantity -= 1;
      } else {
        const index = cartItems.indexOf(cartItem);
        cartItems.splice(index, 1);
      }

      total -= cartItem.price;
      updateCartDisplay();

      localStorage.setItem("cartItems", JSON.stringify(cartItems));
      updateQuantityDisplay(itemName);
      updateTotalAmountDisplay();
    }
  }

  function updateCartDisplay() {
    const cartList = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");

    cartList.innerHTML = "";
    cartItems.forEach(item => {
      const listItem = document.createElement("li");
      listItem.textContent = `${item.name} x${item.quantity} - $${item.price * item.quantity}`;
      cartList.appendChild(listItem);
    });

    cartTotal.textContent = total.toFixed(2);
    cartTotalOutsideModal.textContent = total.toFixed(2);
  }

  function updateTotalAmountDisplay() {
    cartTotalInsideModal.textContent = total.toFixed(2);
    cartTotalOutsideModal.textContent = total.toFixed(2);
  }

  function updateQuantityDisplay(itemName) {
    const quantitySpan = document.querySelector(`.menu-item[data-name="${itemName}"] .quantity`);
    const cartItem = cartItems.find(item => item.name === itemName);

    quantitySpan.textContent = cartItem ? cartItem.quantity : "0";
  }

  // Modal-related functions
  const proceedToCheckoutButton = document.getElementById("proceed-to-checkout");
  const cartTotalInsideModal = document.getElementById("cart-total-inside-modal");
  const cartTotalOutsideModal = document.getElementById("cart-total-outside-modal");
  const submitOrderButton = document.getElementById("submitOrderButton");

  proceedToCheckoutButton.addEventListener("click", openOrderConfirmationModal);
  submitOrderButton.addEventListener("click", submitOrder);

  function openOrderConfirmationModal() {
    if ("<?php echo isset($_SESSION['Name1']) ? $_SESSION['Name1'] : ''; ?>" === '') {
      alert("Please login first before proceeding to checkout.");
    } else {
      document.getElementById("orderSummary").innerHTML = "";

      cartItems.forEach(item => {
        const orderSummaryItem = document.createElement("div");
        orderSummaryItem.textContent = `${item.name} x${item.quantity} - $${item.price * item.quantity}`;
        document.getElementById("orderSummary").appendChild(orderSummaryItem);
      });

      orderConfirmationModal.style.display = "block";
    }
  }

  function closeOrderConfirmationModal() {
    orderConfirmationModal.style.display = "none";
  }

  function submitOrder() {
    if (cartItems.length > 0) {
      const restaurantName = "<?php echo $restaurantName; ?>";
      const cartQuantity = cartItems.map(item => ({ name: item.name, quantity: item.quantity, price:item.price }));
      
      window.location.href = `payment5.php?restaurantName=${restaurantName}&cartItems=${JSON.stringify(cartQuantity)}`;
    } else {
      alert("Your cart is empty. Please add items to your cart before proceeding.");
    }
    closeOrderConfirmationModal();
  }

//   function submitOrder() {
//     if (cartItems.length > 0) {
//       const restaurantName = "<?php echo $restaurantName; ?>";
//       const cartQuantity = cartItems.map(item => ({ name: item.name, quantity: item.quantity, price: item.price }));
//       // Set session variables before redirecting
//       <?php
//       $_SESSION['restaurantName'] = $restaurantName;
//       $_SESSION['cartQuantity'] = json_encode($cartQuantity);
//       $_SESSION['totalAmount'] = $total;
//       ?>
//       window.location.href = "payment5.php"; // Redirect to the payment page
//     } else {
//       alert("Your cart is empty. Please add items to your cart before proceeding.");
//     }
//   }
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