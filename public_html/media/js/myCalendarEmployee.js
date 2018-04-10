$(function() {

  $('#calendar').fullCalendar({
    firstDay: 1,
    events:'jsonService/holidayApi.php'
  })

});