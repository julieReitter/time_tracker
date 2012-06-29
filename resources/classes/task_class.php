<?php
	
class Task{
	//=========================
	// PROPERTIES
	//=========================
	public $title = "New Task";
	public $milestone = 0;
	public $expectedTimeframe = 0;
	public $dueDate = 'today';
	public $status = 0;
	
	private $statusDesc = array( 0 => "To Do", 1 => "Completed");
	
	//=========================
	// METHODS
	//=========================
	
	public function create(){
		$newQuery = "INSERT INTO time (time_amt, start_time, end_time, the_date, project_id, task_id)
					VALUES ('$this->amount', 
							'$this->start',
							'$this->end',
							'$this->date', 
							'$project',
							'$this->task')";
		mysql_query($newQuery);
	}
	
	public function read(){
		
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
}
?>