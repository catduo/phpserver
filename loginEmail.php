<?php
    require_once("connect.php");
	if(isset($_POST['password']) && isset($_POST['username'])){
		echo "{'msg':[{";
		$data = $db->loginEmail($_POST['username'], $_POST['password']);
		echo "'JoviosID':";
		echo $data[0]['JoviosID'];
		echo ",'DeviceID':";
		echo $data[0]['DeviceID'];
		echo ",'Email':";
		echo $data[0]['Email'];
		echo ",'Username':";
		echo $data[0]['Username'];
		echo "}]}";
	}
	else{
		echo "must be a post with username and password";
	}
