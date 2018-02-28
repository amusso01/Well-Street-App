<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__ . '/../templates/arrays/communication.php';
    /*========= SET EMAIL RECIPIENTS SUBJECT MESSAGE AND SEND IT ==========*/
    if (isset($_GET['mail'])=='sent'){
        $message=(new Swift_Message());
        $sent=0;
        $message->setFrom(['admin@wellstreetapp.co.uk' => 'Admin']);
        $message->setSubject($_POST['subject']);
        $message->setBody($_POST['message'], 'text/plain');
        $id=array();
        $query='';
        $recipientFlag=false;
        foreach ($_POST as $key=>$value){
            if($value=='employee'){
               $id[]=$key;
               $recipientFlag=true;
            }
        }
        if ($recipientFlag){
            $query="SELECT `email` FROM employees WHERE";
            foreach ($id as $item){
                $query.="(id_employee=$item)OR";
            }
            $query=rtrim($query,'OR');
            if ($result=$mysqli->query($query)){
                while($row=$result->fetch_assoc()){
                    foreach ($row as $value){
                        $message->setTo(trim($value));
                        $sent+=$mailer->send($message);
                    }
                }
                $_SESSION['sentEmail']=$sent;
             }else{
                die($mysqli->error);
             }
            echo $twig->render('loader.html.twig',$variables);
            header( 'refresh:1;url=index.php?page=communication' );
            die();
        }else{
            $variables['error']='You must select at least one recipient';
        }
    }
    /*==================================================================*/

//    Show message of mail correctly sent
    if (isset($_SESSION['sentEmail']) and !isset($_SESSION['controller'])){
        $variables['sentEmail']=$_SESSION['sentEmail'];
        $_SESSION['controller']=true;
    }else{
        unset($_SESSION['sentEmail']);
        unset($_SESSION['controller']);
    }

    /*============= front and back of house employee exclude admin========*/
    $query="SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE department='foh' AND U.users_id=E.user_id AND U.adminaccess='0'";
    $result=$mysqli->query($query);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $employee['employeeFoh'][] = $row;
        }
        $result->free();
        $query = "SELECT E.id_employee,E.name,E.surname 
FROM employees E
JOIN users U 
WHERE department='boh' AND U.users_id=E.user_id AND U.adminaccess='0'";
        if ($result = $mysqli->query($query)) {
            while ($row = $result->fetch_assoc()) {
                $employee['employeeBoh'][] = $row;
            }
            $result->free();
        } else {
            die($mysqli->error);
        }
    }else{
        die($mysqli->error);
    }
    $variables=array_merge($employee,$variables);

    echo $twig->render($template->getTemplate(),$variables);
}