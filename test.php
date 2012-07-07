<?php
   include("resources/classes/form_class.php");
   
   $clients = array("0" => "Bob");
   
   $f = new Form();
   //Form Fields
   $f -> hidden("postback", "set");
   $f -> label("project[name]", "Project Name");
   $f -> textField("project[name*]");
   $f -> dropDown("project[client]", $clients);
   $f -> label("project[rate]", "Hourly Rate");
   $f -> textField("project[rate]");
   $f -> label("project[budget]", "Project Budget");
   $f -> textField("project[budget*]");
   $f -> drawForm("new-project", "actions.php", "Create&nbsp;Project");

?>