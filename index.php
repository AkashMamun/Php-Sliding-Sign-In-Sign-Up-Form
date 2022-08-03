<?php
include 'config.php';

session_start();
error_reporting(0);
if (isset($_SESSION['user_id'])) {
  header("Location:wellcome.php");
}

if (isset($_POST['signup'])) {
  $full_name = mysqli_real_escape_string($conn, $_POST['name']);
  $email     = mysqli_real_escape_string($conn, $_POST['email']);
  $password  = mysqli_real_escape_string($conn, md5($_POST['password']));
  $cpassword  = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

  $check_email = mysqli_num_rows(mysqli_query($conn, "SELECT  email FROM users WHERE email = '$email'"));

  if ($password !== $cpassword) {
    echo "<script>alert('Password did not match.');</script>";
  } elseif ($check_email > 0) {
    echo "<script>alert('E-mail already exist in our database.');</script>";
  } else {
    $sql = "INSERT INTO users(full_name,email,password) VALUES('$full_name','$email','$password')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $_POST['name'] = "";
      $_POST['email'] = "";
      $_POST['password'] = "";
      $_POST['cpassword'] = "";

      echo "<script>alert('User Registration successfully.');</script>";
    } else {
      echo "<script>alert('User Registration failed.');</script>";
    }
  }
}
if (isset($_POST['signin'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password  = mysqli_real_escape_string($conn, md5($_POST['password']));


  $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email' AND password='$password' ");

  if (mysqli_num_rows($check_email) > 0) {

    $row = mysqli_fetch_assoc($check_email);
    $_SESSION['user_id'] = $row['id'];
    header("Location: wellcome.php");
  } else {
    echo "<script>alert('Login details is incorrct.Please try again.');</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css" />
  <title>Sign in & Sign up Form</title>
</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">

        <form action="#" method="post" class="sign-in-form">
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="E-mail address" name="email" value="<?php echo $_POST['email']; ?>" required />
          </div>
          <div class=" input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required />
          </div>
          <input type="submit" name="signin" value="Login" class="btn solid" />
          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>

        <!-------sign-up-form------->

        <form action="#" class="sign-up-form" method="post">
          <h2 class=" title">Sign up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Fullname" name="name" value="<?php echo $_POST['name']; ?>" required />
            <i class="fas fa-user"></i>
          </div>
          <div class=" input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" value="<?php echo $_POST['email']; ?>" required />
            <i class="fas fa-user"></i>
          </div>
          <div class=" input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required />
          </div>
          <div class=" input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required />
          </div>
          <input type="submit" name="signup" class="btn" value="Sign up" />

          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
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
        <img src="img/log.svg" class="image" alt="" />
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
        <img src="img/register.svg" class="image" alt="" />
      </div>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>