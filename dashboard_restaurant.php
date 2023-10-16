<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css"> <!-- You should create a separate CSS file -->
    <style>
        /* Add custom styles for the side drawer */
        #sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1;
            background-color: #333;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }

        #sidebar a {
            padding: 15px 25px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        #sidebar a:hover {
            background-color: #555;
        }

        #menu-content {
            margin-left: 250px;
            padding: 15px;
        }

        

    </style>
</head>
<body>
<header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="#">Happy Diner</a>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="menu">
                   <?php
                   session_start();
                    ?>

                        <ul>
                        <li id="restaurant_name"> <a><?php if(!empty($_SESSION['restaurant1'])){ echo $_SESSION['restaurant1']; }?></a> </li>
                        </ul>
                        
                        
                </div>
            </div>
        </nav>
</header>
    
    <!-- <main>
        <button id="toggleSidebar">☰ Menu</button>
        <section id="dashboard">
            <h2 id="basic">Basic Restaurant Statistics</h2>
            Add your basic statistics here 
        </section>

        <section id="menu-content">
             Content for orders and bookings pages will load here 
        </section>
    </main> -->
    <h1>Restaurant Owner Dashboard</h1>

<!-- Form to add a new menu item -->
<form action="add_item.php" method="post">
    <label for="item_name">Item Name:</label>
    <input type="text" name="item_name" required>
   
    <label for="item_price">Item Price:</label>
    <input type="text" name="item_price" required>

    <button type="submit">Add Item</button>
</form>

<h2>Menu Items</h2>
<table>
    <tr>
        <th>Item Name</th>
        <th>Item Price</th>
        
    </tr>
    <?php
    // Use PHP to fetch and display existing menu items from the database
    include 'connect_rest.php';
    $restaurant = $_SESSION['restaurant1'];                
    $sql = "SELECT * FROM `$restaurant`";
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row['food_item'] . "</td>";
        echo "<td>" . $row['price'] . "</td>";
        echo "<td><a href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
        echo "</tr>";
    }
    ?>
</table>
    <script src="drawer.js">
        
    </script>
<form action="logout_rest.php" method="post">
    <button type="submit">Logout</button>
</form>
</body>
</html>
