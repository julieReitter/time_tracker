<?php
	require("header.php");
?>

<section id="content">

	<?php include("includes/calendar.php");?>
	
	<section id="projects">
		<?php foreach($projects as $proj): ?>
		<div class="project module">
			<div class="header">
				<h2><?php echo $proj->name; ?></h2>
				<ul class="project-menu">
					<li class="play"><a href="#" name="<?php echo $proj->id;?>"></a></li>
					<li class="add">
                  <ul style="display: none">
                     <li><a href="tasks.php?project=<?php echo $proj->id; ?>">Task</a></li>
                     <li><a href="time.php?project=<?php echo $proj->id; ?>">Time</a></li>
                     <li><a href="income.php?project=<?php echo $proj->id; ?>">Income</a></li>
                  </ul>   
               </li>
               <?php if ($proj->client != 0): ?>
					<li class="contact-client">
                  <ul style="display: none">
                  <?php
                     $client = getClientById($proj->client);
                     echo "<li>" . $client['client_name'] . "</li>" .
                          "<li>" . $client['client_email'] . "</li>" . 
                          "<li>" . $client['client_phone'] . "</li>";
                  ?>
						</ul>
					</li>
               <?php endif; ?>
				</ul>
			</div>
			
			<ul class="highlights">
				<?php
					$tasks = getAllTasks($proj->id, 3);
               if(count($tasks) < 1 ) {
                  echo "No Tasks Have Been Saved";
               }
					foreach($tasks as $task):
				?>
				<li class="task">
					<span class="date">
						<span class="month">
							<?php echo date("M", strtotime($task->dueDate));?>
						</span>
						<span class="date">
							<?php echo date("d", strtotime($task->dueDate));?>
						</span>
					</span>
					<h3><?php echo $task->title; ?></h3>
					<p><?php echo $task->notes;?></p>
				</li>
				<?php endforeach; //Tasks loop ?>
			</ul>
			
			<div class="overview">
				<div class="time-spent">
					Time Spent 
					<h4>
					<?php
						$totalTime = calcTimeSpent($proj->id);
						echo $totalTime['formatted'];
					?></h4>
				</div>
				<div class="income">
					Income
					<h4>
					<?php
						$totalIncome = calcIncomeTotal($proj->id);
						echo "$" . $totalIncome;
					?></h4>
				</div>
			</div>
			
			<div class="progress">
				<?php
					// Time spent verses entire project timeframe
					$timeFull = $proj->budget / $proj->rate;
					if($totalTime['hrs'] < $timeFull){
						$timeBarWidth = ($totalTime['hrs'] / ($proj->budget / $proj->rate)) * 100;
					}else{
						$timeBarWidth = 100;
					}
				
					if($totalIncome < $proj->budget){
						$budgetBarWidth = ($totalIncome / $proj->budget);
					}else{
						$budgetBarWidth = 100;
					}
				?>
				<div class="full-bar">
					<div class="bar time" title="Time" style="width:<?php echo $timeBarWidth . "%"; ?>"></div>
				</div>
				<div class="full-bar">
					<div class="bar budget" title="Budget" style="width:<?php echo $budgetBarWidth . "%"; ?>"></div>
				</div>
			</div>
			
		</div><!-- Close Project Module -->
		<?php endforeach; ?>
      <div class="clearfix"></div>
		<div class="new">
			<h4><a href="create_project.php" class="button">Create New Project</a></h4>
		</div>
	</section><!-- Close Projects -->
	
</section><!--Close Content-->
<div class="tip"></div>