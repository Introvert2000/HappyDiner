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
    <form method="post">
        <h1>Partner Login</h1>
        <div class="input-box">
                    <!-- <span class="detail">Email</span> -->
                    <input type="text" placeholder="Owner Email" name="owner_email">
                </div>
                <div class="input-box">
                    <!-- <span class="detail">Full Name</span> -->
                    <input type="text" placeholder="Restaurant Name" name="restaurant_name">
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
 
  <input type="submit" id="Submit" name="Submit" value="Login" class="btn btn-success" />

 <div class="Register-Link">
  <p>Wanna be a Partner ?<a href="register_restaurant.php">Register</a></p>
 </div>
 </form>
</div> 



</body>
</html>

<?php
session_start();
include_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $owner_email = $_POST['owner_email'];
    $restaurant_name = $_POST['restaurant_name'];

    // Establish a database connection
    $conn = mysqli_connect("localhost", "root", "", "login");

    // Check if the email and restaurant name exist in the database
    $stmt = $conn->prepare("SELECT * FROM restaurant WHERE owner_email = ? AND restaurant_name = ?");
    $stmt->bind_param("ss", $owner_email, $restaurant_name);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        // If both email and restaurant name exist, proceed to send an OTP
        $data = $stmt_result->fetch_assoc();
        $restaurant_name = $data['restaurant_name'];
        $_SESSION['restaurant_name'] = $restaurant_name;

        // Generate OTP
        $otp = rand(10000, 99999);

        // Include PHPMailer libraries
        include_once("SMTP/class.phpmailer.php");
        include_once("SMTP/class.smtp.php");

        $message = '<div>
            <p><b>Hello!</b></p>
            <p>You are receiving this email because we received an OTP request for your account.</p>
            <br>
            <p>Your OTP is: <b>' . $otp . '</b></p>
            <br>
            <p>If you did not request OTP, no further action is required.</p>
        </div>';

        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->Username = "te9270564@gmail.com"; // Replace with your email
        $mail->Password = "tpllzxxdudclesma"; // Replace with your email password
        $mail->FromName = "HappyDiner";
        $mail->AddAddress($owner_email);
        $mail->Subject = "OTP";
        $mail->isHTML(true);
        $mail->Body = $message;

        if ($mail->send()) {
            // Store the OTP in the database
            $insert_query = mysqli_query($conn, "INSERT INTO tbl_otp_check (otp, is_expired) VALUES ('$otp', '0')");
            header('location: otpverify_restaurant.php');
        } else {
            $msg = "Email not delivered";
        }
    } else {
        $msg = "Invalid Email or Restaurant Name";
    }

    $conn->close();
}
?>
