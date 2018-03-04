<?php
if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else {
    $variables=include_once __DIR__.'/../templates/arrays/userpayslip.php';
    $dir=$_SESSION['employee_id'];
    $updir=dirname(__FILE__).'/../../file_uploaded/payslip/'.$dir;
    if (file_exists($updir)){
        $yearDir=setAllFile($updir);
        foreach ($yearDir as $value){
            if ($value=='.'||$value=='..'){
                continue;
            }else{
                $year[]=$value;
            }
        }
        
        var_dump($year);
    }else{
        $variables['noPayslip']='You don\'t have any payslip in the database yet';
    }
//    echo $twig->render($template->getTemplate(),$variables);
}

