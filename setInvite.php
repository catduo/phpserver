<?php
    require_once("connect.php");
	if(isset($_POST['email']) && isset($_POST['gameID'])){
		echo "{'msg':'";
		echo $db->setInvite($_POST['email'], $_POST['gameID']);
		echo "'}";
	}