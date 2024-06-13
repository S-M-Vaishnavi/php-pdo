<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="index.css"/>
</head>
<body>
    
<div class="container">
<?php
    $passwordError = '';
    $emailError = '';
    $successMessage = '';

    if(isset($_POST['submit'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        if($password != $confirm_password){
            $passwordError = "<p class='error animation a5'>Password does not match</p>";
        } elseif(strlen($password) < 8){
            $passwordError = "<p class='error animation a5'>Password must be at least 8 characters</p>";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailError = "<p class='error animation a5'>Invalid email address</p>";
        }

        if(empty($passwordError) && empty($emailError)){
            try{
                require_once("dbConnection.php");
                $insertQuery = "INSERT INTO registeration (name, email, password) VALUES (:name, :email, :password)";
                $stmt = $pdo->prepare($insertQuery);

                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);

                if($stmt->execute()){
                    $successMessage = "<div class='alert'>
                                        <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                                        Registration successful!
                                       </div>";
                } else {
                    $successMessage = "<div class='alert'>
                                        <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                                        Error in executing statement.
                                       </div>";
                }
            } catch (Exception $e){
                $successMessage = "<div class='alert'>
                                    <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                                    Error: " . $e->getMessage() . "
                                   </div>";
            }
        }
    }
?>
  <div class="left">
  <?php echo $successMessage; ?>
    <div class="header">
      <h2 class="animation a1">Register Here</h2>
    </div>
    <form class="form" method="post">
      <input type="text" class="form-field animation a3" placeholder="Your Name" name="name" required>
      <input type="email" class="form-field animation a3" placeholder="Email Address" name="email" required>
      <?php echo $emailError; ?>
      <input type="password" class="form-field animation a4" placeholder="Password" name="password" required>
      <input type="password" class="form-field animation a4" placeholder="Confirm Password" name="confirm_password" required>
      <?php echo $passwordError; ?>
      <p class="animation a5"><a href="login.php">Already Registered? Login Here</a></p>
      <button class="animation a6" type="submit" name="submit">REGISTER</button>
    </form>
  </div>
  <div class="right"></div>
</div>
</body>
</html>
