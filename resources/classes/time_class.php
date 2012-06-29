
<?php
	
class Time{
	//=========================
	// PROPERTIES
	//=========================
	public $amount = 00.00;
	public $start = 00.00;
	public $end = 00.00;
	public $date = '';
	public $task = NULL;
	
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