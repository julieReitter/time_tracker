<?php

/**********************************************************
PROJECT CLASS
This class sets up a project object that had a name, budget,
project type and rate.

The object also creates or destroys the data in the database
**********************************************************/ 

class Project {
	//=========================
	// PROPERTIES
	//=========================
		
	//Project details
	public $id = NULL;
	public $name = "Untitled Project";
	public $budget = NULL;
	public $rate = 0;
   public $endDate = NULL;
	
	//Project Client Information - Get client ID
	public $client = NULL;
	
	//Project content - I may or may not need this? 
	public $tasks = array();
	public $times = array();
	public $income = array();
	
	//=========================
	// METHODS
	//=========================		
	public function create($name, $budget, $rate, $client, $endDate){
      global $user;
		$this->name = $name;
		$this->budget = $budget;
		$this->rate = $rate;
		$this->client = $client;
      if($endDate != ""){
         $this->endDate = formatDateForDb($endDate);
      }
      
		$newQuery = "INSERT INTO projects (project_name, client_id, hr_rate, project_budget, user_id, end_date)
					VALUES ('$this->name', '$this->client', '$this->rate', '$this->budget', '$user' ";
      if($this->endDate == NULL) {
         $newQuery .= " , NULL );";
      } else {
         $newQuery .= " , '$this->endDate' );";
      }
		mysql_query($newQuery);
	}

	
	public function destroy($id){
		$queryE = "DELETE FROM expenses WHERE project_id=$id ";
      $queryI = "DELETE FROM income WHERE project_id=$id ";
      $queryTa = "DELETE FROM tasks WHERE project_id=$id ";
      $queryT = "DELETE FROM time WHERE project_id=$id ";
      $queryP = "DELETE FROM projects WHERE project_id=$id ";
      mysql_query($queryE);
      mysql_query($queryI);
      mysql_query($queryTa);
      mysql_query($queryT);
      mysql_query($queryP);
	}
	
	public function update(){
		
	}
	
}//close project class


?>