
<?php
	
class Time {
	//=========================
	// PROPERTIES
	//=========================
	public $id = NULL;
	public $amount = NULL;
	public $start = NULL;
	public $end = NULL;
	public $date = '';
	public $task = NULL;
	
	//=========================
	// METHODS
	//=========================
	
	public function create($amount, $start, $end, $date, $project=NULL, $task){
		$this->amount = $amount;
		$this->start = $start;
		$this->end = $end;
		$this->date = $date;
		$this->task = $task;
		
		$newQuery = "INSERT INTO time (time_amt, start_time, end_time, the_date, project_id, task_id)
					VALUES ('$this->amount', 
							'$this->start',
							'$this->end',
							'$this->date', 
							'$project',
							'$this->task')";
		mysql_query($newQuery);
		echo $newQuery;
	}
	
	public function read(){
		
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
}
?>