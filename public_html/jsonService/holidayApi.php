<?php
require_once __DIR__.'/../../config/start.php';
$query="SELECT H.holiday_id, H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"Y\"";
$events=new Wellstreet\classes\holidayApi($mysqli,$query);
echo $events->allEvents();