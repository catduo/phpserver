<?php
    require_once("connect.php");
	if(isset($_POST['gameName']) && isset($_POST['gameID']) && isset($_POST['saveData'])){
		echo "{'msg':'";
		echo $db->saveGame($_POST['gameName'], $_POST['gameID'], $_POST['saveData']);
		echo "'}";
	}