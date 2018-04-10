<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables = include_once __DIR__ . '/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig', $variables);
    logOut();
    header('refresh:4;url=index.php');
}else{
    $variables=include_once __DIR__.'/../templates/arrays/holiday.php';

    /*==== retrieve and display holiday request ====*/
    if (isset($_GET['id'])){
        $request=array();
        $holId=$_GET['id'];
        $query="SELECT H.holiday_id,H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"N\" and H.holiday_id=$holId";
        if($result=$mysqli->query($query)){
            if ($result->num_rows==1){
                while ($row=$result->fetch_assoc()){
                    $request['start']=$row['holiday_start'];
                    $request['end']=$row['holiday_end'];
                    $request['name']=$row['name'];
                    $request['surname']=$row['surname'];
                    $request['holiday_id']=$row['holiday_id'];
                }
                $variables['request']=$request;
            }else{
                $variables['hol_id_error']='No holiday request for the chosen ID in the database';
            }
        }else{
            die($mysqli->error);
        }
    }


    echo $twig->render($template->getTemplate(),$variables);
}