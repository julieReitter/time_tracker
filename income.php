<?php
   /**********************************************************
   * This file querys all the INCOME / EXPENSES for all projects
   * or for current project if set. 
   * It formats the data to display in the table
   * It creates and displays the form for a new income or
   * expense entry based on the amount value. 
   **********************************************************/

	include("header.php");
	include("actions.php");
	include("includes/table.php");
	
    /***********************
   * FORMAT DATA FOR TABLE
   **********************/
	$income = getAllIncome($currentProject);
	$incomeData = array();
	$incomeData['header'] = array("Income and Expenses");
	$c = 0; //Counter
	
	foreach($income as $i){
      $incomeData['id'][$c] = $i->id;
		$incomeData['row'][$c]['date'] = "<span class='month'> " . date('M', strtotime($i->date)) . "</span>
						<span class='date'>" . date('d', strtotime($i->date)) . "</span>";
		if($i->amount > 0){
			$incomeData['row'][$c]['amt'] = "<h3>$" . $i->amount . "</h3>";
		}else{
			$incomeData['row'][$c]['amt'] = "<h3 class='negative'>$" . $i->amount . "</h3>";
		}
		
		$incomeData['row'][$c]['description'] = $i->description;
		
		$c ++;
	}
	
	$incomeOptions = array("<a href='#' class='delete' name='income'>Delete</a>");
	
	/***********************
   * CREATE FORM
   **********************/
   echo "<section id='content'>";
	echo "<div class='new-form'><h3>New Income/Expense</h3>";
	
   if($currentProject == null){
      echo "<h4>Please selected a project to add an income or expense";
   } else {
      $moneyForm = new Form();
      $moneyForm->hidden("form_type", "income");
      $moneyForm->label("income[date*]", "Date");
      $moneyForm->textField("income[date*]", false, ifIsset($value['date*']));
      $moneyForm->label("income[amt*]", "Amount $");
      $moneyForm->markup("<span class='expense-notice'></span>"); 
      $moneyForm->textField("income[amt*]", false, ifIsset($value['amt*']));
      $moneyForm->label("income[desc]", "Description");
      $moneyForm->textArea("income[desc]", 20, 3, ifIsset($value['desc']));
      $moneyForm->drawForm("new-income", "income.php", "Add\nIncome");
   }
   if(isset($errors)){
		printErrors($errors);
	}
   echo "</div>"; //Closes new-form;


	echo createTable($incomeData, $incomeOptions);
	echo "</section>";
?>