<?php
session_start();

if (!(isset($_SESSION["userId"]) && $_SESSION["userId"])) {
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
    <title>MITS-WAREHOUSE Magazzino</title>
    <link rel="stylesheet" href="css/manager.css">
</head>

<body>
    <div class="welcome">
        Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["userName"] ?>
        <?php echo '<inpyt type="hidden" id="userId" value="' . $_SESSION["userId"] . '">' ?></span>
    </div>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <div class="container">
            <button id="newBtn" class="button square-loan">
                <img src="img/loan-new.png" alt="Logo 1" class="logo">
                <span>Nuovo Prestito</span>
                <span class="button-description">Concedi in prestito un prodotto ad un utente ITS</span>
            </button>
            <button id="returnBtn" class="button square-loan">
                <img src="img/ware-upload.png" alt="Logo 2" class="logo">
                <span>Restituzione</span>
                <span class="button-description">Registra la restituzione di un prodotto dato in prestito</span>
            </button>
            <button id="loanHistoryBtn" class="button square-loan">
                <img src="img/ware-view.png" alt="Logo 3" class="logo">
                <span>Storico</span>
                <span class="button-description">Visualizza lo storico dei prestiti</span>

            </button>
            <button id="availableBtn" class="button square-loan">
                <img src="img/loan-available.png" alt="Logo 4" class="logo">
                <span>Disponibilità</span>
                <span class="button-description">Visualizza i prodotti disponibili per il prestito</span>

            </button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/loanManager.js"> </script>
</body>

</html>