<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Table Booking</title>
    <link rel="stylesheet" href="book_table.css">
    <link rel="stylesheet" href="styles.css"> <!-- You can link to your CSS file here -->
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
                    if (empty($_SESSION['Name1'])) {

                        ?>
                        <ul>
                            <li><a href="login.php">Login</a></li>
                            <li><a href="register.php">Register</a></li>
                        </ul>
                    <?php } else {
                        ?>

                        <ul>
                            <li id="username"> <a>
                                    <?php if (!empty($_SESSION['Name1'])) {
                                        echo $_SESSION['Name1'];
                                    } ?>
                                </a> </li>
                        </ul>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="center-form">
            <div>

                <?php
    
               
                $restaurantName = $_GET['restaurantName'];
                ?>
    
                <h2>
                    <?php
                    echo $restaurantName;
                    ?>
                </h2>
            </div>
            <section class="center-form" id="booking-form">
                <div>
                    <h2>Reservation Details</h2>
                    <form action="process_reservation.php" method="post">
                        <input type="hidden" name="restaurantName" value="<?php echo $restaurantName; ?>">
                        
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required><br><br>

                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required><br><br>

                        <label for="phone">Phone Number:</label>
                        <input type="tel" id="phone" name="phone" required><br><br>

                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required><br><br>

                        <label for="time">Time:</label>
                        <input type="time" id="time" name="time" required><br><br>

                        <label for="guests">Number of Guests:</label>
                        <input type="number" id="guests" name="guests" required><br><br>

                        <input type="submit" id="sub_button" onclick="displaySelectedOption(`<?php echo $restaurantName; ?>`)" value="Submit Reservation">
                        <!-- <button type="button" onclick="displaySelectedOption(`<?php echo $restaurantName; ?>`)">Book</button> -->
                    </form>
                </div>
            </section>
        </div>
        <div class="review">
            <!-- fetch from the source -->

        </div>
    </main>

    <footer>
        <p>&copy;
            <?php echo date("Y");
            echo $restaurantName; ?>
        </p>
    </footer>
    <script>
        function displaySelectedOption(restaurantName) {
            window.location.href = `book_table.php?restaurantName=${restaurantName}`;
        }
    </script>
</body>

</html>