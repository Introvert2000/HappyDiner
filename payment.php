
<!DOCTYPE html>
<html lang="en">
<head>
<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #333;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #333;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        p {
            font-weight: bold;
        }

        #totalAmountDisplay {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        button {
            background-color: #333;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #555;
        }
    </style>
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
            <p>Total Amount: <span id="totalAmountDisplay">0.00</span></p>
            
            <!-- Payment Form and Location Form -->
            <!-- Your forms here -->
        </div>

        <form action="payscript2.php" method="post">
            <input type="hidden" id="totalAmount" name="totalAmount" value="0">
            <input type="hidden" name="restaurantName" id="restaurantName" value="">
            <!-- Add a hidden input field for cart items -->
            <input type="hidden" id="cartItems" name="cartItems" value="">
            
            <button type="submit">Proceed to Payment</button>
        </form>
    </main>
    
    <script>
          const urlParams = new URLSearchParams(window.location.search);
        const restaurantName = urlParams.get('restaurantName');

        // Set the restaurantName hidden input field
        document.getElementById("restaurantName").value = restaurantName;

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

            // Display the total amount
            const totalAmountDisplay = document.getElementById("totalAmountDisplay");
            totalAmountDisplay.textContent = `$${totalAmount.toFixed(2)}`;

            // Set the cartItems input field with the JSON string
            const cartItemsInput = document.getElementById("cartItems");
            cartItemsInput.value = JSON.stringify(storedCartItems);
        } else {
            // Handle the case where there are no items in the cart
            alert("Your cart is empty. Please add items to your cart.");
            // Redirect the user to the restaurant menu page or another appropriate page
            window.location.href = "restaurant_menu.php";
        }
    </script>




    <!-- Footer and other content -->
</body>
</html>

