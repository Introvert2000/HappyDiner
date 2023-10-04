<?php
session_start();
if(empty($_SESSION['Name1']))
{
	header('location:index.php');
}
?>
<center><h2>Welcome, <?php if(!empty($_SESSION['Name1'])){ echo $_SESSION['Name1']; }?> to the dashboard</h2></center>
<center><h3><a href="logout.php">Logout</a></h3></center>
