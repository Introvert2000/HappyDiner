<html>  
<head>  
    <title>OTP Verify</title>  
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="./otpverify_restaurant.css">
  </head>
<?php
session_start();
if (empty($_SESSION['Name1'])) {
  echo '<script>alert("Session has expired. Please log in again.");</script>';
  echo '<script>window.location = "login.php";</script>';
  exit;
}
include_once('connection.php');
if(isset($_REQUEST['otp_verify']))
{
  $otp = $_REQUEST['otp'];
  $select_query = mysqli_query($connection,"select * from tbl_otp_check where otp='$otp' and is_expired!=1 and NOW()<=DATE_ADD(create_at,interval 5 minute)");
  $count = mysqli_num_rows($select_query);
  if($count>0)
  {
    $select_query = mysqli_query($connection, "update tbl_otp_check set is_expired=1 where otp='$otp'");
    header('location:index.php');
  }
  else
  {
    $msg = "Invalid OTP!";
  }
}
?>
<main>  
    <div class="container">  
    <div class="table-responsive">  
      <div class="box">
      <h3 align="center" class="h3">Login Form</h3><br/>
     <form method="post" >  
       <div class="form-group">
       <label for="otp">Enter OTP</label>
       <input type="text" name="otp" id="otp" placeholder="Enter OTP" required 
       data-parsley-type="otp" data-parsley-trigg
       er="keyup" class="form-control"/>
      </div>
      <div class="form-group">
       <button type="submit" id="submit" name="otp_verify" value="Submit" class="btn btn-success">Submit</button>
       </div>
       <p class="error">
        <?php if(!empty($msg)){
           echo $msg; 
        } ?>
        </p>
     </form>
     </div>
   </div>  
  </div>
</main>  
</html>  
