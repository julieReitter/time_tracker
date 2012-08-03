<?php
   require("resources/connection.php");
   require("resources/classes/project_class.php");
	require("resources/classes/task_class.php");
	require("resources/classes/time_class.php");
	require("resources/classes/income_class.php");  

   if( isset($_POST['delete-id']) && isset($_POST['datatype']) ) {
      $deleteId = $_POST['delete-id'];
      $dataType = $_POST['datatype'];
      
      switch($dataType){
        case 'project':
           deleteProject($deleteId);
           break;
        case "task":
           deleteTask($deleteId);
           break;
        case "time":
           deleteTime($deleteId);
           break;
        case "income":
           deleteIncome($deleteId, "income");
           break;
        case "expense":
           deleteIncome($deleteId, "expense");
           break;
        default:
           echo "ERROR DELETEING RECORD ";
           break;
      }     
   }
   
   function deleteProject($id){
      $proj = new Project();
      $proj->destroy($id);
   }
     
   function deleteTask($id){
      $task = new Task();
      $task->destroy($id);
   }
     
   function deleteTime($id){
      $time = new Time();
      $time->destroy($id);
   }
   
   function deleteIncome($id, $type){
      $income = new Income();
      $income->destroy($id, $type);
   }
?>