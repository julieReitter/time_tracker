<?php
	
class Task{
	//=========================
	// PROPERTIES
	//=========================
	public $id = NULL;
	public $title = "New Task";
	public $notes = "";
	public $milestone = 0;
	public $expectedTimeframe = 0;
	public $dueDate = 'today';
	public $status = 0;
	
	private $statusDesc = array( 0 => "To Do", 1 => "In Progres", 2 => "Completed");
	private $milesontDesc = array(0=> false, 1=> true);
	//=========================
	// METHODS
	//=========================
	
	public function create(){
		#TODO : fix this to be tasks not time HAHA
		$newQuery = "INSERT INTO time (time_amt, start_time, end_time, the_date, project_id, task_id)
					VALUES ('$this->amount', 
							'$this->start',
							'$this->end',
							'$this->date', 
							'$this->id',
							'$this->task')";
		mysql_query($newQuery);
	}
	
	public function read($columns, $params, $by, $limit){
		$projectQuery = "SELECT $columns FROM task";
		if($params) $projectQuery .= "AND " . $params;
		if($by) $projectQuery .= $by;
		if($limit) $projectQuery .= $limit;
		
		$results = my_sql($projectQuery);
		
		$obj = mysql_fetch_object($results);
		
	}
	
	public function get($id){
		$getTaskQuery = "SELECT * FROM tasks WHERE task_id = $id";
		$retrieveGet = mysql_query($getTaskQuery);
		$obj = mysql_fetch_assoc($retrieveGet);
		
		$this->id = $id;
		$this->title = $obj['task_title'];
		$this->notes = $obj['notes'];
		$this->milestone = $obj['milestone'];
		$this->expectedTimeframe = $obj['expected_time'];
		$this->dueDate = $obj['due_date'];
		$this->status = $obj['status'];
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
}
?>