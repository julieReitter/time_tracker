<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");
	
	$clients = getAllClients();
   $clientNames = array();
   foreach($clients as $name){
      $clientNames[$name['id']] = $name['name'];
   }
	$projectTypes = array("0"=>"Web Design");
	
	echo "<section id='content'>";
   $f = new Form();
   //Form Fields
   $f -> hidden("form_type", "project");
   $f -> label("project[name]", "Project Name");
   $f -> textField("project[name*]", true, ifIsset($value['name*']));
   $f -> dropDown("project[client]", $clientNames, ifIsset($value['client']));
   $f -> label("project[rate]", "Hourly Rate");
   $f -> textField("project[rate]", true, ifIsset($value['rate']));
   $f -> label("project[budget]", "Project Budget");
   $f -> textField("project[budget*]", true, ifIsset($value['budget']));
   $f -> label("project[end-date]", "End Date");
   $f -> textField("project[end-date]", false,  ifIsset($value['end-date']));
   $f -> drawForm("new-project", "create_project.php", "Create&nbsp;Project");
	
	if(isset($errors)){
		echo print_r($errors);
	}
	
	############################
	# Clients Form
	############################

	$clientForm = new Form();
	$clientForm -> hidden("form_type", "client");
	$clientForm -> label("client[name*]", "Name");
	$clientForm -> textField("client[name*]");
	$clientForm -> label("client[email*]", "Email");
	$clientForm -> textField("client[email*]");
	$clientForm -> label("client[phone]", "Phone");
	$clientForm -> textField("client[phone]");
	$clientForm -> drawForm("client-form", "create_project.php", "Add Client");
	
   // Display Client Table	
	$clientData = array();
	$clientData['header'] = array("Name", "Email", "Phone Number", "" );
	$c = 0;

	foreach ($clients as $cli) {
      $clientData['id'][$c] = $cli['id'];
		$clientData['row'][$c]['name'] = $cli['name'];
		$clientData['row'][$c]['email'] = $cli['email'];
		$clientData['row'][$c]['phone'] = $cli['phone'];
		$c++;
	}
	
	$clientOptions = array("<a href='#' class='delete' name='client'>X</a>");
	echo createTable($clientData, $clientOptions);

	echo "</section>";
	
?>