<?php
    require_once("connect.php");

    if (!isset($_POST['privateAddress'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    $privateAddress = $_POST['privateAddress'];
    $publicAddress = $_SERVER['REMOTE_ADDR'];
    
    $db->addClient($publicAddress,$privateAddress);

