<?php
/* #########################################
INCOME AND EXPENSE CLASS
This class sets up an income object that 
takes an amount and description. The amount
if positive acts as an income amt and if 
negative is an expense. 

The object follows CRUD to manipulate the 
database. 
##########################################*/ 
	
class Income {
	//=========================
	// PROPERTIES
	//=========================
	public $amount = 00.00;
	public $description = 00.00;
	public $date = NULL;
	
	//=========================
	// METHODS
	//=========================
	
	public function create($amount, $description, $date){
		$this->amount = $amount;
		$this->description = $description;
      $this->date = formatDateForDb($date);
      
      global $currentProject;

		if( $this->amount > 0){
			# Insert Income Amount
			$newQuery = "INSERT INTO income (income_amt, description, date, project_id)
						 VALUES ('$this->amount', '$this->description', '$this->date', '$currentProject')";
		
		}else if($this->amount < 0){
			# Insert Expense Amount
			$newQuery = "INSERT INTO expenses (expense_amt, expense_title, date, project_id)
						 VALUES ('$this->amount', '$this->description', '$this->date', '$currentProject ' )";
		}
		mysql_query($newQuery);
	}
	
	public function read($id){
		
	}
	
	public function destroy($id, $type){
		if ($type == "expense") { 
         $deleteQuery = "DELETE FROM expenses WHERE expense_id = $id ";
      } else {
         $deleteQuery = "DELETE FROM income WHERE income_id = $id ";
      }
      mysql_query($deleteQuery);
	}
	
	public function update(){
		
	}
}
?>