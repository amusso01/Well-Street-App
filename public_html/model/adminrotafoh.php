<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['submit'])){
    $rota=array();
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
            var_dump($date->format('Y-m-d'));
            /*get the employee id*/


            $employeeId=explode(',',$employeeDate[0]);
            var_dump($employeeId);
        }
    }


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

    echo $twig->render($template->getTemplate(),$variables);
}