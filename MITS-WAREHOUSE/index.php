<?php
session_start();

if (isset($_SESSION["user"]) && $_SESSION["user"]){
  header("Location: /dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div class="container">
    <img src="img/logoITS.png" alt="Logo" class="logo">
    <form action="#">
      <h2>Gestione materiale</h2>
      <div class="input-container">
        <input type="text" id="username" required>
        <label for="username">Username</label>
      </div>
      <div class="input-container">
        <input type="password" id="password" required>
        <label for="password">Password</label>
      </div>
      <button type="button" id="loginBtn">Login</button>
    </form>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/index.js"> </script>
</body>
</html>
