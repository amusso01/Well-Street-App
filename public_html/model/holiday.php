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
        $query="SELECT H.holiday_id,H.holiday_start,H.holiday_end,H.employee_id,E.name,E.surname,E.email FROM holiday_request H
JOIN employees E ON H.employee_id=E.id_employee
WHERE H.holiday_approved=\"N\" and H.holiday_id=$holId";
        if($result=$mysqli->query($query)){
            if ($result->num_rows==1){
                while ($row=$result->fetch_assoc()){
                    $request['start']=$row['holiday_start'];
                    $end=removeDay($row['holiday_end']);
                    $request['end']=htmlentities($end);
                    $request['name']=htmlentities($row['name']);
                    $request['surname']=htmlentities($row['surname']);
                    $request['holiday_id']=htmlentities($row['holiday_id']);
                    $request['email']=htmlentities($row['email']);
                }
                $variables['request']=$request;
            }else{
                $variables['hol_id_error']='No holiday request for the chosen ID in the database';
            }
        }else{
            die($mysqli->error);
        }


        /*===== approve or refuse holiday request =====*/
        $name=$request['name'];
        $start=$request['start'];
        $end=$request['end'];
        if (isset($_GET['approve'])){
            $holId=$_GET['id'];
            $mailMessage=(new Swift_Message('Holiday request'));//create new email message
            $mailMessage->setFrom(['admin@wellstreetapp.co.uk' => 'Admin']);
            $mailMessage->setTo($request['email']);
            if ($_GET['approve']=='y'){
                $query="UPDATE holiday_request SET holiday_approved = 'Y' WHERE holiday_id = $holId;";
                if($mysqli->query($query)){
                    $mailMessage->setBody("Dear $name,\r\n\r\nYour holiday request for Well Street Kitchen from $start to $end has been approved.\r\n\r\nRegards\r\nAdmin",'text/plain');
                    $mailer->send($mailMessage);

                    echo $twig->render('loader.html.twig',$variables);
                    header( 'refresh:1;url=index.php?page=holiday&update_request=update' );
                    die();
                }else{
                    die($mysqli->error);
                }
            }else{
                $query="DELETE FROM holiday_request WHERE holiday_id = $holId;";
                if ($mysqli->query($query)){
                    $mailMessage->setBody("Dear $name,\r\n\r\nI am sorry to inform you that your holiday request for Well Street Kitchen from $start to $end has been refused.\r\nPlease visit your holiday web page to make a new request.\r\n\r\nRegards\r\nAdmin",'text/plain');
                    $mailer->send($mailMessage);

                    echo $twig->render('loader.html.twig',$variables);
                    header( 'refresh:1;url=index.php?page=holiday&update_request=delete' );
                    die();
                }else{
                    die($mysqli->error);
                }
            }
        }
    }

    if (isset($_GET['update_request'])){
        if ($_GET['update_request']=='update'){
            $variables['update_request']='Holiday request has been approved email notification sent to employee';
        }elseif($_GET['update_request']=='delete'){
            $variables['update_request']='Holiday request has been refused email notification sent to employee';
        }
    }


echo $twig->render($template->getTemplate(),$variables);

}