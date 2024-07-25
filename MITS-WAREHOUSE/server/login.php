<?php
include 'dbCredentials.php';
include 'constants.php';
include 'sessionManager.php';

$dbCredentials = 'dbCredentials';

// Create connection
$conn = new mysqli($dbCredentials::SERVERNAME, $dbCredentials::USERNAME, $dbCredentials::PASSWORD, $dbCredentials::DBNAME);

// Check connection
if ($conn->connect_error) {
    array('success' => false, 'errmsg' => 'Login failed: ' . $conn->connect_error, 'errcode' => ERRNO_DBMS_LOGIN_FAILED);
    return;
}

// Get the username and password from the POST request
$username = $_POST['username'];
$password = $_POST['password'];

// Query to check if the username and password match
$sql = "SELECT id_mitsuser, password, genderLastLetter FROM appusers WHERE username = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $username);

    $stmt->execute();

    $stmt->store_result();

    if ($stmt->num_rows > 0) {

        $stmt->bind_result($appuserId, $hashed_password, $genderLastLetter);
        $stmt->fetch();

        // Verifica la password
        if (password_verify($password, $hashed_password)) {
            echo json_encode(array('success' => true, 'message' => 'Login DBMS successful'));

            $_SESSION['userId'] = $appuserId;
            $_SESSION['userName'] = $username;
            $_SESSION['gender'] = $genderLastLetter;
        } else {
            array('success' => false, 'errmsg' => 'Login failed: ' . $conn->connect_error, 'errcode' => ERRNO_DBMS_LOGIN_PWD_NOT_FOUND);
        }
    } else {
        array('success' => false, 'errmsg' => 'Login failed: ' . $conn->connect_error, 'errcode' => ERRNO_DBMS_NO_USER);
    }

    $stmt->close();
}
$conn->close();
?>