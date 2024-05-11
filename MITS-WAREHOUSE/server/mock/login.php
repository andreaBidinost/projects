<?php
session_start();
    
$_SESSION['userName'] = "userProva";
$_SESSION['gender'] = "a";
$_SESSION['userId'] = 88;
echo json_encode(array('success' => true, 'message' => 'Login successful'));


?>
