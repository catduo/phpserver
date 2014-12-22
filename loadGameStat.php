<?php
    require_once("connect.php");
	if(isset($_POST['gameName']) && isset($_POST['where'])){
		echo"{'msg':[";
		
		$data = $db->saveGame($_POST['gameName'], $_POST['where']);
		
		$once = true;
		foreach($data as $game){
			if($once){
				$once = false;
			}
			else{
				echo ",";
			}
			echo"{";
			
			echo "'Domain':'";
			echo $game['Domain'];
			echo "','Kingdom':'";
			echo $game['Kingdom'];
			echo "','Phylum':'";
			echo $game['Phylum'];
			echo "','Order':'";
			echo $game['Order'];
			echo "','Class':'";
			echo $game['Class'];
			echo "','Family':'";
			echo $game['Family'];
			echo "','Genus':'";
			echo $game['Genus'];
			echo "','Species':'";
			echo $game['Species'];
			
			echo"'}";
		}
		
		echo "]}";
	}