<?php
    require_once("connect.php");
	if(isset($_POST['pingBack'])){
		echo "{'msg':";
		echo $db->ping('2Bornottobe', 'dgeisert');
		echo "}";
	}
