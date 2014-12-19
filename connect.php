<?php
    require_once("secret.php");
    require_once("db.php");

    $db = new DB();
    $db->connect($ip,$username,$password,"games");
