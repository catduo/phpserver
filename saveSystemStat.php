<?php
    require_once("connect.php");
	if(isset($_POST['deviceID']) && isset($_POST['species'])){
		echo "{'msg':'";
		echo $db->saveGame($_POST['deviceID'], $_POST['domain'], $_POST['kingdom'], $_POST['phylum'], $_POST['order'], $_POST['statClass'], $_POST['familiy'], $_POST['genus'], $_POST['species']);
		echo "'}";
	}