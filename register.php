<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
   <link rel="stylesheet" href="style2.css"> 
   <link rel="stylesheet" href="styles.css">
    <style>
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            padding: 10px;
            opacity: 0.7; /* Adjust the opacity to make the content partially visible */
        }

        /* Style for the link */
        footer a {
            color: #fff;
            text-decoration: underline;
        }
    </style>
</head>
<body>
   
    <div class="containerz">
        <form method="post">
            <div class="wrapper">
                <h1>Registration</h1>
            
            <div class="user-details">
                <div class="input-box">
                    <!-- <span class="detail">Full Name</span> -->
                    <input type="text" placeholder="Enter your name" name="Name1">
                </div>
                <div class="input-box">
                    <!-- <span class="detail">Username</span> -->
                    <input type="text" placeholder="Enter your username" name="Username">
                </div>
                <div class="input-box">
                    <!-- <span class="detail">Email</span> -->
                    <input type="text" placeholder="Enter your Email" name="email">
                </div>
                <div class="input-box">
                    <!-- <span class="detail">Mobile No</span> -->
                    <input type="text" placeholder="Enter your Mobile No" name="MobileNo">
                </div> 
              <div class="input-box">
                    <!-- <span class="detail">Password</span> -->
                    <input type="password" placeholder="Enter your password" name="Password1">
                </div> 
                
               
        </div>
        

    </div>
        <!---- <div class="button">
            <input type="submit" value="Register">
        </div>
    --> 
    <div class="form-group">
        <input type="submit" id="Submit" name="Submit" value="Register" class="btn btn-success" />
            </div>     
          
          
          
      </form>
    </div>
<footer>
   Want to be a Restaurant Partner ?    <a href="register_restaurant2.php">Register</a>.
</footer>

</body>
</html>



<?php
// session_start();
// include_once('connect.php');
session_start();
include_once('connection.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
  
    $conn = mysqli_connect("localhost","root","","login");
  
  $Name1 = $_POST['Name1'];
  $Username = $_POST['Username'];
  $email = $_POST['email'];
  $MobileNo = $_POST['MobileNo'];
  $Password1 = md5($_POST['Password1']);
  
  $stmt = $conn->prepare("SELECT * FROM reg WHERE Username = ? OR email = ? OR MobileNo = ?");

    $stmt->bind_param("sss", $Username, $Email, $Phone);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        // If any of the fields already exist in the database, display an error message
        echo '<script type="text/javascript">alert("Email, Username, or Phone already exists in the database.");</script>';
    } else {


  
  

    $stmt=$conn->prepare("INSERT INTO reg(Name1,Username,email,MobileNo,Password1) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssis",$Name1,$Username,$email,$MobileNo,$Password1);
    $stmt->execute();
    echo "Registration Successful";
    $stmt->close();



    if(isset($_REQUEST['Submit']))
  {
    $email = $_REQUEST['email'];
    $select_query = mysqli_query($connection,"select * from reg where email='$email'");
    $res = mysqli_num_rows($select_query);
    if($res>0)
    {
      $data = mysqli_fetch_array($select_query);
      $Name1 = $data['Name1'];
      $_SESSION['Name1'] = $Name1;
      $otp = rand(10000, 99999);   //Generate OTP
      include_once("SMTP/class.phpmailer.php");
      include_once("SMTP/class.smtp.php");
      $message = '<div>
      <p><b>Hello!</b></p>
      <p>You are recieving this email because we recieved a OTP request for your account.</p>
      <br>
     <p>Your OTP is: <b>'.$otp.'</b></p>
     <br>
     <p>If you did not request OTP, no further action is required.</p>
    </div>';
$email = $email; 
$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPAuth = true;                 
$mail->SMTPSecure = "tls";      
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587; 
$mail->Username = "te9270564@gmail.com"; // Enter your username
$mail->Password = "tpllzxxdudclesma"; // Enter Password
$mail->FromName = "HappyDiner";
$mail->AddAddress($email);
$mail->Subject = "OTP";
$mail->isHTML( TRUE );
$mail->Body =$message;
if($mail->send())
{
  $insert_query = mysqli_query($connection,"insert into tbl_otp_check set otp='$otp', is_expired='0'");
  header('location:otpverify.php');
}
else
{
  $msg = "Email not delivered";
}
}
else
{
  $msg = "Invalid Email";
}
$conn->close();
}
  }
  
}
  
  

  
  
  


?>