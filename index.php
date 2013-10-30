<?php
    require_once("connect.php");
    
    $db = new DB();
    $db->connect($ip,$username,$password,"test");

    if (isset($_GET['reset'])) $db->resetDatabase(); //TODO make this more production oriented
    
    $users = $db->getUsers();
    foreach ($users as $user) {
        unset($user['passwordhash']);
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        //echo "<div><b>$user[email]</b>: $user[created]</div>";
    }
?>
