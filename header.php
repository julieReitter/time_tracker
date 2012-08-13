<?php
	require("resources/connection.php");
	require("resources/functions.php");
	
   
	session_start();
	$user = $_SESSION['user_id'];
	if(empty($user)){
      header("Location: login.php");	
	}
	
	$currentProject = null;
	if (isset($_GET['project'])) {
		$p = $_GET['project'];
		if($p == "all"){
			unset($_SESSION['project']);
			$currentProject = null;
		}else{
			$_SESSION['project'] = $_GET['project'];
			$currentProject = $_SESSION['project'];		
		}	
	}else if(isset($_SESSION['project'])){
		$currentProject = $_SESSION['project'];
	}
	
	require("resources/classes/project_class.php");
	require("resources/classes/task_class.php");
	require("resources/classes/time_class.php");
	require("resources/classes/income_class.php");
	require("resources/classes/form_class.php");
	require("resources/classes/form_validation_class.php");
	
	$projects = getAllProjects($user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Grind | Time Tracking &amp Project Managment</title>
<!-- Styles -->
<link rel="stylesheet" type="text/css" href="<?php echo ROOT . "/resources/lib/chosen.css";?>" />
<link rel="stylesheet" type="text/css" href="<?php echo ROOT . "/resources/lib/jquery.datepicker.ui.min.css";?>" />
<link rel="stylesheet/less" type="text/css" href="<?php echo ROOT . "/css/main.less";?>"/>
<!-- Third Party Scripts-->
<script src="<?php echo ROOT . "/resources/lib/jquery-1.7.2.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/less-1.3.0.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/chosen.jquery.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/jquery.cookie.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/jquery.datepicker.ui.min.js";?>" type="text/javascript"></script>
<!-- Application Scripts-->
<script src="<?php echo ROOT . "/js/events.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/js/options.js";?>" type="text/javascript"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$("select").css("min-width", "60px");
		$("select").chosen();
	});
</script>
</head>
<body>
	<header>
		<div id="logo"></div>
		<nav id="app-navigation" class="button-nav">
			<ul>
				<li><a href="index.php" class="home"></a></li>
				<li><a href="time.php" class="time"></a></li>
				<li><a href="tasks.php" class="tasks"></a></li>
				<li><a href="income.php" class="money"></a></li>
				<li class="project-select">
					<select style="width:200px;">
						<option value="all">All Projects</option>
						<?php foreach($projects as $proj): ?>
						<option value="<?php echo $proj->id; ?>" <?php if($currentProject == $proj->id) echo "selected='selected'";?>>
							<?php echo $proj->name; ?>
						</option>
						<?php endforeach; ?>
					</select>
				</li>
			</ul>
      </nav>
		<nav id="general-nav" class="button-nav fr">
			<ul>
				<li id="general-play"><a href="#" class="play"></a></li>
				<li><a href="settings.php" class="settings"></a></li>
				<li><a href="logout.php" class="logout"></a></li>
			</ul>
      </nav>
      <span class="timer-noti"></span>
	</header>