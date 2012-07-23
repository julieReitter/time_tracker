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
	
class Income{
	//=========================
	// PROPERTIES
	//=========================
	public $amount = 00.00;
	public $description = 00.00;
	public $date = NULL;
	
	//=========================
	// METHODS
	//=========================
	
	public function create($amount, $description){
		$this->amount = $amount;
		$this->description = $description;
		
		if( $this->amount > 0){
			# Insert Income Amount
			//TODO: edit if project is set
			$newQuery = "INSERT INTO income (income_amt, description, date, project_id)
						 VALUES ('$this->amount', '$this->description', '$this->date'," . $_SESSION['project'] . ")";
		
		}else if($this->amount < 0){
			# Insert Expense Amount
			$newQuery = "INSERT INTO expenses (expense_amt, expense_title, date, project_id)
						 VALUES ('$this->amount', '$this->description', '$this->date', " . $_SESSION['project'] . ")";
		}
		mysql_query($newQuery);
	}
	
	public function read($id){
		
	}
	
	public function destroy(){
		
	}
	
	public function update(){
		
	}
}
?>