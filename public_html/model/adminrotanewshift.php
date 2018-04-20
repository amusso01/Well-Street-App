<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif (isset($_POST['startTime'])&& isset($_POST['finishTime'])){
    $queryShift="SELECT `start_time`,`finish_time` FROM `shift`";
    $result=$mysqli->query($queryShift);
    if($result==false){
        echo $mysqli->error;
    }else{
        $shift=array();
        while($row =$result->fetch_assoc()){
            foreach ($row as $key =>$value){
                $row[$key]=htmlentities($value);
            }
            $shiftArray[]=$row;
            $shift['shift']=$shiftArray;
        }
    }
    $variables=include_once __DIR__.'/../templates/arrays/adminrotanewshift.php';
    $start=$_POST['startTime'];
    $finish=$_POST['finishTime'];
    if ($start==''&& $finish==''){
        $time['required']='Both start and finish time are required';
        $variables=array_merge($variables,$time);
        $variables=array_merge($variables,$shift);
        echo $twig->render($template->getTemplate(),$variables);
    }elseif($start>$finish){
        $time['required']='Start time must be before finish time';
        $variables=array_merge($variables,$time);
        $variables=array_merge($variables,$shift);
        echo $twig->render($template->getTemplate(),$variables);
    }else{
        $variables=array_merge($variables,$shift);
        $time['required']='Shift added to database';
        $variables=array_merge($variables,$time);
        $difference = round(abs(strtotime($finish) - strtotime($start)) / 60,2);
        $mysqli->real_escape_string($start);
        $mysqli->real_escape_string($finish);
        $mysqli->real_escape_string($difference);
        $query= "INSERT INTO `shift` ( `start_time`, `finish_time`, `shift_length` ) VALUES ('$start','$finish','$difference')";
        $mysqli->query($query);
        echo $twig->render('loader.html.twig',$variables);
        header( 'refresh:1;url=index.php?page=adminrotanewshift' );
    }
}else{
    $queryShift="SELECT `start_time`,`finish_time` FROM `shift`";
    $result=$mysqli->query($queryShift);
    if($result==false){
        echo $mysqli->error;
    }else{
        $shift=array();
        while($row =$result->fetch_assoc()){
            foreach ($row as $key =>$value){
                $row[$key]=htmlentities($value);
            }
            $shiftArray[]=$row;
            $shift['shift']=$shiftArray;
        }
    }
    $variables=include_once __DIR__.'/../templates/arrays/adminrotanewshift.php';
    $variables=array_merge($variables,$shift);
    echo $twig->render($template->getTemplate(),$variables);
}
