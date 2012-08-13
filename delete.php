<?php
   /**********************************************************
   * AJAX for DELETE actions, based on the datatype passed
   * through the AJAX. 
   *********************************************************/

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
			case "client":
            deleteClient($deleteId, "client");
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
	
	function deleteClient($id){
		$query = "DELETE FROM clients WHERE client_id = $id";
      echo $query;
      mysql_query($query);
	}
?>