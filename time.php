<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");
	
	$time = getAllTime();
	$timeSpent = calcTimeSpent();
	$timeData = array();
	$timeData['header'] = array("Time Spent $timeSpent");
	$c = 0;
	foreach($time as $t){
		$timeData['row'][$c] = array();
		$timeData['row'][$c]['date'] = $t->date;
		$timeData['row'][$c]['amt'] = "<h3>" . $t->amount . "</h3>";
		if(isset($t->task)) {
			$timeTask = new Task();
			$timeTask->get($t->task);
			$timeData['row'][$c]['amt'] .= "<p> $timeTask->title </p>";
		}
		$timeData['row'][$c]['start'] = " <h4>Start</h4> " . $t->start;
		$timeData['row'][$c]['end'] = " <h4>End</h4> " . $t->end;
		
		if(isset($timeTask)){
			if($t->amount > $timeTask->expectedTimeframe){
				$timeData['row'][$c]['warning'] = "!";
			}else {
				$timeData['row'][$c]['warning'] = "";
			}
		}else{
			$timeData['row'][$c]['warning'] = "";
		}
		
		$c ++;
	}
	$timeOptions = array("delete");
	$taskNames = array(NULL, 1);
	
	$timeForm = new Form();
	$timeForm->hidden("form_type", "time");
	$timeForm->label("time[start*]", "Start");
	$timeForm->textField("time[start*]");
	$timeForm->label("time[end*]", "End");
	$timeForm->textField("time[end*]");
	$timeForm->label("time[total*]", "Total");
	$timeForm->textField("time[total*]");
	$timeForm->dropDown("time[task]", $taskNames);
	$timeForm->drawForm("new-time", "time.php", "Add Time");
	
	if(isset($errors)){
		echo print_r($errors);
	}
	
	echo createTable($timeData, $timeOptions);
	
?>

