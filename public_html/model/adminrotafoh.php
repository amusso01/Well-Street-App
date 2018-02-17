<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__.'/../templates/arrays/adminrotafoh.php';
    if (isset($_GET['week'])){
        if($_GET['direction']=="next"){
            $weekNumber=$_GET['week']+1;
        }else{
            $weekNumber=$_GET['week']-1;
        }
        $week['week']=getWeek($weekNumber);
        $variables['weekNumber']=$weekNumber;
    }else{
        $week['week']=getWeek();
        $variables['weekNumber']=1;
    }
    $variables=array_merge($variables,$week);
    $query ="SELECT id_employee,name,surname FROM employees WHERE department='foh'";
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

    echo $twig->render($template->getTemplate(),$variables);
}