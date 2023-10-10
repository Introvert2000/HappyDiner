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
    
    <main>
        <button id="toggleSidebar">☰ Menu</button>
        <section id="dashboard">
            <h2 id="basic">Basic Restaurant Statistics</h2>
            <!-- Add your basic statistics here -->
        </section>

        <section id="menu-content">
            <!-- Content for orders and bookings pages will load here -->
        </section>
    </main>

    <div id="sidebar">
        <a href="#" id="closeSidebar">Close</a>
        <a href="order_dashboard.php">Orders</a>
        <a href="table_dashboard.php">Bookings</a>
    </div>

    <div class="dashboard">
        <h2>Current Orders</h2>
        <div class="order">
            <span>Order #1:</span>
            <span>Status: <strong>Pending</strong></span>
            <span class="timer">00:10</span> <!-- Timer display -->
        </div>
        <div class="order">
            <span>Order #2:</span>
            <span>Status: <strong>Completed</strong></span>
        </div>
    </div>

    <div class="dashboard">
        <h2>Tables Booked</h2>
        <span>Number of Tables Booked: <strong>5</strong></span>
    </div>

    <script>
        // JavaScript for side drawer animation
        const toggleSidebarButton = document.getElementById("toggleSidebar");
        const closeSidebarButton = document.getElementById("closeSidebar");
        const sidebar = document.getElementById("sidebar");

        toggleSidebarButton.addEventListener("click", () => {
            sidebar.style.width = "250px";
        });

        closeSidebarButton.addEventListener("click", () => {
            sidebar.style.width = "0";
        });
    </script>
</body>
</html>
