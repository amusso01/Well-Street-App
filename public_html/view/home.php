<?php

if(isset($_POST['page'])) {
   $user=new Wellstreet\classes\login($_POST,$mysqli);
   $user->valid();//validate the user
   if($user->errorArray!==0){
       $error=include_once __DIR__.'/../templates/arrays/home.php';
       $toDispalay=array_merge($error,$user->errorArray);
       echo $twig->render($template->getTemplate(),$toDispalay);
   }
}else{
    echo $twig->render($template->getTemplate(),require __DIR__.'/../templates/arrays/'.$template->getArray());
}





