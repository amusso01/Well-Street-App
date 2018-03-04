<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_GET['id'])){
    $variables=include_once __DIR__.'/../templates/arrays/edit.php';
    $id=$mysqli->real_escape_string($_GET['id']);
    $query="SELECT * FROM employees WHERE id_employee=$id";
    $result=$mysqli->query($query);
    if ($result){
        $address='';
        while ($row=$result->fetch_assoc()){
                $employee['employee']=$row;
        }
    foreach ($employee as  $value){
            foreach ($value as $key=>$item){
                if($key=='address'){
                    $piece=explode(',',$item);
                    foreach ($piece as $i){
                        if($i!==' '){
                            $address.=$i.',';
                        }
                    }
                    $address=rtrim($address,',');
                    $item=htmlentities($address);
                }
                $details[$key]=htmlentities($item);
            }
    }
    }else{
        die($mysqli->error);
    }
    $variables=array_merge($variables,$details);
    echo $twig->render($template->getTemplate(),$variables);
}else{
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}