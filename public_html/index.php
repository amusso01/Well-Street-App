<?php

require_once __DIR__.'/../config/start.php';
require_once __DIR__.'/../app/Wellstreet/functions/functions.php';


$uri= new \Wellstreet\classes\uri($FILE_ROOT);
$template=new Wellstreet\classes\frontcontroller(__DIR__.'\templates', $uri->getUri(),setAllTemplates(__DIR__.'/templates/'));



echo $twig->render($template->getTemplate(),array('name'=>$uri->getUri()));

