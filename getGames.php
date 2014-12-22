<?php
    require_once("connect.php");

    if (isset($_POST['JoviosID'])) {
    	echo "{'msg':[";
		
        $data = $db->getGames($_POST['JoviosID']);
		$once = true;
		foreach($data as $game){
			if($once){
				$once = false;
			}
			else{
				echo ",";
			}
			echo"{";
			
			echo "'GameID':";
			echo $game['GameID'];
			echo ",'GameState':'";
			echo $game['GameState'];
			
			echo"'}";
		}
		
		echo "]}";
    }

