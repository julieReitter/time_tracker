$(document).ready(function () {
   var currentProject = null;
	
	//CALLS
	$(".project-select select").chosen().change(changeProject);
	$("#new-time select").change(updateDuration);
   
   $(".options").on("click", ".delete", deleteRecord);
	
   $("#general-nav").on("click", ".play", generalTimer);
   $(".project-menu .play").on("click", "a", generalTimer)
   
   if($.cookie("start") != null){
      $("#general-nav .play").parent().addClass("timing");
   }
	
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
		
      if(end.hrs != 0 || end.min != 0){
         // Format for 24 hour time
         if(start.ap == 1){
            start.hrs += 12;
         }
         
         if(end.ap == 1){
            end.hrs += 12;
         }
         
         // Time calculation
         mins = Math.abs(start.min - end.min);
         hours = Math.abs(end.hrs - start.hrs);
         if (mins > 59) {
            hours += 1;
            mins -= 60
         }
         
         // Set duration to hours : mins
         elements[6].options[hours].selected = true;
         elements[7].options[mins].selected = true;
         
         // Update chosen
         $form.find("select[name^=time]").trigger("liszt:updated");
      }
	}
	
	function deleteRecord(event){
		var $this = $(this),
          $parentRow = $this.closest("tr"),
          id = $parentRow.attr("id"),
          datatype = $this.attr("name");
      
      event.preventDefault();
      commit = confirm ("Are you sure you want to delete this record? ");
      
      // Tests to see if income row is income or expense
      if(datatype == "income"){
         expense = $parentRow.find(".amt h3").hasClass("negative");
         if(expense){
            datatype="expense";
         }
      }
      
      if(commit){
         $.ajax ({
            url: "delete.php",
            type: "POST",
            data: {"delete-id" : id, "datatype" : datatype },
            success: function(){
               $this.closest("tr").remove();
            },
            error: function(){
               alert("Unabled to delete the row");
            }
         });
      }
     
	}
   
   // Options Effects
   $(".options li:not(.main)").hide();
   $(".options").hover(showOptions, hideOptions);
   
   function showOptions(event) {
      $(this).find("li:not(.main)").show();
   }
	
   function hideOptions(event) { 
      $(this).find("li:not(.main)").hide();
   }
   
   
   // Main Timer Setup
   // TODO: make reusable for other timers
   function generalTimer(event) {
      var $this = $(this),
          currentDate = new Date();
      
      if($this.attr("name") != undefined){
         currentProject = $this.attr("name");
      }
   
      event.preventDefault();
      console.log(currentDate);
      console.log("Current Project " + currentProject);
      
      if($.cookie("start") != null){
         saveTimeToDb($.cookie("start"), currentDate); // save to db
         $.cookie("start", null, {expires: 0}); // Remove cookie
         $this.parent().removeClass("timing"); // Remove timing class
      }else {         
         $.cookie("start", currentDate , {expires: 7});
         $this.parent().addClass("timing");
      }
   }
   
   // Format the time for database entry
   function calcTimeInMin(startDate, endDate) {
      var totalTime, start, end;
      
      start = new Date(startDate).getTime();
      end = new Date(endDate).getTime();
      totalTime = Math.round( (( end - start ) / 1000 ) / 60 );
      
      console.log(totalTime + " mins");
      return totalTime;
   }
   
   function saveTimeToDb (startDate, endDate) {
      var start, end, amount;
      
      amount = calcTimeInMin(startDate, endDate)
      
      start = new Date(startDate);
      end = new Date(endDate);
      
      formattedStart = numberPad(start.getHours()) + ":" + numberPad(start.getMinutes());
      formattedEnd = numberPad(end.getHours()) + ":" + numberPad(end.getMinutes());
      
      console.log(formattedStart);
      console.log(formattedEnd);
      
      $.ajax ({
         url: "ajax.php",
         type: "POST",
         data: {type: "timer", start: formattedStart, end: formattedEnd, total: amount, project: currentProject},
         success: function(){
            alert("The Time has been saved");
         }
      });
   }
   
   function numberPad(num) {
      if(num < 10){
         return "0" + num;
      }else {
         return num;
      }
   }
   
   
});

