<?php

function setAllTemplates($path){
    $templateArray=array();
    $handle = opendir($path);
    while(false !== ($file = readdir($handle))){
        $templateArray[]=$file;
    };
    closedir($handle);
    return $templateArray;
}