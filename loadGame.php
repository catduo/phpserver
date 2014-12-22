<?php
    require_once("connect.php");
	if(isset($_POST['joviodID']) && isset($_POST['deviceType']) && isset($_POST['deviceInfo'])){
		$data = $db->saveGame($_POST['joviodID'], $_POST['deviceType'], $_POST['deviceInfo']);
		echo $data[0]['gameState'];
	}