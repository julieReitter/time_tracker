<?php
	/*
   $conn = mysql_connect("localhost", "root", "");
	if(!$conn) die ("Could Not Connect To Server");
	
	$db = mysql_select_db("time_tracker", $conn);
	if(!$db) die ("Could Not Connect To Database");
   */
   
   $conn = mysql_connect("localhost", "juliereitter_pet", "pets1234");
	if(!$conn) die ("Could Not Connect To Server");
	
	$db = mysql_select_db("juliereitter_pet", $conn);
	if(!$db) die ("Could Not Connect To Database");
	
	//define('ROOT', 'http://localhost/databaseproject');
   define('ROOT', 'http://juliereitter.aisites.com/csi350/project');
	// Set a global date constant for time calculations
	define('GLOBAL_DATE', '1990-05-12 ');
   date_default_timezone_set('America/New_York'); 
?>