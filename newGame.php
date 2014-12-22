<?php
    require_once("connect.php");
	if(isset($_POST['gameName'])){
		echo "{'msg':'";
		echo $db->newGame($_POST['gameName']);
		echo "'}";
	}