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
    $updir=dirname(__FILE__).'/../../file_uploaded/payslip/'.$dir.'/';
    $html=php_file_tree($updir );
//    echo $html;
//    if (file_exists($updir)){
//        $yearDir=setAllFile($updir);
//        foreach ($yearDir as $value){
//            if ($value=='.'||$value=='..'){
//                continue;
//            }else{
//                $year[$value]=$value;
//            }
//        }
//        foreach ($year as $key=>$value){
//            $monthDir=$updir;
//            $monthDir.=$value;
//            $secondDir[$key]=scandir($monthDir);
//            $monthDir='';
//        }
//        foreach ($secondDir as $index => $item){
//            foreach ($item as $key=>$value){
//                if ($value==('.')||$value=='..'){
//                    continue;
//                }else{
//                    $month[$index][]=$value;
//                }
//            }
//        }
//        var_dump($month);
//        var_dump($year);
//    }else{
//        $variables['noPayslip']='You don\'t have any payslip in the database yet';
//    }
    echo $twig->render($template->getTemplate(),$variables);
}

