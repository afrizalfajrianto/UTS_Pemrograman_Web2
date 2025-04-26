<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login Form - SQL Injection Demo</title>
</head>
<body>

<h2>Form Login</h2>
<form method="post" action="login.php">
  <label>Username:</label><br>
  <input type="text" name="username" required><br><br>
  
  <label>Password:</label><br>
  <input type="password" name="password" required><br><br>
  
  <input type="submit" value="Login">
</form>

<?php
// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "demo");

// Cek koneksi
if (!$conn) {
  die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Ambil data dari input
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Gunakan prepared statement (aman)
  $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
  $stmt->bind_param("ss", $username, $password);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    echo "<p style='color:green;'>Login berhasil!</p>";
  } else {
    echo "<p style='color:red;'>Login gagal.</p>";
  }

  $stmt->close();
}

mysqli_close($conn);
?>

</body>
</html>
