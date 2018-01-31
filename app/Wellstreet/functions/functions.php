<?php


//return the file inside the $path directory
function setAllFile($path){
    $fileArray=array();
    $handle = opendir($path);
    while(false !== ($file = readdir($handle))){
        $fileArray[]=$file;
    };
    closedir($handle);
    return $fileArray;
}

//Log out from session. Clean _SESSION array, destroy session and regenerate session
function logOut(){
    $_SESSION = array();
    session_destroy();
}