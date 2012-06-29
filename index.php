<?php
	require("header.php");
	require("resources/connection.php");
	
	session_start();
	$user = $_SESSION['user_id'];
	if(empty($user)){
		header("Location: login.php");	
	}
	
	echo "Hello $user";
?>
