<?php

if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{

    /*======= retrieve employee name from user_id =======*/
    $username=$_SESSION['uName'];
    $query="SELECT name as employee, username,id_employee
FROM users U
JOIN employees E ON U.users_id=E.user_id 
WHERE username='$username'";
    if($result=$mysqli->query($query)){
        if ($result->num_rows==1){
            while ($row=$result->fetch_assoc()){
                foreach ($row as $key=>$value){
                    if($key=='employee'){
                        $_SESSION['employee']=$value;
                    }
                    if ($key=='id_employee'){
                        $_SESSION['employee_id']=$value;
                    }
                }
            }

        }else{
            die('Contact your Admin there are two users with same username');
        }
    }else{
        die($mysqli->error);
    }
    $variables=include_once __DIR__.'/../templates/arrays/user.php';
    /*====== Holiday report ======*/
    $holiday=array();
    $holidayArray=array();
    $employeeId=$_SESSION['employee_id'];
    $query="SELECT H.holiday_id,H.holiday_start,H.holiday_end,H.employee_id,holiday_approved FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE employee_id=$employeeId";
    if ($result=$mysqli->query($query)){
        while ($row=$result->fetch_assoc()){
            $holiday['start']=htmlentities($row['holiday_start']);
            $holiday['end']=htmlentities($row['holiday_end']);
            foreach ($row as $key=>$value){
                if ($key=='holiday_approved'){
                    if ($value=='Y'){
                        $holiday['approved']=htmlentities($value);
                    }else{
                        $holiday['approved']=htmlentities($value);
                    }
                }
            }
            array_push($holidayArray,$holiday);
        }
        $variables['holiday']=$holidayArray;
    }else{
        die($mysqli->error);
    }
    $result->free();

    /*==== rota report ====*/

//    next week
    $nextWeek=getWeek(1,'Y-m-d');
    $nextMonday=$nextWeek[0];

    $query="SELECT S.date,E.department FROM schedule_rota S
JOIN employees E on S.employee_id=E.id_employee
WHERE date = '$nextMonday' AND S.employee_id=$employeeId";

    if ($result=$mysqli->query($query)){
        if($result->num_rows!==0){
            $variables['nextWeekRota']=true;
        }
    }else{
        die($mysqli->error);
    }
    $result->free();

//    this week
    $thisWeek=getWeek(0,'Y-m-d');
    $thisMonday=$thisWeek[0];

    $query="SELECT S.date,E.department FROM schedule_rota S
JOIN employees E on S.employee_id=E.id_employee
WHERE date = '$thisMonday' AND S.employee_id=$employeeId";

    if ($result=$mysqli->query($query)){
        if($result->num_rows!==0){
            $variables['thisWeekRota']=true;
        }
    }else{
        die($mysqli->error);
    }
    $result->free();



    echo $twig->render($template->getTemplate(),$variables);

}
