<?php
session_start();
    
$_SESSION['user'] = "userProva";
$_SESSION['gender'] = "a";
echo json_encode(array('success' => true, 'message' => 'Login successful'));


?>
