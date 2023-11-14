<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="reviews.css">
    <title>Restaurant Reviews</title>
</head>
<body>
    <h1>Restaurant Reviews</h1>

    <?php
    // Database connection details
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "login";

    // Create a database connection
    $conn = new mysqli('localhost','root','','login');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch restaurant reviews from the database
    $sql = "SELECT * FROM reviews";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='review'>";
            echo "<h2>" . $row['restaurant_name'] . "</h2>";
            echo "<p>Rating: " . $row['date1'] . "</p>";
            echo "<p>Reviewer: " . $row['customer_username'] . "</p>";
            echo "<p>Rating: " . $row['stars'] . "</p>";
            echo "<p>Review: " . $row['review_discription'] . "</p>";
            echo "</div>";
        }
    } else {
        echo "No reviews available.";
    }

    // Close the database connection
    $conn->close();
    ?>

    <a href="add_review.php">Add a Review</a>
</body>
</html>
