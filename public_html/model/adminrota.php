<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables = include_once __DIR__ . '/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig', $variables);
    logOut();
    header('refresh:4;url=index.php');
}else{

    $flagThisWeek=false;
    $flagNextWeek=false;

    $variables = include_once __DIR__ . '/../templates/arrays/adminrota.php';
   /*==========build calendar this and next week===========*/
    $thisWeek['thisWeek']=getWeek(0,'D d M');
    $nextWeek['nextWeek']=getWeek(1,'D d M');
    $variables=array_merge($variables,$thisWeek);
    $variables=array_merge($variables,$nextWeek);

    /*=====set this and next week number=====*/
    $thisWeekNumber=strtotime($thisWeek['thisWeek'][0]);
    $thisWeekNumber=date('W',$thisWeekNumber);
    $nextWeekNumber=strtotime($nextWeek['nextWeek'][0]);
    $nextWeekNumber=date('W',$nextWeekNumber);


    $query="    SELECT concat_ws(' ',E.name,E.surname) as employee,concat_ws('-',R.start_time,R.finish_time) as shift,WEEK(S.date,1) as week_number,S.date,shift_length
FROM schedule_rota S
join employees E on S.employee_id=E.id_employee
join shift R ON S.shift_id=R.id_shift
order by employee,date";

    $result=$mysqli->query($query);
   if ($result){
     while ($row=$result->fetch_assoc()) {

         if ($row['week_number'] == $thisWeekNumber) {
             $rotaThisWeek['currentWeek'][$row['employee']][] = array($row['date'] => $row['shift']);
             $flagThisWeek=true;
         } elseif ($row['week_number'] == $nextWeekNumber) {
             $rotaNextWeek['weekAhead'][$row['employee']][] = array($row['date'] => $row['shift']);
             $flagNextWeek=true;

         }
     }

     if($flagThisWeek) {
         $variables = array_merge($rotaThisWeek, $variables);
     }
       if($flagNextWeek){
           $variables = array_merge($rotaNextWeek, $variables);
       }
   }else{
       die($mysqli->error);
   }
   $result->free_result();

    if(isset($_GET['rota'])=='complete'){
        $variables['RotaUpload']='Rota correctly upload';
        echo $twig->render($template->getTemplate(),$variables);
    }else{
        echo $twig->render($template->getTemplate(),$variables);
    }
}