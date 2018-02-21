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

//Weekly calendar return the selected week in format D d M Y example: Mon 26 Feb 2018
//if you would like to change the format output modify the $day date variable
//parameter how many week from the actual week do you want to add
//for exemple pass 1 return next week, -1 last week
//default = 0 return current week
function getWeek($accumulator=1){
    $lapse=7*24*60*60;
    if($accumulator>0){
      $lapse*=$accumulator;
    }elseif($accumulator<0){
        $lapse=($lapse+(7*24*60*60)*$accumulator);
    }
    for($i=1;$i<=7;$i++){
            $weekStartDate = (time()-((date('N')-$i)*24*60*60)+ $lapse);
            $day = date('D d M Y', $weekStartDate);
            $week[]=$day;
    }
    return $week;
}

//Array merge value with same key
function concatArrayKey($arrayToConcat){
//    $newArray=array();
//    foreach ($arrayToConcat as $key => $value){
//
//        $newArray[$key]=$value;
//
//        var_dump($newArray);
//    }
var_dump($arrayToConcat);
}
