<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Result</title>
    <link rel="stylesheet" href="index.css">
    <link rel="stylesheet" href="dropdown.css">
    <link rel="stylesheet" href="./search3.css">
</head>

<body>
    <header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="index.php">Happy Diner</a>
                </div>
                <div class="search-bar">
                    <form action='search3.php' method="POST">
                        <input type="text" name="query" placeholder="Search products">
                        <button type="submit" class="search-button">Search</button>
                    </form>
                </div>
                <div class="menu">
                    <?php
                    session_start();
                    if (empty($_SESSION['Name1'])) {
                        ?>
                        <ul>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    <?php } else { ?>
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
                    <?php } ?>
                </div>
            </div>
        </nav>
    </header>


    <main>

        <?php
        // Database configuration
        $dbHost = "localhost";
        $dbUser = "root";
        $dbPassword = "";
        $dbName = "login";

        // Create a database connection
        $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

        // Check for connection errors
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if a search query is provided
        if (isset($_POST["query"])) {
            $query = $_POST["query"];
            // Modify your database query to search for products based on the query
            $stmt = $conn->prepare("SELECT * FROM restaurant WHERE restaurant_name LIKE ?");
            $searchQuery = "%" . $query . "%";
            $stmt->bind_param("s", $searchQuery);
            $stmt->execute();
            $result = $stmt->get_result();


            //displaying search result of index 
            if ($result->num_rows > 0) {

                while ($row = $result->fetch_assoc()) {
                    ?>
                    <div class="card2">
                        <div class="image2">
                            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['image']); ?>" />
                        </div>
                        <div class="caption">
                            <form method="POST" action="test6.php">
                                <?php
                                $restaurantName = $row['restaurant_name'];
                                $_SESSION['restaurant'] = $restaurantName;
                                ?>
                                <h1 class="product_name">
                                    <?php echo $restaurantName; ?>
                                </h1>
                                <!-- <p class="product_name". ><?php echo $row["restaurant_name"]; ?></p>  -->

                                <!-- <input type="submit" id="Submit" name="Submit" value="Book" class="btn btn-success" /> -->
                               <div class="">
                               <button type="button" class="button"
                                    onclick="displaySelectedOptionOrder(`<?php echo $restaurantName; ?>`)">Order</button>
                                <button type="button" class="button"
                                    onclick="displaySelectedOptionBook(`<?php echo $restaurantName; ?>`)">Book</button>
                               </div>



                                <script>
                                    function displaySelectedOptionOrder(restaurantName) {
                                        window.location.href = `delivery_product.php?restaurantName=${restaurantName}`;
                                    }
                                    function displaySelectedOptionBook(restaurantName) {
                                        window.location.href = `book_table.php?restaurantName=${restaurantName}`;
                                    }
                                </script>
                            </form>
                        </div>



                    </div>
                    <?php

                }

            } else {
                echo "No results found for: " . htmlspecialchars($query);
            }
        }
        ?>

    </main>
</body>

</html>