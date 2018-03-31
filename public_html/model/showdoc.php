<?php
if (!isset($_SESSION['admin']) || !isset($_SESSION['uName'])) {
    $variables=$variables=include_once __DIR__.'/../templates/arrays/nopriviledge.php';
    echo $twig->render('nopriviledge.html.twig',$variables);
    logOut();
    header( 'refresh:4;url=index.php' );
}else{
    if(isset($_GET['id'])){
        $name = '';
        $variables = $variables = include_once __DIR__ . '/../templates/arrays/showdoc.php';
        $id = $_GET['id'];

        $query = "SELECT * FROM  file_uploaded WHERE `id_info`=$id";
        $result = $mysqli->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $fileArray[] = $row;
            }
        } else {
            die($mysqli->error);
        }
        $result->free();
        $fileName = $fileArray[0]['file_name'];
        $fileName = explode('.', $fileName);
        $extension = array_pop($fileName);
        foreach ($fileName as $value) {
            $name .= $value;
        }
        $variables['name'] = htmlentities($name);
        $variables['fullName'] = htmlentities($fileArray[0]['file_name']);
        $variables['info'] = htmlentities($fileArray[0]['file_info']);
        $downloadName = $fileArray[0]['id_info'] . '_' . $variables['fullName'];
        $variables['downloadName'] = $downloadName;
        $variables['id']=$fileArray[0]['id_info'];

        /*=============  DELETE  ===============*/
        if (isset($_GET['file'])=='delete'){
            $query="DELETE FROM `file_uploaded` WHERE `id_info`=$id";
            if ($mysqli->query($query)){
                unlink(__DIR__ . '/../file_uploaded/documents/' .$downloadName);
                echo $twig->render('loader.html.twig',$variables);
                header( 'refresh:1;url=index.php?page=documents' );
                die();
            }else{
                die($mysqli->error);
            }
        }
        /*===================================*/


        echo $twig->render($template->getTemplate(), $variables);
    }
}