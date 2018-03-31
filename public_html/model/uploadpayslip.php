<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__ . '/../templates/arrays/uploadpayslip.php';
    $updir=dirname(__FILE__).'/../file_uploaded/payslip/';
    $employeeId=$_GET['id'];
    $variables['employeeId']=$employeeId;
    $year=getWeek(0,'Y');//using an already existing function we get an array of 7 value of the current year
    $variables['year']=$year[0];
    $variables['lastYear']=$year[0]-1;



    /*===========Show Payslip of this and last year==============*/
    $thisYearDir=$updir.'/'.$employeeId.'/'.$year[0];
    $lastYearDir=$updir.'/'.$employeeId.'/'.$variables['lastYear'];
    $thisYearToDisplay=array();
    $lastYearToDisplay=array();
    if (file_exists($thisYearDir)){
        $storeDir=setAllFile($thisYearDir);
        foreach ($storeDir as $item) {
            if ($item=='.'||$item=='..'){
                continue;
            }
            switch ($item){
                case '1':
                    $item='January';
                    break;
                case '2':
                    $item='Febbruary';
                    break;
                case '3':
                    $item='March';
                    break;
                case '4':
                    $item='April';
                    break;
                case '5':
                    $item='May';
                    break;
                case '6':
                    $item='June';
                    break;
                case '7':
                    $item='July';
                    break;
                case '8':
                    $item='August';
                    break;
                case '9':
                    $item='September';
                    break;
                case '10':
                    $item='October';
                    break;
                case '11':
                    $item='November';
                    break;
                case '12':
                    $item='December';
                    break;
            }
            $thisYearToDisplay[]=$item;
        }
        $variables['thisYear']=$thisYearToDisplay;
    }

    if (file_exists($lastYearDir)){
        $lastDir=setAllFile($lastYearDir);
        foreach ($lastDir as $item) {
            if ($item=='.'||$item=='..'){
                continue;
            }
            switch ($item){
                case '1':
                    $item='January';
                    break;
                case '2':
                    $item='Febbruary';
                    break;
                case '3':
                    $item='March';
                    break;
                case '4':
                    $item='April';
                    break;
                case '5':
                    $item='May';
                    break;
                case '6':
                    $item='June';
                    break;
                case '7':
                    $item='July';
                    break;
                case '8':
                    $item='August';
                    break;
                case '9':
                    $item='September';
                    break;
                case '10':
                    $item='October';
                    break;
                case '11':
                    $item='November';
                    break;
                case '12':
                    $item='December';
                    break;
            }
            $lastYearToDisplay[]=$item;
        }
        $variables['pastYear']=$lastYearToDisplay;
    }




        //    Show message correctly uploaded
    if (isset($_SESSION['uploadStatus']) and !isset($_SESSION['controller'])){
        $variables['uploadStatus']=$_SESSION['uploadStatus'];
        $_SESSION['controller']=true;
    }else{
        unset($_SESSION['uploadStatus']);
        unset($_SESSION['controller']);
    }


    /*============= Upload payslip ===============*/
    if (isset($_POST['month'])){
        $month=$_POST['month'];
        $year=$_POST['year'];
        if (isset($_FILES['userfile'])){
            if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
                if($_FILES['userfile']['error']==0){
                    $file = new SplFileInfo($_FILES['userfile']['name']);
                    $upfilename=$file->getFilename();
                    $tmpName = $_FILES['userfile']['tmp_name'];
                    $query = "INSERT INTO `payslip` (`file_name`,`month`,`employee_id`,`year`) VALUES('$upfilename','$month','$employeeId','$year')";
                    $mysqli->real_escape_string($query);
                    if ($mysqli->query($query)) {
                        $id = $mysqli->insert_id;
                        $upfilename = $id.'_'.$upfilename;
                        if (is_dir($updir)){
                            $updir.=$employeeId.'/';
                            if(!file_exists($updir)){
                                mkdir($updir);
                            }
                            $updir.=$year.'/';
                            if (!file_exists($updir)){
                                mkdir($updir);
                            }
                            $updir.=$month.'/';
                            if (!file_exists($updir)){
                                mkdir($updir);
                                $upfilename=$updir.$upfilename;
                                if (move_uploaded_file($tmpName, $upfilename)) {
                                    $_SESSION['uploadStatus'] = 'File correctly uploaded';
                                    echo $twig->render('loader.html.twig',$variables);
                                    header("refresh:1;url=index.php?page=uploadpayslip&id=$employeeId");
                                }else{
                                    $_SESSION['uploadStatus']='Failed to upload please try again';
                                }
                            }else{
                                $variables['payslipExist']='You have already upload the selected month payslip';
                            }
                        }else{
                            die('upload directory missing');
                        }
                    }else{
                        die($mysqli->error);
                    }
                }else {
                    switch ($_FILES['userfile']['error']) {
                        case 1:
                            $error = 'Max file size exceeded';
                        case 2:
                            $error = 'Max file sized exceeded';
                        case 3:
                            $error = 'File uploaded only partially';
                        case 4:
                            $error = 'No file was uploaded';
                        default:
                            $error = 'File not uploaded';
                    }
                    $variables['fileError'] = $error;
                }
            }else{
                $variables['fileError']='You must select a file';
            }
        }
    }


        echo $twig->render($template->getTemplate(),$variables);


}
