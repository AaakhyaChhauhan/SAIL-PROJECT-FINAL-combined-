<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role']; // 'admin' or 'vendor'

  $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $username, $password, $role);

  if ($stmt->execute()) {
    echo "Registered successfully. <a href='index.php'>Login now</a>";
  } else {
    echo "Error: " . $stmt->error;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="login-container">
    <h2>Register</h2>
    <form method="post">
      <input type="text" name="username" placeholder="Username" required /><br>
      <input type="password" name="password" placeholder="Password" required /><br>
      <select name="role" required>
        <option value="">Select Role</option>
        <option value="vendor">Vendor</option>
        <option value="admin">Admin</option>
      </select><br>
      <button type="submit">Register</button>
    </form>
    <p>Already registered? <a href="index.php">Login</a></p>
  </div>
</body>
</html>
