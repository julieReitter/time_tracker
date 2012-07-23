<?php

/* #########################################
PROJECT CLASS
This class sets up a project object that 
had a name, budget, project type and rate.

The object follows CRUD to manipulate the 
database. 
##########################################*/ 

class Project {
	//=========================
	// PROPERTIES
	//=========================
		
	//Project details
	public $id = NULL;
	public $name = "Untitled Project";
	public $budget = NULL;
	public $rate = 0;
	
	//Project Client Information - Get client ID
	public $client = NULL;
	
	//Project content - I may or may not need this? 
	public $tasks = array();
	public $times = array();
	public $income = array();
	
	//=========================
	// METHODS
	//=========================		
	public function create($name, $budget, $rate, $client){
		$this->name = $name;
		$this->budget = $budget;
		$this->rate = $rate;
		$this->client = $client;
		
		$newQuery = "INSERT INTO projects (project_name, client_id, hr_rate, project_budget, user_id)
					VALUES ('$this->name', '$this->client', '$this->rate', '$this->budget', '$user')";
		mysql_query($newQuery);
	}
	
	public function get($columns, $params=null, $by=null, $limit=null){
		//performs query to created a project array
		$projectQuery = "SELECT $columns FROM projects WHERE project_id = $this->id ";
		if($params) $projectQuery .= "AND " . $params;
		if($by) $projectQuery .= $by;
		if($limit) $projectQuery .= $limit;
		
		$results = my_sql($projectQuery);
		
		$obj = mysql_fetch_object($results);
		
		$this->name = $obj.project_name;
		$this->budget = $obj.project_budget;
		$this->rate = $obj.hr_rate;
		$this->client = $obj.client_id;
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
	
}//close project class


?>