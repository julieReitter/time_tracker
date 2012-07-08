<?php
	require("resources/connection.php");
	require("resources/functions.php");
	
	require("resources/classes/project_class.php");
	require("resources/classes/task_class.php");
	require("resources/classes/time_class.php");
	require("resources/classes/income_class.php");
	require("resources/classes/form_class.php");
	require("resources/classes/form_validation_class.php");
	
	session_start();
	$user = $_SESSION['user_id'];
	if(empty($user)){
		header("Location: login.php");	
	}
	$projects = getAllProjects($user);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Daily Grind | Time Tracking &amp Project Managment</title>
<!-- Styles -->
<link rel="stylesheet/less" type="text/css" href="<?php echo ROOT . "/css/global.less";?>"/>
<!-- Third Party Scripts-->
<script src="<?php echo ROOT . "/resources/lib/jquery-1.7.2.min.js";?>" type="text/javascript"></script>
<script src="<?php echo ROOT . "/resources/lib/less-1.3.0.min.js";?>" type="text/javascript"></script>
<!-- Application Scripts-->
</head>
<body>
	<header>
		<div id="logo"></div>
		<nav id="app-navigation">
			<ul>
				<li><a href="index.php" class="home"></a></li>
				<li><a href="time.php" class="time"></a></li>
				<li><a href="tasks.php" class="tasks"></a></li>
				<li><a href="income.php" class="money"></a></li>
				<li>
					<ul>
						<li><a href="#">All Projects</a></li>
						<?php foreach($projects as $proj): ?>
						<li><a href="#"><?php echo $proj->name; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</li>
			</ul>
		</nav>
		<nav id="general-nav">
			<ul>
				<li><a href="play"></a></li>
				<li><a href="settings"></a></li>
				<li><a href="logout"></a></li>
			</ul>
		</nav>
	</header>