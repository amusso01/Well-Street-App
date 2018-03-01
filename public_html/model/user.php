<?php

if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $username=$_SESSION['uName'];
    $query="SELECT name as employee, username
FROM users U
JOIN employees E ON U.users_id=E.user_id 
WHERE username='$username'";
    if($result=$mysqli->query($query)){
        if ($result->num_rows==1){
            while ($row=$result->fetch_assoc()){
                foreach ($row as $key=>$value){
                    if($key=='employee'){
                        $_SESSION['employee']=$value;
                    }
                }
            }

        }else{
            die('Contact your Admin there are two users with same username');
        }
    }else{
        die($mysqli->error);
    }




    echo $twig->render($template->getTemplate(),require __DIR__.'/../templates/arrays/'.$template->getArray());

}
