<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="index.css" />
</head>

<body>
  <div class="container">
    <?php
    require_once ('dbConnection.php');
    $errorMessage = '';
    $successMessage = '';

    if (isset($_POST['login'])) {
      $email = $_POST['email'];
      $password = $_POST['password'];

      try {
        $stmt = $pdo->prepare("SELECT email, password FROM registration WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_OBJ);

        if ($user) {
          if ($password == $user->password) {
            $successMessage = "<div class='alert'>
                                 <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                                 Login successful!
                               </div>
                               <script>
                                 setTimeout(function() {
                                   window.location.href = 'index.php';
                                 }, 4000);
                               </script>";
          } else {
            $errorMessage = "<div class='alert-error'>
                                <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                                Password is incorrect.
                             </div>";
          }
        } else {
          $errorMessage = "<div class='alert-error'>
                              <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                              Email is incorrect.
                           </div>";
        }
      } catch (Exception $e) {
        $errorMessage = "<div class='alert-error'>
                            <span class='closebtn' onclick=\"this.parentElement.style.display='none';\">&times;</span>
                            Error: " . $e->getMessage() . "
                          </div>";
      }
    }
    ?>
    <div class="left">
      <?php echo $errorMessage; ?>
      <?php echo $successMessage; ?>
      <div class="header">
        <h2 class="animation a1">Welcome Back</h2>
        <h4 class="animation a2">Log in to your account using email and password</h4>
      </div>
      <form class="form" method="post">
        <input type="email" class="form-field animation a3" placeholder="Email Address" name="email" required>
        <input type="password" class="form-field animation a4" placeholder="Password" name="password" required>
        <p class="animation a5"><a href="register.php">New User? Register Here</a></p>
        <button type="submit" class="animation a6" name="login">LOGIN</button>
      </form>
    </div>
    <div class="right"></div>
  </div>
</body>

</html>