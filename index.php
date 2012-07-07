<?php
	require("header.php");
	
	session_start();
	$user = $_SESSION['user_id'];
	if(empty($user)){
		header("Location: login.php");	
	}
	
	echo "Hello $user";
?>

<section id="content">
	<section id="calander">
		<div class="day">
			<h3>Sun, June 30</h3>
			<ul>
				<li>Task</li>
			</ul>
		</div>
		<!-- day * 7-->
	</section>
	
	<section id="projects">
		<div class="project module">
			<div class="header">
				<h2>Project Title</h2>
				<ul>
					<li>Play</li>
					<li>Add</li>
					<li>Contact Client</li>
				</ul>
			</div>
			
			<ul class="highlights">
				<li class="task">
					<span class="date">Jun 30</span>
					<h3>Title</h3>
					<p>Content</p>
					<span class="button"></span>
				</li>
			</ul>
			
			<div class="overview">
				<span class="time-spent">
					Time Spent 
					<h4>15:00</h4>
				</span>
				<span class="income">
					Income
					<h4>$300</h4>
				</span>
			</div>
			
			<div class="progress">
				<div class="full-bar">
					<div class="bar time"></div>
				</div>
				<div class="full-bar">
					<div class="bar budget"></div>
				</div>
			</div>
			
		</div><!-- Close Project Module -->
		
		<div class="new">
			<h4>Create New Project</h4>
		</div>
		
	</section><!-- Close Projects -->
	
</section><!--Close Content-->
