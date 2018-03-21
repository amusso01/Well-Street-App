<?php
if ( !isset($_SESSION['user']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else {
    $variables=include_once __DIR__.'/../templates/arrays/userpayslip.php';
    $dir=$_SESSION['employee_id'];
    $monthDir='';
    if (file_exists($updir=dirname(__FILE__).'/../../file_uploaded/payslip/'.$dir.'/')){
        $html=php_file_tree($updir);
        $variables['html_tree']=$html;
    }else{
        $variables['noPayslip']='You don\'t have any payslip in the database yet';
    }

    echo $twig->render($template->getTemplate(),$variables);
}

