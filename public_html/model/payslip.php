<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    $variables=include_once __DIR__ . '/../templates/arrays/payslip.php';
    $employee=array();
    $query ="SELECT E.id_employee,concat_ws(' ',E.name,E.surname  ) as employee
FROM employees E
JOIN users U 
WHERE U.users_id=E.user_id AND U.adminaccess='0'";
    if ($result=$mysqli->query($query)){
        while ($row=$result->fetch_assoc()){
                $employee[]=$row;
        }
        $result->free();
        $variables['employee']=$employee;

    }else{
        die($mysqli->error);
    }



    echo $twig->render($template->getTemplate(),$variables);
}