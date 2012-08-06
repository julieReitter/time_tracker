<?php
   include("header.php");
   include("includes/table.php");
   $projects = getAllProjects($user);
   $projectData = array();
   $projectData['header'] = array("Projects");
   $c = 0;
   
   foreach ($projects as $project) {
      $projectData['id'][$c] = $project->id;
      $projectData['row'][$c]['name'] = $project->name;
      $c++;
   }
   
   $options = array("<a href='#' class='delete' name='project'>Delete</a");   
?>

<section id="content">
   <?php echo createTable($projectData, $options); ?>
</section>