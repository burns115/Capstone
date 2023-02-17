<?php
    session_start();

    function isPostRequest() {
        return ( filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST' );
    }

    if($_SESSION['loggedIn'] == FALSE OR !isset($_SESSION['loggedIn'])){
        header('Location: login.php');
    }
?>