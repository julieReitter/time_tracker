<?php

	$calendarQuery = "SELECT task_title, due_date FROM tasks
		WHERE project_id in (
			SELECT project_id FROM projects
			WHERE user_id = $user)
		AND status <> 2
		AND due_date >= CURDATE()
		ORDER BY due_date";
	
	$calendarResults = mysql_query($calendarQuery);
	$calendarData = array();
	while($row = mysql_fetch_assoc($calendarResults)){
		$calendarData[$row['due_date']][] = $row['task_title'];
	}
?>
<section id="calander">
	<?php foreach($calendarData as $day=>$tasks): ?>
		<div class="day">
			<h3><?php echo $day;?></h3>
			<ul>
				<?php
					foreach($tasks as $task){
						echo "<li> $task </li>";
					}
				?>
			</ul>
		</div>
	<?php endforeach; ?>
		<!-- day * 7-->
</section>