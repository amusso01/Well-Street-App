<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['submit'])){
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    $rota=array();
    /*this loop create an bidimensional array of [emplyee_id][date]=>shift_id*/
    foreach ($_POST as $key =>$value){
        if ($key == 'submit'){
            continue;
        }else{
    /*get an array of employee_id,id => date,D_d_m_Y*/
            $employeeDate= explode('-',$key);
    /*get the shift date in format Y-m-d ready for mysql*/
            $date=explode(',',$employeeDate[1]);
            $date=explode("_",$date[1]);
            $date=implode(' ',$date);
            $date=date_create_from_format('D d M Y',$date);
    /*get the employee id*/
            $employeeId=explode(',',$employeeDate[0]);
            $id=$employeeId[1];
            $date=$date->format('Y-m-d');
            $shift=$value;
            $rota[$id][$date]=$value;
        }
    }
    $query='INSERT INTO `schedule_rota` (`shift_id`, `employee_id`, `date`) VALUES ';
        $values='';
    foreach ($rota as $employee=>$value){
        $id=$mysqli->real_escape_string($employee);
        foreach ($value as $date=>$shift_id){
            $date=$mysqli->real_escape_string($date);
            $shift_id=$mysqli->real_escape_string($shift_id);
            $values.="($shift_id,$id,'$date'),";
        }
    }
    $values=rtrim($values,',');
    $query.=$values.';';
    //upload rota into database
    if ($mysqli->query($query)==TRUE){
        echo $twig->render('loader.html.twig',$variables);
        header( 'refresh:1;url=index.php?page=adminrota&rota=complete' );
    }else{
        die($mysqli->error);
    }

}else{
    $variables=include_once __DIR__.'/../templates/arrays/adminrotafoh.php';
    $query="SELECT WEEK(date,1) as week_number
from schedule_rota
join employees on employee_id=id_employee
where department='foh'
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
WHERE department='foh' AND U.users_id=E.user_id AND U.adminaccess='0'";
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
    echo $twig->render($template->getTemplate(),$variables);
}