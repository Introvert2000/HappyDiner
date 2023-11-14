<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $Email = $_POST['Email'];
    $NewPassword = md5($_POST['NewPassword']); // You should use a more secure password hashing method.

    // Database connection
    $con = new mysqli('localhost', 'root', '', 'login');
    if ($con->connect_error) {
        die('Failed to connect: ' . $con->connect_error);
    }

    // Check if the user exists
    $stmt = $con->prepare("SELECT * FROM reg WHERE email = ?");
    $stmt->bind_param("s", $Email);
    $stmt->execute();
    $stmt_result = $stmt->get_result();

    if ($stmt_result->num_rows > 0) {
        // Update the user's password
        $update_stmt = $con->prepare("UPDATE reg SET password1 = ? WHERE email = ?");
        $update_stmt->bind_param("ss", $NewPassword, $Email);

        if ($update_stmt->execute()) {
            echo '<h2>Password reset successfully.</h2>';
        } else {
            echo '<h2>Failed to reset the password.</h2>';
        }
    } else {
        echo '<h2>User not found. Please check the email address.</h2>';
    }
}
?>
