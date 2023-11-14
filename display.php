<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
    <link rel="stylesheet" href="font.css">
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
                <form method="post" action="display.php">
                    <input type="text" placeholder="Search..." name="query">
                    <button type="submit" class="search-button" name="submit">Search</button>
                </form>
                <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        
                            $query = $_POST["query"];
                        
                            if (!empty($query)) {
                                echo "<h2>Search Results for: " . htmlspecialchars($query) . "</h2>";

                                echo "You searched for: " . htmlspecialchars($query);
                            }
                        }
                ?>
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
                    <ul>
                        <li id="username"><a>
                            <?php if (!empty($_SESSION['Name1'])) {
                                echo $_SESSION['Name1'];
                            } ?>
                            </a></li>
                    </ul>
                <?php } ?>
            </div>
        </div>
    </nav>
</header>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["query"])) {
        $query = $_GET["query"];

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

        // Prepare and execute a database query
        $stmt = $conn->prepare("SELECT * FROM restaurant WHERE restaurant_name LIKE ?");
        $searchQuery = "%" . $query . "%";
        $stmt->bind_param("s", $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h2>Search Results for: " . htmlspecialchars($query) . "</h2>";

        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . htmlspecialchars($row["restaurant_name"]) . "</li>"; // Replace "column_name" with the appropriate column name from your table
            }
            echo "</ul>";
        } else {
            echo "No results found for: " . htmlspecialchars($query);
        }

        // Close the database connection
        $conn->close();
    } else {
        echo "<p>No search query provided.</p>";
    }
    ?>
</body>
</html>
