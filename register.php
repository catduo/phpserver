<?php
    require_once("connect.php");

    if (!isset($_POST['username']) or !isset($_POST['password'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    $db->addUser($_POST['username'],$_POST['password']);
?>
