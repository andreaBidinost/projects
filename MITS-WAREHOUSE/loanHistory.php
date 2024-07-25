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
    <link rel="stylesheet" href="css/details.css">
</head>

<body>
    <header>
        <span>Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["userName"] ?></span>
        <?php echo '<inpyt type="hidden" id="userId" value="' . $_SESSION["userId"] . '">' ?></span>

    </header>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <main>
            <h1>Storico Prestiti</h1>
            <span class="list-header">
                <div>
                    <div> <span>Data inizio</span> &rarr; <span>Data fine</span></div>
                    <div>Destinatario</div>
                    <div> n. pezzi</div>
                    <div> Stato</div>
                    <div>Dettagli</div>
                </div>
            </span>
            <ul id="loanList" class="loan-list"></ul>
            

            <div id="loanDetailsModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <h2>Dettagli Prestito</h2>
                    <div id="loanDetails"></div>
                </div>
            </div>

            <div id="loadingWheelArea" class="modal">
                <div id="loadingSpinner" class="spinner"></div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/loanHistory.js"> </script>
</body>