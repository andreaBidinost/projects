<?php
session_start();

if (!(isset($_SESSION["user"]) && $_SESSION["user"])) {
    echo "<script>alert('Sessione scaduta, autenticazione necessaria');</script>";
    header("Location: /index.php");
}
?>
hello!