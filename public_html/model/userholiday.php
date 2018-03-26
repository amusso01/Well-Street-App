<?php
if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else {
    $variables=include_once __DIR__.'/../templates/arrays/userholiday.php';

    echo $twig->render($template->getTemplate(),$variables);
}