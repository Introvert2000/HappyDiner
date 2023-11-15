<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="reviews.css">
    <title>Restaurant Reviews</title>
</head>
<body>
    <nav>
        <h1>Restaurant reviews</h1>
    </nav>
    <!-- <h1>Restaurant Reviews</h1> -->

    <?php
    // Database connection details
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "login";
    $restaurant = $_GET["restaurant"];
    // Create a database connection
    $conn = new mysqli('localhost','root','','login');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch restaurant reviews from the database
    $sql = "SELECT * FROM restaurant_reviews WHERE restaurant_name = '$restaurant' ";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='out'>";
        echo "<div class='card'>";
        echo "<div class='card_content'>";
        echo "<p class='content'>Rating Date: " . $row['date1'] . "</p>";
        echo "<p class='content'>Reviewer: " . $row['customer_username'] . "</p>";
        echo "<p class='content'>Rating: " . $row['stars'] . "</p>";
        echo "<p class='content'>Review: " . $row['review_description'] . "</p>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "No reviews available.";
}


    // Close the database connection
    $conn->close();
    ?>

    <a class="btn" href="add_review.php">Add a Review</a>

    <br>
    <br>
    <br><br>
    <br>
    <div>
    <button type="button" class="bookButton" onclick="displaySelectedOptionBook(`<?php echo $restaurantName; ?>`)">Book a Table</button>
    </div>

<script>
    function displaySelectedOptionBook(restaurant) {
        window.location.href = `book_table2.php?restaurantName=${restaurant}`;
    }
</script

</body>
</html>
