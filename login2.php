<?php
$Username = $_POST['Username'];
$Password1 = md5($_POST['Password1']);

//database connection here

$con = new mysqli('localhost','root','','login');
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
            echo "<h2>Login Successsfully</h2> ";
        }
        else{
            echo "<h2>Invalid Username or password</h2> ";
        }
    }else{
        echo "<h2>Invalid Username or Password</h2>";
    }
}
?>