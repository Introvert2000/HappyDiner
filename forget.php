<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php
session_start();
include_once('connection.php');
if(isset($_REQUEST['login']))
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
     <p>You are recieving this email because we recieved a OTP request for forget password.</p>
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
$mail->Password = "tpllzxxdudclesma
"; // Enter Password
$mail->FromName = "HappyDiner";
$mail->AddAddress($email);
$mail->Subject = "OTP";
$mail->isHTML( TRUE );
$mail->Body =$message;
if($mail->send())
{
  $insert_query = mysqli_query($connection,"insert into tbl_otp_check set otp='$otp', is_expired='0'");
  header('location:forget_otp.php');
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
}

?>
<body>
<div class="wrapper">  
    <div class="table-responsive">  
    
    <div class="box">
     <form method="post" >  
       <div class="form-group">
       <label for="email">Enter Your Registered Email</label>
       <div class="input-box">
       <input type="text" name="email" id="email" placeholder="Enter Email" required 
       data-parsley-type="email" data-parsley-trigger="keyup" >
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
</html>









