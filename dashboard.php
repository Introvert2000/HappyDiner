<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
	
    <style>
        /* Add your CSS styles here */
		
        body {
			font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
		
        .containerz {
			max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        h1 {
            text-align: center;
        }
		
        .account-info {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }
		
        .booking-history,
        .orders-history {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
        }

        .order-details {
			margin-top: 10px;
        }
		</style>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Happy Diner</a>
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
    <div class="containerz">
        <h1>Dashboard</h1>

        <div class="account-info">
            <h2>Account Information</h2>
            <p><strong>Account Name:</strong> John Doe</p>
        </div>

        <div class="booking-history">
            <h2>Booking History</h2>
            <div class="booking-item">
                <p><strong>Restaurant Name:</strong> Italian Bistro</p>
                <p><strong>Date:</strong> 2023-10-15</p>
                <p><strong>Price:</strong> $50.00</p>
            </div>
            <div class="booking-item">
                <p><strong>Restaurant Name:</strong> Thai Cuisine</p>
                <p><strong>Date:</strong> 2023-10-12</p>
                <p><strong>Price:</strong> $40.00</p>
            </div>
            <!-- Add more booking items here -->
        </div>

        <div class="orders-history">
            <h2>Food Delivery Orders</h2>
            <div class="order-item">
                <p><strong>Restaurant Name:</strong> Pizza Palace</p>
                <p><strong>Date:</strong> 2023-10-10</p>
                <p><strong>Price:</strong> $25.00</p>
            </div>
            <div class="order-item">
                <p><strong>Restaurant Name:</strong> Sushi Express</p>
                <p><strong>Date:</strong> 2023-10-05</p>
                <p><strong>Price:</strong> $30.00</p>
            </div>
            <!-- Add more order items here -->
        </div>

        <form action="logout.php" method="post">
        <button type="submit">Logout</button>
        </form>
    </div>
</body>
</html>

