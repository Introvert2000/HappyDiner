<html>
  <head>
    <style>
         body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
  </head>
    <body>
        <form method='POST' action='<?php echo $_SERVER["REQUEST_URI"]; ?>' enctype='multipart/form-data'>
        <label for="item_name">Item Name:</label>
            <input type="text" name="item_name" required>
            <br>
        
            <label for="item_price">Item Price:</label>
            <input type="text" name="item_price" required>
            <br> 
        <input type='file' name='file' required>
         <input type='submit' value='Upload' >
        </form>
  </body>
</html>
<?php 
    $con=mysqli_connect('localhost','root','','restaurant');
    session_start();

    $restaurant = $_SESSION['restaurant_name']; 
    
    if(isset($_FILES["file"]))
    {
        $item_name = $_POST['item_name'];
        $item_price = $_POST['item_price'];

       $fileName=basename($_FILES["file"]["name"]); //Get File Name 
       $fileType=pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);//Get File Extension
       
       $fileType=strtolower($fileType); //convert to lowercase
       $uploadFile=$fileName.rand(1000,10000).".".$fileType; //Set File name with Random Number
       
       //Check File Size greater than 300KB
       if($_FILES["file"]["size"]>300000){
      echo "Upload Failed.File Size is too Large!!!";
       }
       //Check File Extension
       else if($fileType != 'jpg'&&$fileType != 'jpeg'&&$fileType != 'png' && $fileType != 'gif'){
      echo "Upload Failed.Invalid File!!!";
       }
       
       //Upload File
       else{
      $imgData =addslashes (file_get_contents($_FILES['file']['tmp_name']));
       $sql="insert into `$restaurant`(food_item,price,image) values('{$item_name}','{$item_price}','{$imgData}')";
      if($con->query($sql)){
        echo '<script>';
            echo 'alert("Upload Successful");';
            echo 'window.location.href = "dashboard_restaurant.php";'; // Redirect to dashboard.php
            echo '</script>';
      }
      }
    }
?>