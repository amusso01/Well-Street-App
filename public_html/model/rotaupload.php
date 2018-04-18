<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables = include_once __DIR__ . '/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig', $variables);
    logOut();
    header('refresh:4;url=index.php');
}elseif(isset($_POST['submit'])) {
    $variables=include_once __DIR__.'/../templates/arrays/rotaupload.php';
    $rota = array();
    /*this loop create a bidimensional array of [employee_id][date]=>shift_id*/
    foreach ($_POST as $key => $value) {
        if ($key == 'submit') {
            continue;
        } else {
            /*get an array of employee_id,id => date,D_d_m_Y*/
            $employeeDate = explode('-', $key);
            /*get the shift date in format Y-m-d ready for mysql*/
            $date = explode(',', $employeeDate[1]);
            $date = explode("_", $date[1]);
            $date = implode(' ', $date);
            $date = date_create_from_format('D d M Y', $date);
            /*get the employee id*/
            $employeeId = explode(',', $employeeDate[0]);
            $id = $employeeId[1];
            $date = $date->format('Y-m-d');
            $shift = $value;
            $rota[$id][$date] = $value;
        }
    }
    $query = 'INSERT INTO `schedule_rota` (`shift_id`, `employee_id`, `date`) VALUES ';
    $values = '';
    foreach ($rota as $employee => $value) {
        $id = $mysqli->real_escape_string($employee);
        foreach ($value as $date => $shift_id) {
            $date = $mysqli->real_escape_string($date);
            $shift_id = $mysqli->real_escape_string($shift_id);
            $values .= "($shift_id,$id,'$date'),";
        }
    }
    $values = rtrim($values, ',');
    $query .= $values . ';';
    //upload rota into database
    if ($mysqli->query($query) == TRUE) {
        echo $twig->render('loader.html.twig', $variables);
        header('refresh:1;url=index.php?page=adminrota&rota=complete');
    } else {
        die($mysqli->error);
    }
}else{
    $variables=include_once __DIR__.'/../templates/arrays/rotaupload.php';
    // import shift
    $query ="SELECT * FROM shift";
    $result=$mysqli->query($query);
    if ($result==false){
        die($mysqli->error);
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
    $result->free();
    $variables=array_merge($variables,$shift);
//    create this week calendar
    $thisWeek['week']=getWeek(0);
    $variables=array_merge($variables,$thisWeek);
/*====== both department to upload ======*/
    if($_GET['dep']=='both'){
        //import employees
        $query ="SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE U.users_id=E.user_id AND U.adminaccess='0'";
        if($result=$mysqli->query($query)){
            $users = array();
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $row[$key] = htmlentities($value);
                }
                $employeesArray[] = $row;
                $users['users'] = $employeesArray;
            }
            $variables=array_merge($variables,$users);
        }else{
            die($mysqli->error);
        }
        $result->free();

        echo $twig->render($template->getTemplate(),$variables);
    }
/*====== foh to upload only =======*/
    elseif ($_GET['dep']=='foh'){
        //import foh employees
        $query ="SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE U.users_id=E.user_id AND U.adminaccess='0' AND department='foh'";
        if($result=$mysqli->query($query)){
            $users = array();
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $row[$key] = htmlentities($value);
                }
                $employeesArray[] = $row;
                $users['users'] = $employeesArray;
            }
            $variables=array_merge($variables,$users);
        }else{
            die($mysqli->error);
        }
        $result->free();

        echo $twig->render($template->getTemplate(),$variables);
    }
/*====== boh to upload only ======*/
    else{
        //import boh employees
        $query ="SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE U.users_id=E.user_id AND U.adminaccess='0' AND department='boh'";
        if($result=$mysqli->query($query)){
            $users = array();
            while ($row = $result->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $row[$key] = htmlentities($value);
                }
                $employeesArray[] = $row;
                $users['users'] = $employeesArray;
            }
            $variables=array_merge($variables,$users);
        }else{
            die($mysqli->error);
        }
        $result->free();

        echo $twig->render($template->getTemplate(),$variables);
    }

}