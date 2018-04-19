$(function() {

  $('#calendar').fullCalendar({
    firstDay: 1,
    events:'jsonService/holidayApi.php',


      eventClick: function (event, delta) {

          var start = moment(event.start).format('DD-MM-Y');
          var end = moment(event.end).subtract(1,"days").format('DD-MM-Y');

          $('#modalTitle').html(event.title);
          $('#modalStart').html('From &nbsp;&nbsp;'+ start);
          $('#modalEnd').html('To &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '+ end);
          $('#fullCalModal').modal();


          $("#revButton").unbind('click');
          $("#revButton").click(function () {
              var eventId = event._id
              $.ajax({
                  type:"POST",
                  url:'jsonService/holidayApi.php',
                  data: "&id=" + eventId,
                  success: function () {
                          $('#calendar').fullCalendar('removeEvents', event._id);
                          $('#calendar').fullCalendar('addEventSource', JSON.parse(json_events));
                  },
                  error: function(e){
                      alert('Error processing your request: '+e.responseText);
                  }
              });
          });
      }
  })

});