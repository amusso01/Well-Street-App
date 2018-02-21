<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__.'/../templates/arrays/adminrotaboh.php';
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

    echo $twig->render('adminrotafoh.html.twig',$variables);
}