<?php
include 'dbCredentials.php';
$dbCredentials = 'dbCredentials';


// Creare connessione
$conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

$firstName = isset($_GET['firstName']) ? $_GET['firstName'] : '';
$lastName = isset($_GET['lastName']) ? $_GET['lastName'] : '';
$role = isset($_GET['role']) ? $_GET['role'] : '';

$sql = "SELECT users.firstName, users.lastName, roles.name as role 
        FROM users 
        JOIN roles ON users.role_id = roles.id 
        WHERE users.firstName LIKE '%$firstName%' 
        AND users.lastName LIKE '%$lastName%'";

if ($role) {
    $sql .= " AND roles.id = $role";
}

$result = $conn->query($sql);

$users = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();

echo json_encode($users);
?>