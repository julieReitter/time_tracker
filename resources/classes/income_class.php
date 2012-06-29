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
	
	//=========================
	// METHODS
	//=========================
	
	public function create(){
		if( $this->amount > 0){
			# Insert Income Amount
			$newQuery = "INSERT INTO income (income_amt, description, project_id)
						 VALUES ('$this->amount', 
								'$this->description', 
								'$project'";
		}else if($this->amount < 0){
			# Insert Expense Amount
			$newQuery = "INSERT INTO expenses  (expense_amt, expense_title, project_id)
						 VALUES ('$this->amount', 
								'$this->description', 
								'$project'";
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