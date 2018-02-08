
<?php

if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    echo $twig->render($template->getTemplate(),require __DIR__.'/../templates/arrays/'.$template->getArray());
}