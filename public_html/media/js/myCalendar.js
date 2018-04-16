$(function() {

  $('#calendar').fullCalendar({
    firstDay: 1,
    events:'jsonService/holidayApi.php',
    eventClick: function(event) {
      var decision = confirm("Do you really want to do that?");
      if (decision) {
        console.log(event.id);
        // $.ajax({
        //   type: "POST",
        //   url: "delete_event.php",
        //   data: "&id=" + event.id,
        //   success: function(json) {
        //     $('#calendar').fullCalendar('removeEvents', event.id);
        //     alert("Updated Successfully");}
        // });

      }
    }
  })



});