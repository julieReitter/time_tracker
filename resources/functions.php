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
	
	while($all = mysql_fetch_assoc($retrieveAll)){
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

function getAllTime($projectId=NULL, $limit=NULL){
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
	mysql_free_result($retrieveAll);
	return $time;
}

function getAllIncome($projectId = NULL, $filter = NULL, $limit = NULL ){
	$getAllQuery1 = "SELECT income_id AS id, income_amt AS 'amt', description AS 'desc', date, project_id FROM income ";
	$getAllQuery2 = "SELECT expense_id, expense_amt, expense_title, date, project_id FROM expenses ";
	
	if(isset($projectId)){
		$getAllQuery1 .= " WHERE project_id = $projectId ";	
		$getAllQuery2 .= " WHERE project_id = $projectId ";
	}
	if(isset($filter)){
		$getAllQuery1 .= $filter;
		$getAllQuery2 .= $filter;
	}
	
	$query = $getAllQuery1 . " UNION " . $getAllQuery2;
	
	if(isset($limit)){
		$query .= " LIMIT $limit";
	}

	$retrieveAll = mysql_query($query);
	$income = array();
	
	while($all = mysql_fetch_array($retrieveAll)){
		$i = new Income();
		$i->id = $all['id'];
		$i->amount = $all['amt'];
		$i->description = $all['desc'];
		$i->date = $all['date'];
		$income[] = $i;
	}
	return $income;
}

function getTimeForTask($taskId){
	$timeQuery = "SELECT time_amt, the_date FROM time
					  WHERE task_id = $taskId";
	$retrieveTime = mysql_query($timeQuery);
	
	$timeForTasks = null;
	
	if($retrieveTime){
		while($row = mysql_fetch_array($retrieveTime)){
			$timeForTasks[] = array('time' => $row['time_amt'],
											'date' => $row['the_date']);
		}
	}
	
	return $timeForTasks;
}

function calcTimeSpent($projectId=NULL){
	$query = "SELECT SUM(time_amt) AS time_amt FROM time ";
	if(isset($projectId)){
		$query .= " WHERE project_id = $projectId ";
	}
	$retrieve = mysql_query($query);
	$results = mysql_fetch_assoc($retrieve);
	
	$time['hrs'] = $results['time_amt']/60;
	$time['formatted'] = formatTimeFromMin($results['time_amt']);
	return isset($time) ? $time : "00:00";
}

function calcTimeForTask($timeArray){
	$total = 0;
	foreach($timeArray as $time){
		$total += strtotime($time['time']);
	}
	return $total;
}

function calcIncomeTotal($projectId = NULL){
	$query = "SELECT SUM(income_amt) FROM income WHERE project_id = $projectId
				 UNION
				 SELECT SUM(expense_amt) FROM expenses WHERE project_id = $projectId";
	$retrieve = mysql_query($query);
	//Query should return two rows);
	$income = 0;
	while( $row = mysql_fetch_array($retrieve)){
		$income += $row[0];
	}
	return $income;
}

function formatTimeFromMin($totalTime = 0){
	$h = floor($totalTime/60);
	if($h < 10) $h = '0' . $h;
	$m = $totalTime % 60;
	if($m < 10) $m = '0' . $m;
	return $h . "h " . $m . "m";
}

function getMinFromDuration($duration){
	/// $duration = [HH][MM];
	return ($duration[0] * 60) +  $duration[1];
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

function timeSelectFormatter () {
	$timeFormat = array();
	for($i=0; $i<60; $i++){
		if($i<10){
			$timeFormat['hour'][] = "0" . $i;
			$timeFormat['min'][] = "0" . $i;
		}else if($i<13){
			$timeFormat['hour'][] = $i;
			$timeFormat['min'][] = $i;
		}else{
			$timeFormat['min'][] = $i;
		}
	}
	$timeFormat['ap'] = array("AM", "PM");
	return $timeFormat;
}

function formatTime($hrMinAM = array()){
	// Converts the array of times and formatts
	// them to be in 24 hour time 12:00:00
	$formattedTime = NULL;
	if( count($hrMinAM) == 3 ){
		if( $hrMinAM[2] == 1){
			$hrMinAM[0] += 12;
		}
		
		if($hrMinAM[0] < 10){
			$hrMinAM[0] = "0" . $hrMinAM[0];
		}
	
		if($hrMinAM[1] < 10){
			$hrMinAM[1] = "0" . $hrMinAM[1];
		}
		
		$formattedTime = $hrMinAM[0] . ":" . $hrMinAM[1] . ":00";
	}
	
	return $formattedTime;
}


?>