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
			case "client":
				createClient();
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
      if(isset($elements['end-date'])) {
         $valid->validateDate($elements['end-date']);
      }
      $valid->completeValidation();
		
      if($valid->formIsValid){
         $p = new Project();
			$p->create($elements['name*'], $elements['budget*'],
                    $elements['rate'], $elements['client'], $elements['end-date']);
			print_r($elements['client']);
         //header("Location: index.php");
      }else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
   }
   
	function createTime(){
      global $currentProject;
		$elements = $_POST['time'];
	
		$valid = new FormValidation();
		$valid->validateExistence($elements);
		$valid->completeValidation();
		
		$formattedTimeStart = formatTime($elements['start*']);
		$formattedTimeEnd = formatTime($elements['end*']);
		$duration = getMinFromDuration($elements['total*']);
		
		if($valid->formIsValid){
			$t = new Time();
			$t -> create($duration, $formattedTimeStart ,
							 $formattedTimeEnd,  date( "Y-m-d", time() ), $currentProject, $elements['task']);
		}else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;	
		}
		
	}
	
	function createTask(){
		$elements = $_POST['task'];
		
		$valid = new FormValidation();
		$valid->validateExistence($elements);
      if(isset($elements['due_date'])) {
         $valid->validateDate($elements['due_date'], "/");
      }
		if(isset($elements['milestone'])){
			$elements['milestone'] = 1;
		}else{
			$elements['milestone'] = 0;
		}
		$valid->completeValidation();
      
      $expected = getMinFromDuration($elements['expected']);
		
		if($valid->formIsValid){
			$task = new Task();
			$task->create($elements['title*'], $elements['notes'],
							  $elements['milestone'], $expected,
							  $elements['due_date'], 0);
		}else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
		
	}
	
	function createIncome(){
		$elements = $_POST['income'];
		
		$valid = new FormValidation();
		$valid->validateExistence($elements);
		$valid->validateNumber($elements['amt*'], 'amount');
		$valid->validateDate($elements['date*'], "/");
		$valid->completeValidation();
	
		if($valid->formIsValid){
			$income = new Income();
			$income->create($elements['amt*'], $elements['desc'], $elements['date*']);
		}else{
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
		
	}
	
	function createClient() {
		global $user;
		// Validation
		$elements = $_POST['client'];
		$valid = new FormValidation();
		$valid -> validateExistence($elements);
		$valid -> validateEmail($elements['email*']);
		$valid -> completeValidation();
		
		if ($valid->formIsValid){
			 $query = "INSERT INTO clients (client_name, client_email, client_phone, user_id)
						 VALUES ('" . $elements['name*'] . "', '" 
										. $elements['email*'] . "', '"
										. $elements['phone'] . "', '"
										. $user . "')";
			 mysql_query($query);
		}else {
			global $value, $errors;
			$value = $elements;
			$errors = $valid->errors;
		}
	}

?>