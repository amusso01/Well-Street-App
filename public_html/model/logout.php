<?php

session_regenerate_id();
logOut();
echo $twig->render('loader.html.twig',require __DIR__.'/../templates/arrays/'.$template->getArray());
header( 'refresh:2;url=index.php' );