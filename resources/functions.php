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

/******************************
 * PROJECT FUNCTIONS
 ******************************/
function getAllProjects($user){
	//Gets all projects and returns array of project objects
	$getAllQuery = "SELECT * FROM projects WHERE user_id = $user";
	$retrieveAll = mysql_query($getAllQuery);
	$projects = array();

	while($all = mysql_fetch_assoc($retrieveAll)){
		$p = new Project();
		$p->id = $all['project_id'];
		$p->name = $all['project_name'];
		$p->budget = $all['project_budget'];
		$p->rate = $all['hr_rate'];
		$p->client = $all['client_id'];
		$projects[] = $p;
	}
	
	return $projects;
}

function getAllTasks($projectId=NULL, $limit=NULL){
	//Gets all tasks and returns array of tasks objects
	$getAllQuery = "SELECT * FROM tasks ";
	//Limits by project id if set
	if(isset($projectId)){
		$getAllQuery .= " WHERE project_id = $projectId ";
	}
	if(isset($limit)){
		$getAllQuery .= " LIMIT $limit";
	}
	$retrieveAll = mysql_query($getAllQuery);
	$tasks = array();
	
	while($all = mysql_fetch_array($retrieveAll)){
		$t = new Task();
		$t->id = $all['task_id'];
		$t->title = $all['task_title'];
		$t->notes = $all['notes'];
		$t->milestone = $all['milestone'];
		$t->expectedTimeframe = $all['expected_time'];
		$t->dueDate = $all['due_date'];
		$t->status = $all['status'];
		$tasks[] = $t;
	}
	return $tasks;
}

function getAllTime($projectId=NUll, $limit=NULL){
	$getAllQuery = "SELECT * FROM time";
	if(isset($projectId)){
		$getAllQuery .= " WHERE project_id = $projectId ";
	}
	if(isset($limit)){
		$getAllQuery .= " LIMIT $limit";
	}
	$retrieveAll = mysql_query($getAllQuery);
	$time = array();
	
	while($all = mysql_fetch_array($retrieveAll)){
		$ti = new Time();
		$ti->id = $all['time_id'];
		$ti->amount = $all['time_amt'];
		$ti->start = $all['start_time'];
		$ti->end = $all['end_time'];
		$ti->date = $all['the_date'];
		$ti->task = $all['task_id'];
		$time[] = $ti;
	}
	return $time;
}

function calcTimeSpent($projectId=NULL){
	$query = "SELECT SUM(time_amt) AS time_amt FROM time ";
	if(isset($projectId)){
		$query .= " WHERE project_id = $projectId ";
	}
	$retrieve = mysql_query($query);
	$results = mysql_fetch_assoc($retrieve);
	
	$time = $results['time_amt'];
	return isset($time) ? $time : "00:00:00";
}

function spamcheck($field){
  $field=filter_var($field, FILTER_SANITIZE_EMAIL);

  if(filter_var($field, FILTER_VALIDATE_EMAIL)){
    return TRUE;
  }else{
    return FALSE;
  }
}

function ifIsset(&$var, $default = NULL) {
   $s = $var;
	return $s;
	#isset($var) ? $var : $default;
}

?>