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
    <title>Inserimento Dati</title>
    <link rel="stylesheet" href="css/newProduct.css">
</head>

<body>
    <header>
        <span>Benvenut<?php echo $_SESSION["gender"] . ' ' . $_SESSION["user"] ?></span>
        <button id="csv-upload">Carica CSV</button>
    </header>
    <div class="back-and-container">
        <button id="goBackBtn" class="back-button">&lt;&lt;</button>
        <main>
            <form action="cioccolatini.php" method="POST" enctype="multipart/form-data">
                <label for="product-name">Nome del Prodotto <span class="required-symbol">*</span></label>
                <input type="text" id="product-name" name="product-name" required>

                <label for="photo">Foto</label>
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

                <label for="available">Disponibile per il prestito <span class="required-symbol">*</span></label>
                        <select id="available" name="available" required>
                            <option value="si">SI</option>
                            <option value="no">NO</option>
                        </select>

                        <button class="submit" type="button">Conferma</button>
            </form>
        </main>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/newProduct.js"> </script>
</body>

</html>