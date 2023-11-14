<?php

 $apiKey = "rzp_test_1EZki68KeF6PgJ";

?>
<?php
session_start();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Check if the form has been submitted (e.g., from a payment page)
//     if (isset($_POST['restaurantName'])) {
//         // Store restaurant name in a session variable
//         $_SESSION['restaurantName'] = $_POST['restaurantName'];
//     }

//     if (isset($_POST['totalAmount'])) {
//         // Store total amount in a session variable
//         $_SESSION['totalAmount'] = $_POST['totalAmount'];
//     }

//     if (isset($_POST['cartItems'])) {
//         // Store cart items in a session variable
//         $_SESSION['cartItems'] = json_decode($_POST['cartItems'], true);
//     }

//     // Redirect to success.php or any other page
    
// }



?>
<script src="https://code.jquery.com/jquery-3.5.0.js"></script>



<form action="payscript3.php" method="POST">
<script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $apiKey; ?>"
    data-amount="<?php echo $_SESSION['totalamount'] * 100;?>" 
    data-currency="INR"
    data-id="<?php echo 'OID'.rand(10,100).'END';?>"
    data-buttontext="Pay with Razorpay"
    data-name="Traidev Solutions"
    data-description="Training & Development!"
    data-image="https://traidev.com/img/web-desgin-development.png"
    data-prefill.name="<?php echo $_POST['restaurantName'];?>"
    data-prefill.email="<?php echo $_POST['email'];?>"
    data-prefill.contact="<?php echo $_POST['mobile'];?>"
    data-theme.color="#F37254"
></script>
<input type="hidden" custom="Hidden Element" name="hidden">
</form>


<style>
    .razorpay-payment-button{
        display : none;
    }
</style>


<script type="text/javascript">
$(document).ready(function(){
    $('.razorpay-payment-button').click();
});
</script>

