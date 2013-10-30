<?php
    require_once("connect.php");
    
    if (!isset($_POST['email']) or !isset($_POST['display'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    $db->setDisplayName($_POST['email'],$_POST['display']);
