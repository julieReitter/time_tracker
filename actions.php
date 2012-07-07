<?php
   include('resources/classes/project_class.php');
   include("resources/classes/form_class.php");
   include('resources/classes/form_validation_class.php');
	include("resources/functions.php");

   if(!empty($_POST['type'])){
      $type = $_POST['type'];
      switch($type){
         case 'project':
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
		
      if($valid->formIsValid){
         echo "valid";
         $p = new Project($elements['name*'], $elements['budget*'],
                          $elements['type'], $elements['rate'], $elements['client']);
      }else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
   }
   

?>