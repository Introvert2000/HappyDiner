<?php
$owner_email = $_POST['owner_email'];
$Password2 = ($_POST['Password2']);

//database connection here

$con = new mysqli('localhost','root','','login');
if($con->connect_error){
    die('Failed to connect : ' .$con->connect_error);
} else {
    $stmt = $con->prepare("SELECT * FROM restaurant WHERE owner_email = ?");
    $stmt->bind_param("s",$owner_email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();
    if($stmt_result->num_rows > 0){
        $data = $stmt_result->fetch_assoc();
        if($data['Password2']===$Password2){
            $sql = "SELECT restaurant_name FROM restaurant WHERE owner_email = ?";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $owner_email); // "s" indicates a string
            $stmt->execute();
            $result = $stmt->get_result();
            
            // Fetch the data from the result set
            $row = $result->fetch_assoc();
            
            if ($row) {
                session_start();
                $_SESSION['restaurant1'] = $row['restaurant_name'];
                $_SESSION['rest_id']=$row['restaurant_id'];
                header('location:dashboard_restaurant.php');
            }

        }
        else{
            echo "<h2>Invalid Username or password</h2> ";
        }
    }else{
        echo "<h2>Invalid Username or Password</h2>";
    }
}
?>