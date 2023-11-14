<?php
$owner_email = $_POST['owner_email'];
$restaurant_name = ($_POST['restaurant_name']);

//database connection here

$con = new mysqli('localhost','root','','login');
if($con->connect_error){
    die('Failed to connect : ' .$con->connect_error);
} else {
    if(isset($_REQUEST['Submit']))
  {
    $email = $_REQUEST['owner_email'];
    $select_query = mysqli_query($con,"select * from reg where email='$email'");
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
  $insert_query = mysqli_query($con,"insert into tbl_otp_check set otp='$otp', is_expired='0'");
  header('location:otpverify_restaurant.php');
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
?>