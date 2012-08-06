<?php
	include("header.php");
	include("actions.php");
	include("includes/table.php");

	//Format data to create table
   if (isset($_GET['status']) && $_GET['status'] == 'completed') {
      $task = getAllTasks($currentProject, NULL, 1);
      $link = "<a href='tasks.php'>View Incomplete Tasks</a>";
   } else {
      $task = getAllTasks($currentProject);
      $link = "<a href='tasks.php?status=completed'>View Complete Tasks</a>";
   }
	$taskData = array();
	$taskData['header'] = array("Tasks $link");
	$c = 0; //Row Counter
	
	foreach($task as $ta){
		$taskData['id'][$c] = $ta->id;
      if($ta->milestone == 1){
			$taskData['row'][$c]['milestone'] = "<span class='true'> * </span>";
		}else{
			$taskData['row'][$c]['milestone'] = "";
		}
      
      $overDue = '';
      if($ta->dueDate != NULL){
         if( strtotime($ta->dueDate) < strtotime("now") ){
            $overDue = "overdue" ;
         }
         $taskData['row'][$c]['date'] = "<span class='month'> " . date('M', strtotime($ta->dueDate)) . "</span>
                     <span class='date'>" . date('d', strtotime($ta->dueDate)) . "</span>";
      }else {
         $taskData['row'][$c]['date'] = "";
      }
      $taskData['row'][$c]['title'] = "<h3 class='$overDue'>" . $ta->title . "</h3>" . $ta->notes;
		
      
		$times = getTimeForTask($ta->id);
      if(isset($times)){
			$totalTime = calcTimeForTask($times);
			$expectedDifference = ($ta->expectedTimeframe - $totalTime);
			
			$taskData['row'][$c]['time'] = "<h3>" . formatTimeFromMin($totalTime) . "</h3><div class='range-bar' data='$expectedDifference'>";  
			//TODO: list the times and dates here...
		}else{
			$taskData['row'][$c]['time'] = "";
		}
		$c++;
	}
	
	$taskOptions = array("<a href='#' class='play'>Start Task Timer<a/>",
                        "<a href='#' class='complete'>Complete</a>",
                        "<a href='#' class='delete' name='task'>Delete</a>");
	
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
      $taskForm->textField("task[title*]", false, ifIsset($value['title*']));
      $taskForm->label("task[notes]", "Notes");
      $taskForm->textArea("task[notes]", 20, 2, ifIsset($value['notes']));
      $taskForm->label("task[milestone]", "Milestone");
      $taskForm->markup("<input type='checkbox' name='task[milestone]' id='task[milestone]' />");
      $taskForm->markup("<Br/>");
      $taskForm->label("task[expected]", "Timeframe");
      $taskForm->dropDown("task[expected][0]", $hrsMin['hour'], ifIsset($value['expected'][0]));
      $taskForm->markup(" : ");
      $taskForm->dropDown("task[expected][1]", $hrsMin['min'], ifIsset($value['expected'][1]));
      $taskForm->label("task[due_date]", "Due Date");
      $taskForm->textField("task[due_date]", false, ifIsset($value['due_date']));
      $taskForm->drawForm("new-task", "tasks.php", "Add&nbsp;Task");
   }
    if(isset($errors)){
		printErrors($errors);
	}
   
   echo "</div>";  
   	
	echo createTable($taskData, $taskOptions);
   echo "</section>";

?>