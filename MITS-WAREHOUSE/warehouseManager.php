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
    <title>MITS-WAREHOUSE Magazzino</title>
    <link rel="stylesheet" href="css/manager.css">
</head>

<body>
    <div class="welcome">Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["user"] ?></div>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <div class="container">
            <button id="newBtn" class="button">
                <img src="img/ware-newProduct.png" alt="Logo 1" class="logo">
                <span>Nuovo Prodotto</span>
                <span class="button-description">Aggiungi un prodotto non presente nel magazzino MITS</span>
            </button>
            <button id="uploadBtn" class="button">
                <img src="img/ware-upload.png" alt="Logo 2" class="logo">
                <span>Carica</span>
                <span class="button-description">Aggiungi i nuovi arrivi dei prodotti già presenti nel magazzino
                    MITS</span>
            </button>
            <button id="downloadBtn" class="button">
                <img src="img/ware-download.png" alt="Logo 3" class="logo">
                <span>Scarica</span>
                <span class="button-description">Rimuovi prodotti già presenti nel magazzino MITS</span>

            </button>
            <button id="viewBtn" class="button">
                <img src="img/ware-view.png" alt="Logo 4" class="logo">
                <span>Visualizza</span>
                <span class="button-description">Visualizza e ricerca i prodotti del magazzino MITS</span>

            </button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/warehouse.js"> </script>
</body>

</html>