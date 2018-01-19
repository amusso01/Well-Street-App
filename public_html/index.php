<?php

require_once __DIR__.'/../config/start.php';


$uri= new \Wellstreet\classes\uri($FILE_ROOT);
$template=new Wellstreet\classes\frontcontroller($uri->getUri(),setAllTemplates(__DIR__.'/templates/'),setAllTemplates(__DIR__.'/../app/Wellstreet/classes/'));


if (($_SERVER['REQUEST_METHOD'] === 'POST')){

//    echo $twig->render($template->getTemplate(),require __DIR__.'/templates/arrays/'.$template->getTemplateArray());
    $class=$template->getClass();
    switch ($class){
        case 'login.php':
            $user=new Wellstreet\classes\login($_POST,$mysqli);
            var_dump($user);

    }


}else{
    $render=$template->render();
    echo $twig->render($template->renderTemplate,require __DIR__.'/templates/arrays/'.$render->renderVariables);

}



