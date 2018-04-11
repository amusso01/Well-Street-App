<?php
if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])) {
    $variables = include_once __DIR__ . '/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig', $variables);
    logOut();
    header('refresh:4;url=index.php');
}else {
    $variables=include_once __DIR__.'/../templates/arrays/userholiday.php';
    $empId=$_SESSION['employee_id'];

    /*==== process the holiday request ====*/

    if (isset($_POST['start'])){
        if ($_POST['start']=='' && $_POST['end']==''){
            $variables['startError']='Please insert the holiday period date';
        }else{
            $start=new DateTime($_POST['start']);
            $end=new DateTime($_POST['end']);
            $now=new DateTime();
            if ($start->getTimestamp()>$end->getTimestamp()){
                $variables['startError']='The ending date cannot be before the starting date period';
            }elseif($start->getTimestamp()<$now->getTimestamp()){
                $variables['startError']='Cannot book day in the past';
            }else{
                $end=addDay($_POST['end']);//add a day to the end date, this is to fix a problem with full calendar plugin. The day must be removed before redisplay it to the user
                $startDate=$mysqli->real_escape_string($_POST['start']);
                $endDate=$mysqli->real_escape_string($end);
                $query="INSERT INTO holiday_request (holiday_start, holiday_end, employee_id, holiday_approved) VALUES ( '$startDate','$endDate', $empId, 'N');";
                if ($mysqli->query($query)){
                    $_POST=array();
                    echo $twig->render('loader.html.twig',$variables);
                    header("refresh:1;url=index.php?page=userholiday&upload=ok");
                    die();
                }else{
                    die($mysqli->error);
                }
            }
        }
    }

    /*==== control and display holiday request pending ====*/

    $events=array();
    $empHoliday=array();
    $query="SELECT H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"N\" and H.employee_id=$empId";
    if ($result=$mysqli->query($query)){
        if ($result->num_rows !== 0){
           while ($row=$result->fetch_assoc()){
               $events['start']=htmlentities($row['holiday_start']);
               $end=removeDay($row['holiday_end']);
               $events['end']=htmlentities($end);
               array_push($empHoliday,$events);
           }
        }
        $variables['holiday']=$empHoliday;
    }else{
        die($mysqli->error);
    }
    $result->free_result();

    /* ==== upload request message ==== */

    if (isset($_GET['upload'])){
        $variables['requested']='Holiday request has been sent';
    }


    /* ==== render the page ==== */

    echo $twig->render($template->getTemplate(),$variables);
}