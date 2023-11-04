<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your meta tags and title here -->
</head>
<body>
    <!-- Header and other content -->

    <main>
        <div class="container">
            <h1>Payment Details</h1>
            
            <!-- Order Summary -->
            <h2>Order Summary</h2>
            <table>
                <tr>
                    <th>Item</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <!-- JavaScript will dynamically add rows here -->
            </table>

            <!-- Display the total amount -->
            <p>Total Amount: $<span id="totalAmountDisplay">0.00</span></p>
            <?php
           
            $orderID = "order_CgmcjRh9ti2lP7";
            ?>
            
            <!-- Payment Form and Location Form -->
            <!-- Your forms here -->

            <!-- Razorpay Payment Form -->
    <script>
        const storedCartItems = JSON.parse(localStorage.getItem("cartItems"));
        const orderSummaryTable = document.querySelector("table");
        let totalAmount = 0;

        if (storedCartItems && storedCartItems.length > 0) {
            // Loop through the storedCartItems and add rows to the table
            storedCartItems.forEach(item => {
                const row = orderSummaryTable.insertRow();
                const itemNameCell = row.insertCell(0);
                const quantityCell = row.insertCell(1);
                const priceCell = row.insertCell(2);

                itemNameCell.textContent = item.name;
                quantityCell.textContent = 1; // You can adjust this as needed
                priceCell.textContent = `$${item.price.toFixed(2)}`;
                totalAmount += item.price;
            });

            // Update the totalAmount input field
            document.getElementById("totalAmount").value = totalAmount.toFixed(2);
            // Update the cartItems input field with the cart items as JSON
            document.getElementById("cartItems").value = JSON.stringify(storedCartItems);

            // Display the total amount
            const totalAmountDisplay = document.getElementById("totalAmountDisplay");
            totalAmountDisplay.textContent = `$${totalAmount.toFixed(2)}`;
        } else {
            // Handle the case where there are no items in the cart
            alert("Your cart is empty. Please add items to your cart.");
            // Redirect the user to the restaurant menu page or another appropriate page
            window.location.href = "restaurant_menu.php";
        }
    </script>
            <form action="https://www.example.com/payment/success/" method="POST">
                <script
                    src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="rzp_test_1EZki68KeF6PgJ" 
                    data-amount="<?php echo $totalAmount * 100; ?>"
                    data-currency="INR"
                    data-order_id="<?php echo $orderID; ?>"
                    data-buttontext="Place Order"
                    data-name="Acme Corp"
                    data-description="Order payment for Order ID: <?php echo $orderID; ?>"
                    data-image="https://example.com/your_logo.jpg"
                    data-prefill.name="<?php echo $username; ?>"
                    data-prefill.email="<?php echo $email; ?>"
                    data-theme.color="#F37254"
                ></script>
                <input type="hidden" name="hidden"/>
            </form>

        </div>

        <form action="payscript.php" method="post">
            <input type="hidden" id="totalAmount" name="totalAmount" value="0">
            <input type="hidden" id="cartItems" name="cartItems" value="">
            <button type="submit">Check Orders</button>
        </form>
    </main>


    <!-- Footer and other content -->
</body>
</html>
