

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php




?>

<body>
<div class="wrapper">  
    <div class="table-responsive">  
    
    <div class="box">
     <form method="post"  >  
       <div class="form-group">
       <label for="email">Reset Password</label>
       <div class="input-box">
       <input type="text" name="Email" id="email" placeholder="Enter Email" required 
       data-parsley-type="email" data-parsley-trigger="keyup" >
       </div>
       <div class="input-box">
       <input type="password" name="NewPassword" id="password" placeholder="Enter new Password" required 
       data-parsley-type="password" data-parsley-trigger="keyup" >
       </div>
       </div>
       <div class="form-group">
       <input type="submit" id="login" name="login" value="Submit" class="btn btn-success" />
       </div>
     
       <p class="error">
        <?php if(!empty($msg)){ echo $msg; } ?></p>
     </form>
     </div>
   </div>  
  </div>
</body>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['Email'];
    $NewPassword = md5($_POST['NewPassword']); // You should use a more secure password hashing method.

    // Database connection
    $con = new mysqli('localhost', 'root', '', 'login');
    if ($con->connect_error) {
        die('Failed to connect: ' . $con->connect_error);
    }

    // Check if the user exists
    $stmt = $con->prepare("SELECT * FROM reg WHERE email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        // Update the user's password
        $update_stmt = $con->prepare("UPDATE reg SET password1 = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $NewPassword, $Email);

        if ($update_stmt->execute()) {
          echo '<script type="text/javascript">alert("Password successfully resetted");</script>';
          header('location:login.php');
          exit();
        } else {
            echo '<h2>Failed to reset the password.</h2>';
        }
    } else {
        echo '<h2>User not found. Please check the email address.</h2>';
    }
}
?>

</html>