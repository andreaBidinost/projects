<?php
session_start();

if (!(isset($_SESSION["user"]) && $_SESSION["user"])) {
    echo "<script>alert('Sessione scaduta, autenticazione necessaria');</script>";
    header("Location: /index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>
    <div class="welcome">Benvenut<?php echo $_SESSION["gender"].' '.$_SESSION["user"]  ?></div>
    <div class="container">
        <button id="loanBtn" class="button">
            <img src="img/loan.png" alt="Logo 1" class="logo">
            <span>Prestiti</span>
        </button>
        <button class="button">
            <img src="img/warehouse.png" alt="Logo 2" class="logo">
            <span>Magazzino</span>
        </button>
        <button class="button">
            <img src="img/clients.png" alt="Logo 3" class="logo">
            <span>Utenti</span>
        </button>
        <button id="quitBtn" class="button">
            <img src="img/esci.png" alt="Logo 4" class="logo">
            <span>Esci</span>
        </button>
    </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/dashboard.js"> </script>
</body>

</html>