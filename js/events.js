$(document).ready(function () {
	
	//CALLS
	$(".project-select select").chosen().change(changeProject);
	$("#new-time select").change(updateDuration);
	
	
	// CALLBACK FUNCTIONS
	function changeProject (event) {
		window.location.href = location.pathname + "?project=" + $(this).val();
	}
	
	function updateDuration (event) {
		var $form = $("#new-time"),
			 elements = $form.find("select[name^=time]"),
			 times = [];
		
		// Get all the values
		for(i=0; i<elements.length; i++){
			times.push(elements[i].selectedIndex);
		}
		
		start = {hrs: times[0], min: times[1], ap: times[2]};
		end = {hrs: times[3], min: times[4], ap: times[5]};
		
		// Format for 24 hour time
		if(start.ap == 1){
			start.hrs += 12;
		}
		
		if(end.ap == 1){
			end.hrs += 12;
		}
		
		mins = Math.abs(start.min - end.min);
		hours = Math.abs(end.hrs - start.hrs);
		if (mins > 59) {
			hours += 1;
			mins -= 60
		}
		
		// Set duration to hours : mins
		
	}
	
	
		
	
});

