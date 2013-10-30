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

    if (!isset($_POST['email']) or !isset($_POST['password'])) {
        header('HTTP/1.0 500 Bad Request');
        return;
    }

    $db->addUser($_POST['email'],$_POST['password']);
?>
