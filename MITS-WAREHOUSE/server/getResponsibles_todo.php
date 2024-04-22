<?php
// Connessione al database (da sostituire con i tuoi dati)
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "nome_database";

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Query per ottenere l'elenco dei responsabili dal database (da personalizzare)
$sql = "SELECT nome_responsabile FROM responsabili";
$result = $conn->query($sql);

$responsibles = array();

// Se ci sono risultati dalla query
if ($result->num_rows > 0) {
    // Itera sui risultati e aggiungi i responsabili all'array
    while($row = $result->fetch_assoc()) {
        $responsibles[] = $row["nome_responsabile"];
    }
}

// Chiudi la connessione al database
$conn->close();

// Restituisci l'elenco dei responsabili come dati JSON
echo json_encode($responsibles);
?>
