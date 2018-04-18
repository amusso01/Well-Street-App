
<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__.'/../templates/arrays/admin.php';
    /*==== holiday report ====*/
    $events=array();
    $empHoliday=array();
    $query="SELECT H.holiday_id,H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"N\"";
    if ($result=$mysqli->query($query)){
        if ($result->num_rows !== 0){
            while ($row=$result->fetch_assoc()){
                $events['start']=htmlentities($row['holiday_start']);
                $end=removeDay($row['holiday_end']);
                $events['end']=htmlentities($end);
                $events['holiday_id']=htmlentities($row['holiday_id']);
                $events['name']=htmlentities($row['name']);
                $events['surname']=htmlentities($row['surname']);
                array_push($empHoliday,$events);
            }
        }
        $variables['holiday']=$empHoliday;
    }else{
        die($mysqli->error);
    }
    $result->free_result();

    /*==== employee report ====*/
    $foh=0;
    $boh=0;
    $query ="SELECT * FROM employees E 
JOIN users U on E.user_id=U.users_id
WHERE  U.adminaccess='0'";
    if ($result=$mysqli->query($query)){
        if ($result->num_rows!==0){
            $variables['employee_number']=$result->num_rows;
            while ($row=$result->fetch_assoc()){
                if ($row['department']=='foh'){
                    $foh+=1;
                }else{
                    $boh+=1;
                }
            }
            $variables['employee_foh']=$foh;
            $variables['employee_boh']=$boh;
        }else{
            $variables['employee_number']=0;
        }
    }else{
        die($mysqli->error);
    }

    /*==== rota report =====*/

    $nextWeek=getWeek(1,'Y-m-d');
    $nextMonday=$nextWeek[0];

    $query="SELECT S.date,E.department FROM schedule_rota S
JOIN employees E on S.employee_id=E.id_employee
WHERE date = '$nextMonday';";

    $foh=false;
    $boh=false;
//    control if there is boh and foh rota upload for next week in the db
    if ($result=$mysqli->query($query)){
        while ($row=$result->fetch_assoc()){
            if ($row['department']=='boh'){
                $boh=true;
            }elseif ($row['department']=='foh'){
                $foh=true;
            }
        }
    }else{
        die($mysqli->error);
    }
    $result->free();

    $variables['bohUpload']=$boh;
    $variables['fohUpload']=$foh;

//    control if there is boh and foh rota upload for this week in the db

    $thisWeek=getWeek(0,'Y-m-d');
    $thisMonday=$thisWeek[0];
    $foh=false;
    $boh=false;

    $query="SELECT S.date,E.department FROM schedule_rota S
JOIN employees E on S.employee_id=E.id_employee
WHERE date = '$thisMonday';";

    if ($result=$mysqli->query($query)){
        while ($row=$result->fetch_assoc()){
            if ($row['department']=='boh'){
                $boh=true;
            }elseif ($row['department']=='foh'){
                $foh=true;
            }
        }
    }else{
        die($mysqli->error);
    }
    $result->free();

    if ($boh==true && $foh==true){
        $variables['thisWeek']=true;
    }else{
        if ($foh==false && $boh==false){
            $variables['thisWeekToUpload']='both';
        }elseif($foh==false){
            $variables['thisWeekToUpload']='foh';
        }else{
            $variables['thisWeekToUpload']='boh';
        }
    }

    echo $twig->render($template->getTemplate(),$variables);
}