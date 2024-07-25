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
    <title>Storico prestiti</title>
    <link rel="stylesheet" href="css/dataEntry.css">
</head>

<body>
    <header>
        <span>Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["userName"] ?></span>
        <?php echo '<inpyt type="hidden" id="userId" value="' . $_SESSION["userId"] . '">' ?></span>

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
            <div class="comeBackBrwSel">
            <label for="borrower">Seleziona il destinatario:</label>
            <select id="borrower"></select>
            </div>
            <hr>
            <form>
                <div class="advice">Controlla nella nuova scheda lo stato del materiale</div>
                <input type="hidden" id="loanId" disabled>
                <label>Prodotto seleizonato:</label>

                <div class="selProductInfo">
                    <input type="hidden" id="selProductId" disabled>
                    <input type="text" id="selProductCode" disabled>
                    <input type="text" id="selProductDesc" disabled>
                </div>

                <label for="quantity">Quantità prestata:</label>
                <input type="number" id="quantity" value="1" min="1">                

                <label for="startDate">Data inizio prestito:</label>
                <input type="date" id="startDate">

                <label for="endDate">Data inizio prestito:</label>
                <input type="date" id="endDate">

                <label for="responsible">Responsabile:</label>
                <input type="text" id="responsible">

                <button class="submit" id="confirmComeBack">Conferma restituzione</button>
            </form>

            <!-- Aggiungi la modal -->
            <div id="productModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="selectByQrBox" class="productSelectionBox">
                        <div id="qrreader"></div>
                    </div>
                    <div id="selectByCodeBox" class="productSelectionBox">
                        <input type="text" id="selPCode" placeholder="Inserisci il codice del prodotto">
                        <button type="button" id="confirmSelByCode">Conferma</button>
                    </div>
                    <div id="selectByNameBox" class="productSelectionBox">
                        <input type="text" id="selPName"
                            placeholder="Inserisci delle parole per descrivere il prodotto">
                        <button type="button" id="confirmSelByName">Cerca</button>
                        <div id="selByNameResult"></div>
                    </div>
                </div>
            </div>

            <div id="confirmLoanModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="comeBackmsg" class="confirmMsg">
                        <p><b>Il prestito è stato chiuso</b></p>
                        <p>Si verrà reindirizzati alla pagina di gestione prestiti</p>
                    </div>
                </div>
            </div>

            <div id="loadingWheelArea" class="modal">
                <div id="loadingSpinner" class="spinner"></div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    
    <script src="./js/libraries/qrcode-scan.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/returnLoan.js"> </script>
</body>