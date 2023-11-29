<?php

@include 'config.php';

session_start();


if(isset($_POST['submit'])){

   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $pass = mysqli_real_escape_string($conn, $_POST['password']);
   // $pass = md5($_POST['password']); 
   // Hashing the provided password for comparison

   $select = "SELECT * FROM user_form WHERE email = '$email'";
   $result = mysqli_query($conn, $select);

   if(mysqli_num_rows($result) > 0){
      $row = mysqli_fetch_assoc($result);
      
      // Comparing the hashed password from the database
      if($row['password'] === $pass){
         // Perform login actions here
         // setting session variables and redirecting to a dashboard
         $_SESSION['user_id'] = $row['user_id']; 
         $_SESSION['user_name'] = $row['name'];
         header('location: user_page.php'); 
         exit;
      } else {
         $error[] = 'Incorrect email or password!';
      }
   } else {
      $error[] = 'Incorrect email or password!';
   }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login form</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<div class="form-container">

   <form action="" method="post">
      <h3>login now</h3>
      <?php
      if(isset($error)){
         foreach($error as $error){
            echo '<span class="error-msg">'.$error.'</span>';
         };
      };
      ?>
      <input type="email" name="email" required placeholder="enter your email">
      <input type="password" name="password" required placeholder="enter your password">
      <input type="submit" name="submit" value="login now" class="form-btn">
      <p>don't have an account? <a href="register_form.php">register now</a></p>
   </form>

</div>

</body>
</html>