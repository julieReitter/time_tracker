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
      $valid->validateNumber($elements['rate'], 'rate');
      $valid->validateNumber($elements['budget*'], 'budget*');
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
   
	function createTime(){
		$elements = $_POST['time'];
		$timeRegEx = "/(\d{2}):(\d{2})/";
		#$timeRegEx = "^((0?[1-9]|1[012])(:[0-5]\d){0,2}(\ [AP]M))$|^([01]\d|2[0-3])(:[0-5]\d){0,2}$";
		$valid = new FormValidation();
		$valid->validateExistence($elements);
		$valid->validateFormat($elements['total*'], $timeRegEx);
		$valid->validateFormat($elements['start*'], $timeRegEx);
		$valid->validateFormat($elements['end*'], $timeRegEx);
		$valid->completeValidation();
		
		if($valid->formIsValid){
			$t = new Time();
			$t -> create($elements['total*'], $elements['start*'],
							 $elements['end*'],  date( "Y-m-d", time() ), $elements['task']);
			header("Location: time.php");
		}else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;	
		}
		
	}

?>