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

//Weekly calendar
//parameter how many week from the actual week do you want to add
//for exemple pass 1 return next week, -1 last week
//default = 0 return current week
function getWeek($accumulator=1){
    $lapse=7*24*60*60;
//    if($accumulator>0){
//        for($accumulator;$accumulator>0;$accumulator-1){
//            $lapse+=7*24*60*60;
//        }
//    }elseif($accumulator<0){
//        for($accumulator;$accumulator>0;$accumulator+1){
//            $lapse-=7*24*60*60;
//        }
//    }
    for($i=1;$i<=7;$i++){
            $weekStartDate = (time()-((date('N')-$i)*24*60*60)+ $lapse);
            $day = date('l d', $weekStartDate);
            $week[]=$day;
    }
    return $week;
}