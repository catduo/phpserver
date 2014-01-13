<?php
    require_once("connect.php");

    if ($_SERVER['REQUEST_METHOD'] != "POST") {
        echo "<form method='post'>";
        echo "<input type='text' name='email'><br/>";
        echo "<input type='password' name='password'><br/>";
        echo "<input type='submit'><br/>";
        echo "</form>";
        return;
    }
    
    $db = new DB();
    $db->connect($ip,$username,$password,"test");

    $auth = $db->newUser();;
    echo $auth;
?>
