<?php
	/*
   require("header.php");
	require("resources/connection.php");
	
	session_start();
	$user = $_SESSION['user_id'];
	if(empty($user)){
		header("Location: login.php");	
	}
   */
   require_once("resources/classes/form_class.php");
?>

<div class="new-project">
   <?php
       $clients = array("0" => "Bob");
   
      $f = new Form();
      //Form Fields
      $f -> hidden("postback", "set");
      $f -> label("project[name]", "Project Name");
      $f -> textField("project[name]");
      $f -> dropDown("project[client]", $clients);
      $f -> label("project[rate]", "Hourly Rate");
      $f -> textField("project[rate]");
      $f -> label("project[budget]", "Project Budget");
      $f -> textField("project[budget]");
      $f -> drawForm("new-project", "test.php", "Create&nbsp;Project");
   ?>
</div>