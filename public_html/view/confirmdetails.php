<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
} elseif(isset($_SESSION['userObj'])&&!isset($_GET['add'])){
    $variables=include_once __DIR__.'/../templates/arrays/confirmdetails.php';
    $userDetails=unserialize($_SESSION['userObj']);
    $user=new Wellstreet\classes\user($userDetails->userDetails,$userDetails->userCredentials);
    $user->setDb($mysqli);
    $details=get_object_vars($user);
    $variables=array_merge($variables,$details);
    echo $twig->render($template->getTemplate(),$variables);
}elseif(isset($_GET['add'])){
    $variables=include_once __DIR__.'/../templates/arrays/confirmdetails.php';
    $variables['add']=$_GET['add'];//add this parameter to the variable array in order to render a different block content
    $userDetails=unserialize($_SESSION['userObj']);
    $user=new Wellstreet\classes\user($userDetails->userDetails,$userDetails->userCredentials);
    $user->setDb($mysqli);
    $user->dbEscape($user->userCredentials);
    $user->dbEscape($user->userDetails);
    $user->pushToDb();


    echo $twig->render($template->getTemplate(),$variables);
}else{
    echo'something went wrong';//todo create a template for this
    logOut();
}