<?php
    require_once("connect.php");
	if(isset($_POST['gameName']) && isset($_POST['deviceID']) && isset($_POST['species'])){
		echo "{'msg':'";
		echo $db->saveGame($_POST['deviceID'], $_POST['gameName'], $_POST['domain'], $_POST['kingdom'], $_POST['phylum'], $_POST['order'], $_POST['statClass'], $_POST['family'], $_POST['genus'], $_POST['species']);
		echo "'}";
	}
	else{
		echo "post parameters not properly set";
	}
	if(isset($_POST['gameName'])){
		echo $_POST['gameName'];
	}
