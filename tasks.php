<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");

	//Format data to create table
	$task = getAllTasks($currentProject);
	$taskData = array();
	$taskData['header'] = array("Tasks");
	$c = 0; //Row Counter
	
	foreach($task as $ta){
		$taskData['id'][$c] = $ta->id;
      if($ta->milestone == 1){
			$taskData['row'][$c]['milestone'] = "<span class='true'> * </span>";
		}else{
			$taskData['row'][$c]['milestone'] = "";
		}

		$taskData['row'][$c]['date'] = "<span class='month'> " . date('M', strtotime($ta->dueDate)) . "</span>
						<span class='date'>" . date('d', strtotime($ta->dueDate)) . "</span>";
		$taskData['row'][$c]['title'] = "<h3>" . $ta->title . "</h3>" . $ta->notes;
		
		$times = getTimeForTask($ta->id);
		if(isset($times)){
			$totalTime = calcTimeForTask($times);
			$expectedDifference = ($ta->expectedTimeframe - $totalTime);
			
			$taskData['row'][$c]['time'] = "<h3>$totalTime</h3><div class='range-bar' data='$expectedDifference'>";  
			//TODO: list the times and dates here...
		}else{
			$taskData['row'][$c]['time'] = "";
		}
		$c++;
	}
	
	$taskOptions = array("<a href='#'>Ti<a/>", "<a href='#'>C</a>", "<a href='#' class='delete' name='task'>X</a>");
	
   $hrsMin = timeSelectFormatter();
   
	//create Form
   echo "<section id='content'>";
	echo "<div class='new-form'><h3>New Task</h3>";
   
   if($currentProject == null){
      echo "<h4>Please selected a project to add a task";
   } else {
      $taskForm = new Form();
      $taskForm->hidden("form_type", "task");
      $taskForm->label("task[title*]", "Title");
      $taskForm->textField("task[title*]");
      $taskForm->label("task[notes]", "Notes");
      $taskForm->textArea("task[notes]");
      $taskForm->label("task[milestone]", "Milestone");
      $taskForm->markup("<input type='checkbox' name='task[milestone]' id='task[milestone]' />");
      $taskForm->markup("<Br/>");
      $taskForm->label("task[expected]", "Timeframe");
      $taskForm->dropDown("task[expected][0]", $hrsMin['hour']);
      $taskForm->markup(" : ");
      $taskForm->dropDown("task[expected][1]", $hrsMin['min']);
      $taskForm->label("task[due_date]", "Due Date");
      $taskForm->textField("task[due_date]");
      $taskForm->drawForm("new-task", "tasks.php", "Add&nbsp;Task");
   }
   echo "</div>";
	
	if(isset($errors)){
		echo print_r($errors);
	}
	
	echo createTable($taskData, $taskOptions);
   echo "</section>";

?>