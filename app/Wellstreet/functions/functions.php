<?php

function setAllTemplates($path){
    $templateArray=array();
    $handle = opendir($path);
    while(false !== ($file = readdir($handle))){
        if (($file == ".") || ($file == "..") || ($file=="base.html.twig")) {//skip the . and .. file and the base template file
            continue;
        }else{
            $templateArray[]=$file;}
    };
    closedir($handle);
    return $templateArray;
}