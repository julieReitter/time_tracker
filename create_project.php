<?php
	include("header.php");
	include("actions.php");

	$clients = array("0" => "Clients");
	$projectTypes = array("0"=>"Web Design");
	
	echo "<section id='content'>";
   $f = new Form();
   //Form Fields
   $f -> hidden("form_type", "project");
   $f -> label("project[name]", "Project Name");
   $f -> textField("project[name*]", true, ifIsset($value['name*']));
   $f -> dropDown("project[client]", $clients, ifIsset($value['client']));
   $f -> label("project[rate]", "Hourly Rate");
   $f -> textField("project[rate]", true, ifIsset($value['rate']));
   $f -> label("project[budget]", "Project Budget");
   $f -> textField("project[budget*]", true, ifIsset($value['budget']));
   $f -> drawForm("new-project", "create_project.php", "Create&nbsp;Project");
	
	if(isset($errors)){
		echo print_r($errors);
	}
	echo "</section>";
?>