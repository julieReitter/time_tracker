<?php
   include('resources/classes/project_class.php');
   include("resources/classes/form_class.php");
   include('resources/classes/form_validation_class.php');

   createProject();
   if(!empty($_POST['type'])){
      $type = $_POST['type'];
      switch($type){
         case "project":
            createProject();
            break;
         case "task":
            createTask();
            break;
         case "time":
            createTime();
            break;
         case "income":
            createIncome();
            break;
         default:
            echo "error processing form";
            break;
      }
   }
   
   function createProject(){
      $elements = $_POST['project'];
      
      $valid = new FormValidation();
      $valid->validateExistence($elements);
      $valid->validatesNumber($elements['rate'], 'rate');
      $valid->validatesNumber($elements['budget*'], 'budget*');
      $valid->completeValidation();
      
      if($valid == 'valid'){
         echo "valid";
         $p = new Project($elements['name*'], $elements['budget*'],
                          $elements['type'], $elements['rate'], $elements['client']);
      }else{
         echo print_r($valid->errors);
      }
   }
   

//Can I create a validation function that takes project[name]
//and seperate it and run it through a loop
//to check to see if each element is valid ? 
?>