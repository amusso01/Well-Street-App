<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=$variables=include_once __DIR__ . '/../templates/arrays/communication.php';
    echo $twig->render($template->getTemplate(),$variables);
}