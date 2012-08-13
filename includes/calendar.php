<?php
/**********************************************************
* Gets the data and formats the weekly calendar 
*********************************************************/

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
<section id="calendar">
	<?php for($i=0; $i < 7; $i++): ?>
		<div class="day module">
			<h3>
				<?php
					$day = getdate(strtotime("$i day"));
					echo substr($day['weekday'], 0, 3) . ", ";
					echo substr($day['month'], 0, 3) . " ";
					echo $day['mday'];
				?>
			</h3>
			<ul>
			<?php
				//compare dates
				$monthValue = $day['mon'];
				if($monthValue < 10) $monthValue = "0$monthValue";
            $dayValue = $day['mday'];
            if($dayValue < 10) $dayValue = "0$dayValue";
				$thisDate = $day['year'] . "-" . $monthValue . "-" . $dayValue;
   
				if(isset($calendarData[$thisDate])){
					$todaysTasks = $calendarData[$thisDate];
					foreach($todaysTasks as $key=>$value){
						echo "<li> $value </li>";
					}
				}
			?>
			</ul>
		</div>
	<?php endfor; ?>
		<!-- day * 7-->
</section>