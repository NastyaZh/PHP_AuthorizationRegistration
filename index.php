<?php

if (!empty($_COOKIE['sid'])) {
    // check session id in cookies
    session_id($_COOKIE['sid']);
}
session_start();
require_once 'api/classes/SessionWorker.class.php';
?>

<!DOCTYPE html>
<html lang='en'>
<head>
<title>My new site</title>
<meta charset="utf-8">
<link rel='stylesheet' href='asserts/css/style.css'>

</head>
<body>
  
    <?php if (SessionWorker::isAuthorized()): ?>
      <div class='container'>
        <h1>Hello <?php echo SessionWorker::getNameFromSession()?></h1>
        <form class="ajax" method="post" action="./ajax.php">
          <input type="hidden" name="act" value="logout">
          <div class="form-actions">
            <button class="registerbtn" type="submit">Logout</button>
          </div>
        </form>
      </div>
    
    <?php else: ?>
      <form action='./ajax.php' method='post' class='form-signin ajax container'>
        <h1>Authorization</h1>
        <p>Please fill in this form to sign in.</p>
        <div class="main-error error hide"></div>
        <hr>
      
        <label for='loginAuth'><b>Login</b></label>
        <input type='text' placeholder='Enter login' name='loginAuth' class='loginAuth' autofocus> 
        <div class="loginAuthError error hide"></div>
        <hr>
      
        <label for='passwordAuth'><b>Password</b></label>
        <input type='password' placeholder='Enter Password' name='passwordAuth'class='passwordAuth'>
        <div class="passwordAuthError error hide"></div>
        <hr>

        <input type="hidden" name="act" value="login">
        <button type='submit' class ='registerbtn' >Sign in</button>
      
        <div class='signin'>
          <p>New to My site? <a href='/registration.php'>Create an account.</a>.</p>
        </div>
      </form>
    <?php endif; ?>

    <script src="asserts/js/vendor/jquery-2.0.3.min.js"></script>
    <script src="asserts/js/ajax-form.js"></script>
</body>
</html>