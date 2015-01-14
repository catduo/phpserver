<?php
    require_once("connect.php");
	if(isset($_POST['joviodID']) && isset($_POST['deviceType']) && isset($_POST['deviceInfo'])){
    	echo "{'msg':[";
		echo"{";
		echo "'GameID':";
		echo $game['GameID'];
		echo ",'GameState':";
		
		$data = $db->loadGame($_POST['gameID']);
		echo $data[0]['gameState'];
		
		echo"}";
		echo "]}";
	}