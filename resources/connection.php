<?php
	$conn = mysql_connect("localhost", "root", "");
	if(!$conn) die ("Could Not Connect To Server");
	
	$db = mysql_select_db("time_tracker", $conn);
	if(!$db) die ("Could Not Connect To Database");
	
	define('ROOT', 'http://localhost/databaseproject');
	// Set a global date constant for time calculations
	define('GLOBAL_DATE', '1990-05-12 '); 
?>