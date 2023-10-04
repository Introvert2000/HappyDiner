<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Poppins", sans-serif;
        }

        body {
            /* display: flex; 
            justify-content: center;
            align-items: center; */
            min-height: 100vh;
            background: url(4492606.jpg) no-repeat;
            background-size: cover; /* Added to cover the entire viewport */
        }

        .wrapper {
            /* display: flex; */
            justify-content: center;
            align-items: center;
            width: 420px;
            background: white;
            color: black;
            border-radius: 10px;
            padding: 30px;
            margin: 10% 34%;
            text-align: center; /*Center content horizontally */
        }

        .wrapper h1 {
            font-size: 36px;
        }

        .input-box {
            width: 100%;
            margin: 20px 0;
            position: relative;
        }

        .input-box input {
            width: 100%;
            height: 45px;
            background: transparent;
            border: none;
            outline: none;
            border: 1px solid #ccc;
            border-radius: 40px;
            font-size: 16px;
            color: black;
            padding: 15px; /* Adjusted padding */
        }

        .input-box i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
        }

        .remember-forgot {
            display: flex;
            justify-content: space-between;
            font-size: 14.5px;
            margin: 15px 0; /* Adjusted margin */
            align-items: center; /* Center vertically */
        }

        .remember-forgot label input {
            accent-color: black;
            margin-right: 3px;
            border: 1px solid #ccc;
        }

        .remember-forgot a {
            color: black;
            text-decoration: none;
        }

        .remember-forgot a:hover {
            text-decoration: underline;
        }

        .btn {
            width: 100%;
            height: 45px;
            background-color: orange;
            border: none;
            outline: none;
            border-radius: 40px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            font-size: 16px;
            color: #333;
            font-weight: 600;
            margin-top: 15px; /* Adjusted margin */
        }

        .Register-Link {
            font-size: 14.5px;
            text-align: center;
            margin-top: 20px; /* Adjusted margin */
        }

        .Register-Link p a {
            color: black;
            text-decoration: none;
            font-weight: 600;
        }

        .Register-Link p a:hover {
            text-decoration: underline;
        }

        .showpassword{

        }
    </style>
</head>
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
                <ul>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>
</header>


<body>
<div class="wrapper">
    <form action="login2.php" method="post">
        <h1>Login</h1>
        <div class="input-box">
            <input type="text" placeholder="Username" required name="Username">
            <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
            <input type="password" placeholder="Password" required name="Password1" id="myInput">
            <i class="bx bxs-lock-alt"></i>
        </div>
       <div class="remember-forgot">
        <label >
       <input type="checkbox" onclick="myFunction()">Show Password
       </label>
       </div>

<script>
function myFunction() {
  var x = document.getElementById("myInput");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}
</script>
 <div class="remember-forgot">
 <label>
 <input type="checkbox">
  Remember me
 </label>
 <a href="forget.php">Forgot password?</a>
 </div>
 
 <button type="Submit" class="btn">Login</button>

 <div class="Register-Link">
 <p>Don't have an account? <a href="register.php">Register</a></p>
 </div>
 </form>
</div> 
</body>
</html>
