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
        <input style="display:none" type="file" id="csv-file" accept=".csv">
        <button id="csv-upload">Carica CSV</button>
    </header>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <main>
            <form>
                <label for="product-name">Nome del Prodotto <span class="required-symbol">*</span></label>
                <input type="text" id="product-name" name="product-name" required>

                <label for="quantity">Quantità in ingresso:</label>
                <input type="number" id="quantity" value="1" min="1">

                <label for="photo">Carica una o più foto</label>
                <input type="file" id="photo" name="photo">

                <label for="demo-link">Link Dimostrativo</label>
                <input type="text" id="demo-link" name="demo-link">

                <label for="notes">Note</label>
                <textarea id="notes" name="notes"></textarea>

                <label for="responsible">Responsabile <span class="required-symbol">*</span></label>
                <select id="responsible" name="responsible" required>
                    <option value="responsabile1">Responsabile 1</option>
                    <option value="responsabile2">Responsabile 2</option>
                    <!-- Aggiungi altre opzioni se necessario -->
                </select>

                <label for="available-loan">Disponibile per il prestito <span class="required-symbol">*</span></label>
                <select id="available-loan" name="available" required>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                </select>

                    <label class="loanDetails" for="notes-loan-go">Note per il destinatario prestito</label>
                    <textarea class="loanDetails" id="notes-loan-go" name="notes"></textarea>

                    <label class="loanDetails" for="notes-loan-back">Note per chi gestisce la restituzione</label>
                    <textarea class="loanDetails" id="notes-loan-back" name="notes"></textarea>

                    <label class="loanDetails" for="photo-loan-back">Immagini di dettaglio per la consegna</label>
                    <input class="loanDetails" type="file" id="photo-loan-back" name="photo">
               

                <button class="submit" type="button">Conferma</button>
            </form>
            <!-- Aggiungi la modal -->
            <div id="qrModal" class="modal">
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <div id="qrCode"></div>
                    <div id="productCode"></div>
                    <div id="download-container">
                        <a id="download-link" download><button>Scarica Foto</button></a>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/libraries/qrcode.min.js"></script>
    <script src="./js/newProduct.js"> </script>
</body>

</html>