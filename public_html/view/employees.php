<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['uname'])&& isset($_POST['pass'])){
    $user=new Wellstreet\classes\validation($_POST,$mysqli);
    $user->validateuser();
    if(isset($user->errorArray)){
        $error=include_once __DIR__.'/../templates/arrays/employees.php';
        $arrayToDisplay=array_merge($error,$user->errorArray);
        echo $twig->render($template->getTemplate(),$arrayToDisplay);
    }else{
        $_SESSION['newUName']=$user->sessionArray['uname'];
        $_SESSION['newPass']=$user->sessionArray['pass'];
        header('location:?page=addemployee');
    }

}else{
    echo $twig->render($template->getTemplate(),require __DIR__.'/../templates/arrays/'.$template->getArray());

}
