<?php
    require_once("connect.php");

    if (!isset($_POST['id']) or !isset($_POST['property'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    if (isset($_POST['value'])) {
        $db->setProperty($_POST['id'],$_POST['property'],$_POST['value']);
    } else {
        echo $db->getProperty($_POST['id'],$_POST['property']);
    }

