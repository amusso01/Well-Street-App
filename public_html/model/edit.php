<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    echo 'no right to be here redirect in 4 seconds';
    logOut();
    header('refresh:4;url=index.php');
}elseif(isset($_GET['id'])){
    $id=$mysqli->real_escape_string($_GET['id']);
    $query="SELECT * FROM employees WHERE id_employee=$id";
    $result=$mysqli->query($query);

}