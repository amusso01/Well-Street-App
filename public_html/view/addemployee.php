<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['email'])){
    $validate=new Wellstreet\classes\validation($_POST,$mysqli);
    $validate->sanitizeEntry();
    $validate->setUser();
    if($validate->valid){
        $newUser=$validate->buildUser();
        $_SESSION['userObj']=serialize($newUser);
        header('location:?page=confirmdetails');
        die();
    }else{
        $variables=include_once __DIR__.'/../templates/arrays/addemployee.php';
        $variables=array_merge($variables,$validate->errorArray);
        echo $twig->render($template->getTemplate(),$variables);
    }
}
else{
    $variables=include_once __DIR__.'/../templates/arrays/addemployee.php';
    $variables=array_merge($variables,$_SESSION);
    echo $twig->render($template->getTemplate(),$variables);

}