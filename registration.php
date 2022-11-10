<?php

if (!empty($_COOKIE['sid'])) {
    session_id($_COOKIE['sid']);
}
session_start();
require_once 'api/classes/SessionWorker.class.php';
?>

<!DOCTYPE html>
<head>
<title>My new site</title>
<meta charset="utf-8">
<title>registration form</title>
<link rel='stylesheet' href='asserts/css/style.css'>

</head>
<body>


<?php if (SessionWorker::isAuthorized()): ?>
  <div class='container'>
    <h1>Your are already registered!</h1>

    <form class="ajax" method="post" action="./ajax.php">
        <input type="hidden" name="act" value="logout">
        <div class="form-actions">
          <button class="registerbtn" type="submit">Logout</button>
        </div>
    </form>
  </div>
    <?php else: ?>


    <form action='./ajax.php' method='post' class='form-signin ajax container' novalidate>
      <h1>Register</h1>
      <p>Please fill in this form to create an account.</p>
      <div class="main-error error hide"></div>
      <hr>
      
      <label for='loginReg'><b>Login</b></label>
      <input type='text' placeholder='Enter login' name='loginReg' class='loginReg' autofocus>
      <div class="loginRegError error hide"></div>
      <hr>
      
      <label for='passwordReg'><b>Password</b></label>
      <input type='password' placeholder='Enter Password' name='passwordReg'class='passwordReg'>
      <div class="passwordRegError error hide"></div>
      <hr>
      
      <label for='confPassReg'><b>Confirm password</b>
      <input type='password' placeholder='Confirm password' name='confPassReg'class='confPassReg'>
      <div class="confPassRegError error hide"></div>
      <hr>
      
      <label for='emailReg'><b>Email</b></label>
      <input type='text' placeholder='Enter Email' name='emailReg'class='emailReg'>
      <div class="emailRegError error hide"></div>
      <hr>
      
      <label for='nameReg'><b>Name</b></label>
      <input type='text' placeholder='Enter name' name='nameReg'class='nameReg'>
      <div class="nameRegError error hide"></div>
      <hr>
      
      <input type="hidden" name="act" value="register">
      <button type='submit' class='registerbtn' >Register</button>
      
      <div class='signin'>
        <p>Already have an account? <a href='/index.php'>Sign in</a>.</p>
      </div>
    </form>

    <?php endif; ?>

    <script src="asserts/js/vendor/jquery-2.0.3.min.js"></script>
    <script src="asserts/js/ajax-form.js"></script>
</body>
</html>