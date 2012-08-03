<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");
	
	//Format data to create table
	$time = getAllTime($currentProject);
	$timeSpent = calcTimeSpent();
	$timeData = array();
	$timeData['header'] = array("Time Spent " . $timeSpent['formatted']);
	$c = 0;
   
	foreach($time as $t){
      $timeData['id'][$c] = $t->id;
		$timeData['row'][$c] = array();
		$timeData['row'][$c]['date'] = "<span class='month'> " . date('M', strtotime($t->date)) . "</span>
						<span class='date'>" . date('d', strtotime($t->date)) . "</span>";
						
		$timeData['row'][$c]['amt'] = "<h3>" . formatTimeFromMin($t->amount) . "</h3>";
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
	
	$timeOptions = array("<a href='#' class='delete' name='time'>X</a>");
   
	$tasks = getAllTasks($currentProject);
   $taskNames = array("Choose Task");
   foreach( $tasks as $task ) {
      $taskNames[] = $task->title;
   }
	//Create Form
	// TODO: create dropdowns for start/end to control user input
	$hrsMin = timeSelectFormatter();
	
   echo "<section id='content'>";
	echo "<div class='new-form'><h3>New Time</h3>";
   
   if($currentProject == null){
      echo "<h4>Please selected a project to add a time";
   } else {
      $timeForm = new Form();
      $timeForm->hidden("form_type", "time");
      $timeForm->label("time[start*][0]", "Start");
      $timeForm->dropDown("time[start*][0]", $hrsMin['hour']);
      $timeForm->markup("<span class='colon'> : </span>");
      $timeForm->dropDown("time[start*][1]", $hrsMin['min']);
      $timeForm->dropDown("time[start*][2]", $hrsMin['ap']);
      $timeForm->label("time[end*][0]", "End");
      $timeForm->dropDown("time[end*][0]", $hrsMin['hour']);
      $timeForm->markup("<span class='colon'> : </span>");
      $timeForm->dropDown("time[end*][1]", $hrsMin['min']);
      $timeForm->dropDown("time[end*][2]", $hrsMin['ap']);
      $timeForm->label("time[total*]", "Duration");
      $timeForm->dropDown("time[total*][0]", $hrsMin['min']);
      $timeForm->markup("<span class='colon'> : </span>");
      $timeForm->dropDown("time[total*][1]", $hrsMin['min']);
      $timeForm->markup("<Br/>");
      $timeForm->label("time[task]", "Task");
      $timeForm->dropDown("time[task]", $taskNames);
      $timeForm->drawForm("new-time", "time.php", "Add Time");
   }
	echo "</div>";
	
	if(isset($errors)){
		echo print_r($errors);
	}

	// 24 Hour Time
	$start = strtotime(GLOBAL_DATE . '10:15:00');
	$end = strtotime(GLOBAL_DATE . '17:45:00');
	
	if($start > $end){
		//After 
		$getTotal = 24 - abs($end-$start)/60; // Gets total number of minutes
	}else{
		$getTotal = abs($end-$start)/60; // Gets total number of minutes
	}
	
	echo createTable($timeData, $timeOptions);
	echo "</section>";
?>

