<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])){
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_POST['search'])){
    $surname=$mysqli->real_escape_string($_POST['search']);
    // use prepared statements!
    $query ="SELECT * FROM employees E 
JOIN users U on E.user_id=U.users_id
WHERE surname='$surname' AND U.adminaccess='0'";
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
    $result->free();

}elseif(isset($_GET['delete'])){
    $name=htmlentities($_GET['delete']);
    $variables=include_once __DIR__.'/../templates/arrays/search.php';
    $variables['deletionName']=$name;
//    var_dump($variables);
        echo $twig->render($template->getTemplate(),$variables);
}else{
    $variables=include_once __DIR__.'/../templates/arrays/search.php';
    echo $twig->render($template->getTemplate(),$variables);
    //create page in case post['search'] not set
}