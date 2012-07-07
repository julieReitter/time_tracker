<?php

class FormValidation extends Form{
   public $errors = array();
   public $validations = array();
	public $formIsValid = false;
   
   public function validateExistence($all_elements){
      //Check that an item with a star is not empty
      $valid = true;
      
      foreach($all_elements as $key => $value){
         $req = stristr($key, '*');
         if(empty($value) && !empty($req)){
            $valid= false;
            $this->errors[$key] = "Please fill in $key";
         }
      }
      $this->validations[] = $valid;
      return $valid;
   }
   
   public function validatesFormat($element, $format){
      //Validates and elements based on format regex
      $valid = false;
      $regex = filter_var($format, FILTER_VALIDATE_REGEXP);
      if($regex){
         if(preg_match($format, $element)) $valid = true;
      }
      if(!$valid) $this->$errors[$element] = "Incorrect Format"; 

      $this->validations[] = $valid;
      return $valid;
   }
   
   public function validatesEmail($emailElement){
      //Validates email format
      $valid = false;
      $field=filter_var($field, FILTER_SANITIZE_EMAIL);
      if(filter_var($field, FILTER_VALIDATE_EMAIL)){
         $valid = true;
      }
      #$this->$errors['email'] = "Invalid Email";
      $this->validations[] = $valid;
      return $valid;
   }
   
   public function validatesNumber($element, $key, $min=0, $max=null){
      //Validates a number is a number and is between the min and max
      //If format is optional - for time example
      $valid = false;
      if(is_numeric($element)) {
         if($max != null && ($element >= $min && $element <$max)){
               $valid = true;
         }elseif($max == null){
            $valid = true;
         }else{
            $this->errors[$key] = "This is not a valid number";
         }
      }else{
         $this->errors[$key] = "This is not a valid number";
      }
      $this->validations[] = $valid;
      return $valid;
   }
   
   public function validatesUniqueness($element){
      //Validates if element matches another   
   }
   
   public function completeValidation(){
      $valid = true;
      foreach($this->validations as $val){
         if(!$val){
            $valid = false;
            return $this->errors;
         }
      }
		if($valid){
			$this->formIsValid = true;
		}
   }
}//close form validation class

?>