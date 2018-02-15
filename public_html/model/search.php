<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['search'])){
    $surname=$mysqli->real_escape_string($_POST['search']);
    // use prepared statements!
    $query ="SELECT * FROM employees WHERE surname='$surname'";
    $result=$mysqli->query($query);
    if ($result==false){
        echo $mysqli->error;
    }else{
        $users=array();
            while($row=$result->fetch_assoc()){
                foreach ($row as $key=>$value){
                    $row[$key]=htmlentities($value);
                }
                $employeesArray[]=$row;
                $users['users']=$employeesArray;
            }

        $variables=include_once __DIR__.'/../templates/arrays/search.php';
        $variables=array_merge($variables,$users);

        echo $twig->render($template->getTemplate(),$variables);
    }

}else{
    $variables=include_once __DIR__.'/../templates/arrays/search.php';
    echo $twig->render($template->getTemplate(),$variables);
    //create page in case post['search'] not set
}