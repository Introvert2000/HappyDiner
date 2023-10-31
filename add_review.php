<!DOCTYPE html>
<html>
<head>
    <title>Add a Review</title>
</head>
<body>
    <h1>Add a Review</h1>

    <form method="post" action="add_review.php">
        <label for="restaurant_name">Restaurant Name:</label>
        <input type="text" name="restaurant_name" required><br><br>

        <label for="customer_name">Your Name:</label>
        <input type="text" name="customer_name" required><br><br>

        <label for="date">Your Name:</label>
        <input type="date" name="date" required><br><br>

        <label for="stars">Rating:</label>
        <input type="number" name="stars" min="1" max="5" required><br><br>

        <label for="review_discription">Review:</label>
        <textarea name="review_discription" rows="4" required></textarea><br><br>

        <input type="submit" value="Submit Review">
    </form>

    <a href="reviews.php">Back to Reviews</a>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Retrieve data from the form
        $restaurantName = $_POST['restaurant_name'];
        $reviewerName = $_POST['customer_name'];
        $rating = $_POST['stars'];
        $reviewText = $_POST['review_discription'];
        $giveDate  = $_POST['date'];

        // Insert the review into the database
        $sql = "INSERT INTO reviews (restaurant_name, customer_username, stars, review_discription, date1) VALUES ('$restaurantName', '$reviewerName', '$rating', '$reviewText',' $giveDate ')";

        if ($conn->query($sql) === TRUE) {
            echo "Review added successfully!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>
</body>
</html>
