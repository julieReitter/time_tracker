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
      if (isset($_POST['task'])){
         $task = $_POST['task'];
      }else {
         $task = null;
      }
      
      $t = new Time();
		$t -> create($total, $start , $end,
                   date( "Y-m-d", time() ), $project, $task);

   }


?>