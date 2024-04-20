<?php
include 'dbCredentials.php';
$dbCredentials = 'dbCredentials';

/*
// Create connection
$conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if the username and password match
$sql = "SELECT username FROM users WHERE username='$username' AND password=PASSWORD('$password')";
$result = $conn->query($sql);

// Check if there is a match
if ($result->num_rows > 0 || true) {
    // Username and password are correct
    echo json_encode(array('success' => true, 'message' => 'Login successful'));
    session_start();
    
    $_SESSION['user'] = $row["username"];
} else {
    // Username and/or password are incorrect
    echo json_encode(array('success' => false, 'message' => 'Incorrect username or password'));
}

// Close connection
$conn->close();
*/

session_start();
    
$_SESSION['user'] = "userProva";
$_SESSION['gender'] = "a";
echo json_encode(array('success' => true, 'message' => 'Login successful'));


?>
