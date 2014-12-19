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

    if (!isset($_POST['email']) or !isset($_POST['password'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    $auth = $db->authenticate($_POST['email'],$_POST['password']);
    if ($auth) {
        header('HTTP/1.0 200 OK');
    } else {
        header('HTTP/1.0 401 Unauthorized');
    }
?>
