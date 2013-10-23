<?php
    include('secret.php');
    function handlePostAction($conn) {
        $action = $_POST["action"];
        if ($action == "create") {
            $name = $_POST["name"];
            $now = date( 'Y-m-d H:i:s');
            mysqli_query($conn,"INSERT INTO information VALUES ('$name','$now')");
        }
    }

    function handleGetAction($conn) {
        $action = $_GET["action"];
        if ($action == "list") {
            $result = mysqli_query($conn,"SELECT * FROM information");
            $data = mysqli_fetch_all($result,MYSQLI_ASSOC);
            echo "<pre>";
            print_r($data);
        }
    }

    $conn = mysqli_connect($ip, $username, $password) or die(mysql_error());
    if (isset($_GET['setup'])) {
        mysqli_query($conn,"DROP DATABASE test");
        mysqli_query($conn,"CREATE DATABASE test");
        mysqli_select_db($conn,"test");
        mysqli_query($conn,"CREATE TABLE information (gamename VARCHAR(255),date DATETIME)");
    } else {
        mysqli_select_db($conn,"test");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        handlePostAction($conn);
    } else if ($_SERVER['REQUEST_METHOD'] == "GET") {
        handleGetAction($conn);
    }
    
    mysqli_close($conn);
?>
