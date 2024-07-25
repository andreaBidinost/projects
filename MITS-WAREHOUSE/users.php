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
    <title>Utenti</title>
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
            <div class="container">
                <h1>Utenti Iscritti</h1>
                <div class="filters">
                    <input type="text" id="firstNameFilter" placeholder="Nome">
                    <input type="text" id="lastNameFilter" placeholder="Cognome">
                    <select id="roleFilter">
                        <option value="">Tutti i Ruoli</option>
                    </select>
                    <button id="filterButton">Filtra</button>
                </div>
                <div id="userList" class="user-list"></div>
            </div>

        </main>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./js/constants.js"> </script>
    <script src="./js/mitsAlert.js"> </script>
    <script src="./js/spinner.js"> </script>
    <script src="./js/users.js"> </script>
</body>