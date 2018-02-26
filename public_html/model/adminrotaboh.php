<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__.'/../templates/arrays/adminrotaboh.php';
    $query="SELECT WEEK(date,1) as week_number
from schedule_rota
join employees on employee_id=id_employee
where department='boh'
group by week_number";
    $result=$mysqli->query($query);
    if ($result){
        $week['week']=getWeek();
        $variables['weekNumber']=1;
        /*========Skip weeks already in the DB=========*/
        $weekOfTheYear=strtotime($week['week'][0]);
        $weekOfTheYear=date('W',$weekOfTheYear);
        while ($row=$result->fetch_assoc()){
            if($weekOfTheYear==$row['week_number']){
                $variables['weekNumber']+=1;
                $week['week']= getWeek($variables['weekNumber']);
                $weekOfTheYear=strtotime($week['week'][0]);
                $weekOfTheYear=date('W',$weekOfTheYear);
            }
        }
    }else{
        die($mysqli->error);
    }
    
    $result->free_result();
    $variables=array_merge($variables,$week);

    $query ="SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE department='boh' AND U.users_id=E.user_id AND U.adminaccess='0'";
    $result=$mysqli->query($query);
    if ($result==false){
        echo $mysqli->error;
    }else {
        $users = array();
        while ($row = $result->fetch_assoc()) {
            foreach ($row as $key => $value) {
                $row[$key] = htmlentities($value);
            }
            $employeesArray[] = $row;
            $users['users'] = $employeesArray;
        }
    }
    $variables=array_merge($variables,$users);
    $query ="SELECT * FROM shift";
    $result=$mysqli->query($query);
    if ($result==false){
        echo $mysqli->error;
    }else {
        $shift=array();
        while($row=$result->fetch_assoc()){
            foreach ($row as $key => $value) {
                $row[$key] = htmlentities($value);
            }
            $shiftArray[]=$row;
            $shift['shift']=$shiftArray;
        }
    }
    $variables=array_merge($variables,$shift);
    $result->free_result();
    echo $twig->render('adminrotafoh.html.twig',$variables);
}