<?php
$Name1 = $_POST['Name1'];
$Username = $_POST['Username'];
$email = $_POST['email'];
$MobileNo = $_POST['MobileNo'];
$Password1 = $_POST['Password1'];

//Connection
$conn = new mysqli('localhost','root','','login');
if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
}else{
    $stmt=$conn->prepare("INSERT INTO reg(Name1,Username,email,MobileNo,Password1) VALUES(?,?,?,?,?)");
    $stmt->bind_param("sssis",$Name1,$Username,$email,$MobileNo,$Password1);
    $stmt->execute();
    echo "Registration Successful";
    $stmt->close();
    $conn->close();


}
?>