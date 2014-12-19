<?php
    require_once("connect.php");
	if(isset($_POST['username'])){
		echo "{'msg':'";
		echo $db->checkUsername($_POST['username']);
		echo "'}";
	}