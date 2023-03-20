<?php

if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
  session_start();
  $_SESSION['username'] = $_COOKIE['username'];
  $_SESSION['password'] = $_COOKIE['password'];
  header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<?php include("header.php");?>  
    <link rel="stylesheet" href="css/login.css">
    <script src="js/app_login.js"></script>
    <title>PetFlix</title>
</head>
<body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form method="POST" action="server/authentication.php" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
            </div>
            <?php
                session_start();
                if($_SESSION['loginError']){
                  $_SESSION['loginError'] = false;
                  ?>
                  <span style="color: red;">email o password errati</span>
                  <?php
                }
            ?>
            <input type="submit" value="Login" class="btn solid" />
          </form>
          <form method="POST" action="server/registration.php" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="username" placeholder="Username" />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" />
            </div>
            <?php
              //TODO: controllo errori di registrazione
            ?>
            <input type="submit" class="btn" value="Sign up" />
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>New here ?</h3>
            <p>
              Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
              ex ratione. Aliquid!
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="images/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>One of us ?</h3>
            <p>
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
              laboriosam ad deleniti.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="images/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>

  </body>
</html>