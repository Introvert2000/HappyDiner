

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="style.css">
</head>
<?php




?>

<body>
<div class="wrapper">  
    <div class="table-responsive">  
    
    <div class="box">
     <form method="post" >  
       <div class="form-group">
       <label for="email">Reset Password</label>
       <div class="input-box">
       <input type="text" name="email" id="email" placeholder="Enter Email" required 
       data-parsley-type="email" data-parsley-trigger="keyup" >
       </div>
       <div class="input-box">
       <input type="text" name="password" id="password" placeholder="Enter new Password" required 
       data-parsley-type="password" data-parsley-trigger="keyup" >
       </div>
       </div>
       <div class="form-group">
       <input type="submit" id="login" name="login" value="Submit" class="btn btn-success" />
       </div>
     
       <p class="error">
        <?php if(!empty($msg)){ echo $msg; } ?></p>
     </form>
     </div>
   </div>  
  </div>
</body>
</html>