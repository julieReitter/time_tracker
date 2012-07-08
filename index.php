<?php
	require("header.php");
?>

<section id="content">

	<?php #include("includes/calendar.php");?>
	
	<section id="projects">
		<?php foreach($projects as $proj): ?>
		<div class="project module">
			<div class="header">
				<h2><?php echo $proj->name; ?></h2>
				<ul>
					<li>Play</li>
					<li>Add</li>
					<li>Contact Client
						<ul>
							<?php echo $proj->client; ?>
						</ul>
					</li>		
				</ul>
			</div>
			
			<ul class="highlights">
				<?php
					$tasks = getAllTasks($proj->id, 3);
					foreach($tasks as $task):
				?>
				<li class="task">
					<span class="date"><?php echo $task->dueDate;?> </span>
					<h3><?php echo $task->title; ?></h3>
					<p><?php echo $task->notes;?></p>
					<span class="button timer"></span>
				</li>
				<?php endforeach; //Tasks loop ?>
			</ul>
			
			<div class="overview">
				<span class="time-spent">
					Time Spent 
					<h4><?php echo calcTimeSpent($proj->id);?></h4>
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
		<?php endforeach; ?>
		<div class="new">
			<h4>Create New Project</h4>
		</div>
	</section><!-- Close Projects -->
	
</section><!--Close Content-->
