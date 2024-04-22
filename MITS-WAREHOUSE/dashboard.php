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
    <link rel="icon" type="image/x-icon" href="/img/favicon.bmp">
    <title>MITS-WAREHOUSE Dashboard</title>
    <link rel="stylesheet" href="css/manager.css">
</head>

<body>
    <div class="welcome">Benvenut<?php echo $_SESSION["gender"].' '.$_SESSION["user"]  ?></div>
    <div class="container">
        <button id="loanBtn" class="button">
            <img src="img/loan.png" alt="Logo 1" class="logo">
            <span>Prestiti</span>
            <span class="button-description">Gestisci i prestiti del materiale con gli utenti del MITS</span>
        </button>
        <button id="warehouseBtn" class="button">
            <img src="img/warehouse.png" alt="Logo 2" class="logo">
            <span>Magazzino</span>
            <span class="button-description">Aggiungi, rimuovi e visualizza i prodotti del magazzino MITS</span>

        </button>
        <button id="clientBtn" class="button">
            <img src="img/clients.png" alt="Logo 3" class="logo">
            <span>Utenti</span>
            <span class="button-description">Aggiungi, rimuovi e visualizza le operazioni degli utenti MITS</span>

        </button>
        <button id="quitBtn" class="button">
            <img src="img/esci.png" alt="Logo 4" class="logo">
            <span>Esci</span>
            <span class="button-description">Esci dal profilo attuale</span>
        </button>
    </div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="./js/constants.js"> </script> 
  <script src="./js/dashboard.js"> </script>
</body>

</html>