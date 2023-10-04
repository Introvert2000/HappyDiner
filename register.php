<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
   <link rel="stylesheet" href="style2.css"> 
   <link rel="stylesheet" href="styles.css">

</head>
<body>
    <header>
        <nav>
            <div class="container">
                <div class="logo">
                    <a href="home.php">Happy Diner</a>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                   
                </div>
                <input type="submit" name="submit" value="Search">

                <div class="menu">
                    <ul>
                        <li><a href="login.php">Login</a></li>
                        <li><a href="register.php">Register</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
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


</body>
</html>



<?php
// session_start();
// include_once('connect.php');
session_start();
include_once('connection.php');
if($_SERVER['REQUEST_METHOD']=='POST'){
  
  
  $Name1 = $_POST['Name1'];
  $Username = $_POST['Username'];
  $email = $_POST['email'];
  $MobileNo = $_POST['MobileNo'];
  $Password1 = md5($_POST['Password1']);
  
  // $servername = "localhost";
  //   $username = "root";
  //   $password = "";
  //   $database = "login";


    $conn = mysqli_connect("localhost","root","","login");
  
  
  // $sql = "INSERT INTO `reg` (`Name1`, `Username`, `email`,`Mobile`,`Password1`) VALUES
  //  ('$Name1', '$Username', '$email','$MobileNo','$Password1);";


  // $result = mysqli_query($conn,$sql);
//   // if($result){
//   //   echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
//   //   <strong>Success your entry is submited</strong> You should check in on some of those fields below.
//   //   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//   //   </div>';


$stmt=$conn->prepare("INSERT INTO reg(Name1,Username,email,MobileNo,Password1) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssis",$Name1,$Username,$email,$MobileNo,$Password1);
    $stmt->execute();
    echo "Registration Successful";
    $stmt->close();
  }
  
  
  
  
  //session_start();
  
  
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


?>