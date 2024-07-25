<?php
session_start();

$SESSION_INACTIVITY_TIME = 900;

if (isset($_SESSION['userId'])) {

    //Read the request time of the user

    $time = $_SERVER['REQUEST_TIME'];


    //Check the user's session exist or not

    if (
        isset($_SESSION['LAST_ACTIVITY']) &&

        ($time - $_SESSION['LAST_ACTIVITY']) > $SESSION_INACTIVITY_TIME
    ) {

        //Unset the session variables

        session_unset();

        //Destroy the session

        session_destroy();

        //Start another new session

        session_start();

    }   
    //Set the time of the user's last activity

    $_SESSION['LAST_ACTIVITY'] = $time;

}
?>