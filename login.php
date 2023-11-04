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
    <link rel="stylesheet" href="font.css">
    <link rel="stylesheet" href="login.css">
</head>



<body>
<div class="wrapper">
    <form  method="post">
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
<footer>
    Restaurant Partner ?    <a href="login_restaurant.php">Click here</a>.
</footer>
</body>
</html>

<?php

//database connection here
if($_SERVER['REQUEST_METHOD']=='POST'){
$con = new mysqli('localhost','root','','login');
$Username = $_POST['Username'];
$Password1 = md5($_POST['Password1']);
if($con->connect_error){
    die('Failed to connect : ' .$con->connect_error);
} else {
    $stmt = $con->prepare("SELECT * FROM reg WHERE Username = ?");
    $stmt->bind_param("s",$Username);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0){
        $data = $stmt_result->fetch_assoc();
        if($data['Password1']===$Password1){
            $_SESSION['Name1'] = $data['Name1'];
            header('location:dashboard.php');
        }
        else{
            echo '<script type="text/javascript">alert("Wrong email or password.");</script>';
        }
    }
}
}
?>
