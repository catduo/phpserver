<?php
    require_once("connect.php");
    
    $db = new DB();
    $db->connect($ip,$username,$password,"test");

    if (isset($_GET['reset'])) $db->resetDatabase(); //TODO make this more production oriented
    
    $users = $db->getUsers();
    foreach ($users as $user) {
        echo "<div><b>$user[username]</b>: $user[created]</div>";
    }
?>
