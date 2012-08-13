$(document).ready( function (){
   // Options Effects
   $(".options ul").hide();
   $(".options").hover(showOptions, hideOptions);
   
   $(".options").on("click", ".delete", deleteRecord);
   $(".options").on("click", ".complete", completeTask);   
   
   $(".project-menu .add").hover(showOptions, hideOptions);
   $(".project-menu .contact-client").hover(showOptions, hideOptions);
   
   function showOptions(event) {
      $(this).find("ul").show();
   }
   
   function hideOptions(event) { 
      $(this).find("ul").hide();
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
   
   
   function completeTask(event) {
      var $this = $(this),
          $parentRow = $this.closest("tr"),
          id = $parentRow.attr("id");
      
      event.preventDefault();
      commit = confirm ("Are you sure you want to complete this task ");
      
      if(commit){
         $.ajax ({
            url: "ajax.php",
            type: "POST",
            data: {id: id, completeTask : "complete-task"},
            success: function(){
               $this.closest("tr").remove();
            },
            error: function(){
               alert("Unable to delete the row");
            }
         });
      }
      
   }

});


