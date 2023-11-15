<!DOCTYPE html>
<html>
<head>
    <title>Add a Review</title>
    <link rel="stylesheet" href="add_review.css">
</head>
<body>
    <div class="flex">
    <h1 class="naving">Add a Review</h1>

    <form method="post" action="add_review.php" class="form">
    <label for="restaurant_name">Restaurant Name:</label>
    <input class="inputForm" type="text" name="restaurant_name" required><br><br>

    <label for="customer_name">Your Name:</label>
    <input type="text" class="inputForm" name="customer_name" required><br><br>

    <label for="date">Your Name:</label>
    <input type="date" class="inputForm" name="date" required><br><br>

    <label for="stars">Rating:</label>
    <input type="number" class="inputForm" name="stars" min="1" max="5" required><br><br>

    <label for="review_discription">Review:</label>
    <textarea class="inputForm" name="review_discription" rows="4" required></textarea><br><br>

    <input type="submit" class="button-submit" "Submit Review">
    </form>
    <a class="custom-btn btn-1" href="reviews.php">Back to Reviews</a>
    </div>

   

    <?php
    // Check if the form is submitted
  
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection details
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "login";

    // Create a database connection
    $conn = new mysqli($server, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve data from the form
    $restaurantName = $_POST['restaurant_name'];
    $reviewerName = $_POST['customer_name'];
    $rating = $_POST['stars'];
    $reviewText = $_POST['review_discription'];
    $giveDate = $_POST['date'];

    // Check if the restaurant is present and has an approved status
    $checkRestaurantQuery = "SELECT * FROM restaurant WHERE restaurant_name = '$restaurantName' AND status = 'Approved'";
    $result = $conn->query($checkRestaurantQuery);

    if ($result->num_rows > 0) {
        // Restaurant is present and approved, proceed with the review insertion

        // Insert the review into the database
        $sql = "INSERT INTO restaurant_reviews (restaurant_name, customer_username, stars, review_description, date1) VALUES ('$restaurantName', '$reviewerName', '$rating', '$reviewText', '$giveDate')";

        if ($conn->query($sql) === TRUE) {
            // Success: Display JavaScript alert and redirect
            echo '<script>alert("Review added successfully!"); window.location.replace("reviews.php");</script>';
        } else {
            // Error: Display JavaScript alert and redirect
            echo '<script>alert("Error: ' . $sql . '\n' . $conn->error . '"); window.location.replace("add_review.php");</script>';
        }
    } else {
        // Restaurant not found or not approved: Display JavaScript alert and redirect
        echo '<script>alert("Error: The restaurant either does not exist or is not approved."); window.location.replace("add_review.php");</script>';
    }

    // Close the database connection
    $conn->close();
}
?>

</body>
</html>
