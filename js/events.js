$(document).ready(function () {
	
	//CALLS
   $(".signup-btn").on("click", toggleSignup);   
   
	$(".project-select select").chosen().change(changeProject);
	$("#new-time select").change(updateDuration);
   	
   $("#general-nav").on("click", ".play", generalTimer);
   $(".project-menu .play").on("click", "a", generalTimer);
   $(".options .play").on("click", generalTimer);

   $("input[name='task[due_date]']").datepicker();
   $("input[name='income[date*]']").datepicker();
   $("input[name='project[end-date]']").datepicker();
   
   $(".full-bar").hover(showTip, hideTip);
   
   var fullContentWidth = $("#content").width();
   dayWidth = Math.floor((fullContentWidth - 350) / 7);
   $(".day").width(dayWidth + "px");
   
   $(window).resize(function(){
      var contentWidth = $("#content").width(),
          moduleDayWidth = Math.floor((contentWidth - 350) / 7);
      $(".day").width(moduleDayWidth + "px");
   });
   
	// CALLBACK FUNCTIONS
   function setCurrentProject() {
      var project = $(".project-select select").val();
      if (project != "all") {
         currentProject = project;
      }else {
         currentProject = null;
      }
      return currentProject;
   }
   
   function toggleSignup (event) {
      var $loginForm = $("#login"),
          $signupForm = $("#signup");
      
      event.preventDefault();
      $loginForm.fadeOut(function(){
         $signupForm.fadeIn();
      });
   }
   
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

   // Main Timer Setup
   function generalTimer(event) {
      var $this = $(this),
          currentDate = new Date(),
          timerSalt;
      
      event.preventDefault();
   
      if($.cookie("start") != null){   
         saveTimeToDb($.cookie("start"), currentDate); // save to db
         $.cookie("start", null, {expires: 0}); // Remove cookie
         $this.closest("li").removeClass("timing"); // Remove timing class
         $("#general-play").removeClass("timing");
         timerNoti.hideNoti();
      }else {
         currentProject = setCurrentProject();
         taskId = $(this).closest("tr").attr("id");
         
         timerSalt = currentDate + " | " + currentProject + " | " + taskId;
         $.cookie("start", timerSalt , {expires: 7});
         timerNoti.getData(currentProject, taskId);
         
         $this.closest("li").addClass("timing");
         $("#general-play").addClass("timing");
      }
   }
   
   // Format the time for database entry
   function calcTimeInMin(startDate, endDate) {
      var totalTime, start, end;
            
      start = new Date(startDate).getTime();
      end = new Date(endDate).getTime();
      totalTime = Math.round( (( end - start ) / 1000 ) / 60 );
      
      return totalTime;
   }
   
   function saveTimeToDb (startSalt, endDate) {
      var start, end, amount, startDate;
      
      startDate = startSalt.split(" | ");
      currentProject = startDate[1];
      taskId = startDate[2];
            
      amount = calcTimeInMin(startDate[0], endDate)
      
      start = new Date(startDate[0]);
      end = new Date(endDate);
      
      formattedStart = numberPad(start.getHours()) + ":" + numberPad(start.getMinutes());
      formattedEnd = numberPad(end.getHours()) + ":" + numberPad(end.getMinutes());
      
      $.ajax ({
         url: "ajax.php",
         type: "POST",
         data: {type: "timer", start: formattedStart, end: formattedEnd, total: amount, project: currentProject, task: taskId},
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
   
   function showTip(event) {
      var $this = $(this),
          width,
          content = $this.find(".bar").attr("title"),
          x = event.pageX,
          y = event.pageY;
      
      width = $this.width() / 2;
      $(".tip").html(content)
               .css({"position": "absolute", "top": y, "left": x})
               .fadeIn();
      
   }
   
   function hideTip(event) {
      $(".tip").fadeOut();
   }
   
   /*************************
    * Timer Notifications
    ************************/
   
   var timerNoti = function(){
      var $container = $(".timer-noti"),
          currentProject,
          taskId;
      
      var getData = function(currentProject, taskId){
         $.ajax ({
            url: "ajax.php",
            type: "POST",
            data: {type: "noti", project: currentProject, task: taskId },
            success: function(response){
               displayNoti(response);
            }
         });
      };
      
      var displayNoti = function(response) {
         var html = '',
             data = $.parseJSON(response);
            
         if(data.project != null) {
            html += "Project: " +  data.project + " ";
         }else {
            html += " All Projects ";
         }
         
         if(data.task != null){
            html += " | Task: " + data.task;
         }
         $container.html(html);
         $container.fadeIn();
      };
      
      var hideNoti = function() {
        $container.fadeOut(); 
      };
      
      return {
         getData: getData,
         hideNoti: hideNoti
      }
   }();
   
   if($.cookie("start") != null){
      $("#general-nav .play").parent().addClass("timing");
      
      timerSalt = $.cookie("start");
      timerData = timerSalt.split(" | ");

      timerNoti.getData(timerData[1], timerData[2]);
   }
   
});

