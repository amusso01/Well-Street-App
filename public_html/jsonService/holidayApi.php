<?php
require_once __DIR__.'/../../config/start.php';

/*==== retrive approved holiday from db =====*/
$query="SELECT H.holiday_id, H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"Y\"";
$events=new Wellstreet\classes\holidayApi($mysqli,$query);

$holiday=$events->allEvents();


/*=== delete ===*/
if (isset($_POST['id'])) {
    $eventId = $_POST['id'];
    /*=== find email address of employee made request ===*/
    $query="SELECT email,name,H.holiday_start,H.holiday_end FROM employees E
JOIN  holiday_request H on E.id_employee=H.employee_id
WHERE holiday_id='$eventId';";
    $events->setQuery($query);
    $result=$events->result();
    while ($row=$result->fetch_assoc()){
        $email=$row['email'];
        $name=$row['name'];
        $start=$row['holiday_start'];
        $end=$row['holiday_end'];
    }

    /*==== set and send email deletion ====*/
    $mailMessage=(new Swift_Message('Holiday request'));//create new email message
    $mailMessage->setFrom(['admin@wellstreetapp.co.uk' => 'Admin']);
    $mailMessage->setTo($email);
    $mailMessage->setBody("Dear $name,\r\n\r\nYour booked holiday for Well Street Kitchen from $start to $end has been cancelled. Please contact your manager for more information\r\n\r\nRegards\r\nAdmin",'text/plain');
    $mailer->send($mailMessage);

    /*=== delete holiday request from db ===*/
    $query = "DELETE FROM holiday_request WHERE holiday_id= '$eventId';";
    $events->setQuery($query);
    echo $events->deleteEvent($eventId);

    die();
}


/*==== return json for all the approved holiday ====*/
echo $holiday;