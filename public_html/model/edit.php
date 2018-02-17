<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}elseif(isset($_GET['id'])){
    $id=$mysqli->real_escape_string($_GET['id']);
    $query="SELECT * FROM employees WHERE id_employee=$id";
    $result=$mysqli->query($query);

}