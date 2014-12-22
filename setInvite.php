<?php
    require_once("connect.php");
	if(isset($_POST['email']) && isset($_POST['gameID'])){
		echo "{'msg':'";
		
		$data = $db->setInvite($_POST['email'], $_POST['gameID']);
		echo $data[0]['JoviosID'];
		echo "','email':'";
		echo $_POST['email'];
		
		echo "'}";
	}