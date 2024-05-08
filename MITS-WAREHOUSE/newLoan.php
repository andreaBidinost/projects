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
    <title>Inserimento Dati</title>
    <link rel="stylesheet" href="css/dataEntry.css">
</head>

<body>
    <header>
        <span>Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["user"] ?></span>
    </header>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <main>
            <label>Seleziona il prodotto:</label>
            <div id="productSelectionMode">
                <button id="prSelByQr" type="button">Carica una foto</button>
                <button id="prSelByCode" type="button">Cerca con codice</button>
                <button id="prSelByName" type="button">Cerca con nome</button>
            </div>
            <div id="productSelectionBox">
                <div id="selectByQrBox">
                    <div id="qrreader"></div>
                </div>
                <div id="selectByCodeBox"></div>
                <div id="selectByNameBox"></div>
            </div>
            <form>
                <label for="product">Prodotto seleizonato:</label>
                <input type="text" id="product" disabled>
                
                <label for="quantity">Quantità prestata:</label>
                <input type="number" id="quantity" value="1" min="1">

                <label for="borrower">Utente:</label>
                <select id="borrower"></select>

                <label for="startDate">Data inizio prestito:</label>
                <input type="date" id="startDate">

                <label for="duration">Durata prevista (giorni):</label>
                <input type="number" id="duration" value="1" min="1">

                <label for="responsible">Responsabile:</label>
                <select id="responsible"></select>

                <button class="submit" onclick="saveLoan()">Salva Prestito</button>
            </form>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/libraries/qrcode-scan.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/newLoan.js"> </script>
</body>