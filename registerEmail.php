<?php
    require_once("connect.php");
	if(isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])){
		echo "{'msg':";
		echo $db->registerEmail($_POST['email'], $_POST['username'], $_POST['password']);
		echo "}";
	}