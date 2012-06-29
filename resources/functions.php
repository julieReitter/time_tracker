<?php
require_once("connection.php");

$salt = "csi350";

function newUser($firstName, $lastName, $email, $password){
	global $salt;
	$user = NULL;
	
	//Database Preparation
	$firstName = mysql_real_escape_string($firstName);
	$lastName = mysql_real_escape_string($lastName);
	$emailCheck = spamcheck($email);
	$passwordSalt = md5($salt . " | " . $password);
	
	$signupQuery = "INSERT INTO users (first_name, last_name, email, password)
					VALUES ('$firstName', '$lastName', '$email', '$passwordSalt')";
					
	if($emailCheck){
		$result = mysql_query($signupQuery);
		if($result){
			$user = mysql_insert_id();
		}
	}
	
	return $user;
}//close new User

function validateUser($email, $password){
	global $salt;
	$user = NULL;
	
	$passwordSalt = md5($salt . " | " . $password);
	$loginQuery = "SELECT user_id, email, password FROM users
				   WHERE email = '$email' AND password = '$passwordSalt'";
	$loginResult = mysql_query($loginQuery);
	$rowCount = mysql_num_rows($loginResult);
	
	if($rowCount == 1){
		$set = mysql_fetch_assoc($loginResult);
		$user = $set['user_id'];	
	}
	
	return $user;	
}//close Validate User

function spamcheck($field){
  $field=filter_var($field, FILTER_SANITIZE_EMAIL);

  if(filter_var($field, FILTER_VALIDATE_EMAIL)){
    return TRUE;
  }else{
    return FALSE;
  }
}

?>