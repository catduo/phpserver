<?php
    require_once("connect.php");
	if(!isset($_POST['pingBack'])){
		echo "{msg:";
		echo $db->ping($_POST['pingBack']);
		echo "}";
		echo $_POST['pingBack'];
	}
