<?php
   if(!empty($_POST['form_type'])){
      $type = $_POST['form_type'];
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
         $p = new Project();
			$p->create($elements['name*'], $elements['budget*'],
                    $elements['rate'], $elements['client']);
			header("Location: index.php");
      }else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
   }
   

?>