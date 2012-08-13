<?php
   require("resources/connection.php");
   require("resources/functions.php");
   require("resources/classes/project_class.php");
	require("resources/classes/task_class.php");
	require("resources/classes/time_class.php");
	require("resources/classes/income_class.php"); 

   if( isset($_POST['type']) && $_POST['type'] == 'timer' ) {
      $project = $_POST['project'];      
      $start = $_POST['start'];
      $end = $_POST['end'];
            
      $total = $_POST['total'];
      if (isset($_POST['task'])) {
         $task = $_POST['task'];
      }else {
         $task = null;
      }
      
      $t = new Time();
		$t -> create($total, $start , $end,
                   date( "Y-m-d", time() ), $project, $task);

   }
   
   if( isset($_POST['completeTask']) && $_POST['completeTask'] == 'complete-task'){
      $id = $_POST['id'];
      $date = date("Y/m/d");
      echo $date;
      
      $task = new Task();
      $task -> update($id, " status='1' , date_completed='$date' ");     
   }
   
   if( isset($_POST['type']) && $_POST['type'] == 'noti' ) {
      $project = $_POST['project'];
      $task = $_POST['task'];
      
      $projectQuery = "SELECT project_name FROM projects WHERE project_id = $project ";
      $retrieveProject = mysql_query($projectQuery);
      
      $taskQuery = "SELECT task_title FROM tasks WHERE task_id = $task ";
      $retrieveTask = mysql_query($taskQuery);
      
      if($retrieveProject){
         $projectName = mysql_fetch_assoc($retrieveProject);
      } else {
         $projectName = null;
      }
      
      if($retrieveTask){
         $taskName = mysql_fetch_assoc($retrieveTask);
      } else {
         $taskName = null;
      }

      $response = array("project" => $projectName['project_name'], "task" => $taskName['task_title']);
      echo json_encode($response);
   }


?>