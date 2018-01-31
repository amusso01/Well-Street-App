<?php

require_once __DIR__.'/../config/start.php';


$uri= new \Wellstreet\classes\uri($_GET);
$template=new Wellstreet\classes\fileList( $uri->getUri(), setAllFile(__DIR__.'/templates/'), setAllFile(__DIR__.'/templates/arrays/'), setAllFile(__DIR__ . '/view/'));

include $template->displayView();

