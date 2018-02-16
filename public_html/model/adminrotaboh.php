<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__.'/../templates/arrays/adminrotaboh.php';
    $week['week']=getWeek();
    $variables=array_merge($variables,$week);
    $query ="SELECT id_employee,name,surname FROM employees WHERE department='boh'";
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

    echo $twig->render('adminrotafoh.html.twig',$variables);
}