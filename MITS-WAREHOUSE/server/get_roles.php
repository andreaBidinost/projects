<?php
include 'dbCredentials.php';
$dbCredentials = 'dbCredentials';


// Creare connessione
$conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$sql = "SELECT id, description FROM roles";
$result = $conn->query($sql);

$roles = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

$conn->close();

echo json_encode($roles);
?>