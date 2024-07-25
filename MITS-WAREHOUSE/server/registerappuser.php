<?php
include 'dbCredentials.php';
$dbCredentials = 'dbCredentials';


// Creare connessione
$conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);

// Controllare connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica che i parametri GET siano settati
if (isset($_GET['id']) &&isset($_GET['username']) && isset($_GET['password'])) {
    $id = $_GET['id'];
    $user = $_GET['username'];
    $pass = $_GET['password'];

    // Hash della password
    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);

    // Prepara la query per inserire il nuovo utente
    $sql = "INSERT INTO appusers (id_mitsuser, username, password) VALUES (?,?, ?)";
    
    // Usa una dichiarazione preparata per prevenire SQL injection
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iss", $id, $user, $hashed_password);
        
        // Esegui la query
        if ($stmt->execute()) {
            echo "Registrazione riuscita!";
        } else {
            echo "Errore: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        echo "Errore nella preparazione della query: " . $conn->error;
    }
} else {
    echo "Parametri username e password mancanti.";
}

$conn->close();
?>
