<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="forgot-pw.css">
  <link href="../image/2.png" rel="icon">
</head>
<body>
 
  <div class="forgot-password-container">
    <h2>Forgot Password</h2>
    <p>Masukkan email Anda untuk mendapatkan tautan reset password.</p>
    <form action="#" method="POST">
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
      
      <button type="submit">Kirim Link Reset</button>
    </form>

    <div class="back-link">
      <a href="login.php">Kembali ke Login</a>
    </div>
  </div>

</body>
</html>
