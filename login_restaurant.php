<?php
session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Login</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="font.css">
    <link rel="stylesheet" href="login.css">
</head>



<body>
<div class="wrapper">
    <form action="login_rest2.php" method="post">
        <h1>Partner Login</h1>
        <div class="input-box">
            <input type="text" placeholder="Owner Email" required name="owner_email">
            <i class="bx bxs-user"></i>
        </div>
        <div class="input-box">
            <input type="password" placeholder="Password" required name="Password2" id="myInput">
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
 <p>Wanna be a Partner ?<a href="register_restaurant.php">Register</a></p>
 </div>
 </form>
</div> 

</body>
</html>
