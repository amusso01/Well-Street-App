<?php
require_once __DIR__.'/../../config/start.php';

/*==== retrive approved holiday from db =====*/
$query="SELECT H.holiday_id, H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"Y\"";
$events=new Wellstreet\classes\holidayApi($mysqli,$query);

/*=== delete ===*/
if (isset($_POST['id'])) {
    $eventId = $_POST['id'];
    $query = "DELETE FROM holiday_request WHERE holiday_id= '$eventId';";
    $events->setQuery($query);
    echo $events->deleteEvent($eventId);
    die();
}


/*==== return json for all the approved holiday ====*/
echo $events->allEvents();