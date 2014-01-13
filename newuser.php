<?php
    require_once("connect.php");

    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        echo "<form method='post'>";
        echo "<input type='submit'><br/>";
        echo "</form>";
        return;
    }
    
    $db = new DB();
    $db->connect($ip,$username,$password,"test");

    $userID = $db->newUser();;
    echo $userID;
?>
