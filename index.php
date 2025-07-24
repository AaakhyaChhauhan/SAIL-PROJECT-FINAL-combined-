<?php
session_start();
if (isset($_SESSION['username'])) {
  header("Location: dashboard.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login | Vendor System</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      display: flex;
      height: 100vh;
    }
    .left {
      flex: 1;
      background-image: url('banner.jpg');
      background-size: cover;
      background-position: center;
    }
    .right {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #f7f7f7;
    }
    form {
      background: #fff;
      padding: 30px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
      width: 300px;
      border-radius: 8px;
    }
    h2 {
      text-align: center;
    }
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
    }
    input[type="submit"] {
      width: 100%;
      background: #007bff;
      color: white;
      padding: 10px;
      border: none;
      cursor: pointer;
    }
    .register {
      text-align: center;
      margin-top: 15px;
    }
  </style>
</head>
<body>

<div class="left"></div>

<div class="right">
  <form method="POST" action="login.php">
    <h2>Login</h2>
    <?php if (isset($_GET['error'])) { echo "<p style='color:red;'>".$_GET['error']."</p>"; } ?>
    <label>Username:</label>
    <input type="text" name="username" required>
    <label>Password:</label>
    <input type="password" name="password" required>
    <input type="submit" value="Login">
    <div class="register">
      Don't have an account? <a href="register.php">Register</a>
    </div>
  </form>
</div>

</body>
</html>
