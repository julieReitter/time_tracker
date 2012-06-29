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
	public $name = "Untitled Project";
	public $budget = NULL;
	public $type = "Unknown";
	public $rate = 0.00;
	
	//Project Client Information - Get client ID
	public $client = NULL;
	
	//Project content - I may or may not need this? 
	public $tasks = array();
	public $times = array();
	public $income = array();
	
	//=========================
	// METHODS
	//=========================
	
	public function create(){
		$newQuery = "INSERT INTO projects (project_name, client_id, hr_rate, project_budget, user_id)
					VALUES ('$this->name', '$this->client', '$this->rate', '$this->budget', '$user')";
		mysql_query($newQuery);
	}
	
	public function read(){
		
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
	
}//close project class


?>