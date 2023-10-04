<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "login";
$connection = mysqli_connect("$server","$username","$password");
$select_db = mysqli_select_db($connection, $database);
if(!$select_db)
{
	echo("connection terminated");
}

$select_query = mysqli_query($connection,"SELECT * FROM restaurant");

while($row = mysqli_fetch_assoc($select_query)){


$imageData = $row['restaurant_image'];
$base64Image = base64_encode($imageData);
echo '<img src="data:image/jpeg;base64,' . $base64Image . '" />';

}
?>
