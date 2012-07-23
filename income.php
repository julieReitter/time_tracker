<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");
	
	$income = getAllIncome($currentProject);
	$incomeData = array();
	$incomeData['header'] = array("Income and Expenses");
	$c = 0; //Counter
	
	foreach($income as $i){
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
	
	$incomeOptions = array("Add to invoice", "delete");
	
	//Create Money Add Form
	echo "<div class='new-form'><h3>New Income/Expense</h3>";
	$moneyForm = new Form();
	$moneyForm->hidden("form_type", "income");
	$moneyForm->label("income[date*]", "Date");
	$moneyForm->textField("income[date*]");
	$moneyForm->label("income[amt*]", "Amount $");
	$moneyForm->markup("<span class='expense-notice'></span>");
	$moneyForm->textField("income[amt*]");
	$moneyForm->label("income[desc]", "Description");
	$moneyForm->textArea("income[desc]");
	$moneyForm->drawForm("new-income", "income.php", "Add&nbsp;Income");
	echo "</div>"; //Closes new-form;

	if(isset($errors)){
		echo print_r($errors);
	}
	
	echo createTable($incomeData, $incomeOptions);
	
?>