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

//Weekly calendar return the selected week in format D d M Y default example: Mon 26 Feb 2018. Pass another format to change it
//if you would like to change the format output modify the $day date variable
//parameter how many week from the actual week do you want to add
//for exemple pass 1 return next week, -1 last week
//default = 0 return current week
function getWeek($accumulator=1,$format='D d M Y'){
    $lapse=7*24*60*60;
    if($accumulator>0){
      $lapse*=$accumulator;
    }elseif($accumulator<0){
        $lapse=($lapse+(7*24*60*60)*$accumulator);
    }elseif($accumulator==0){
        $lapse=0;
    }
    for($i=1;$i<=7;$i++){
            $weekStartDate = (time()-((date('N')-$i)*24*60*60)+ $lapse);
            $day = date($format, $weekStartDate);
            $week[]=$day;
    }
    return $week;
}
function getWeekNumber($aDate){
    $date=new DateTime($aDate);
    $date->setISODate($date->format('o'), $date->format('W'));
    var_dump($date->format('d-m-Y'));
}

/*

	== PHP FILE TREE ==

	== AUTHOR ==

		Cory S.N. LaViska
		http://abeautifulsite.net/
        refactor to suit the project by Andrea Musso

	== DOCUMENTATION ==
        https://www.abeautifulsite.net/php-file-tree
        http://abeautifulsite.net/notebook.php?article=21

*/

//Adhoc function create for the php file tree script to substitute the number of the month with the name of the directory folder
function month($number){
    switch ($number){
        case '1':
            return 'January';
            break;
        case '2':
            return 'February';
            break;
        case '3':
            return 'March';
            break;
        case '4':
            return 'April';
            break;
        case '5':
            return 'May';
            break;
            case '6':
            return 'June';
            break;
        case '7':
            return 'July';
            break;
        case '8':
            return 'August';
            break;
        case '9':
            return 'September';
            break;
        case '10':
            return 'October';
            break;
        case '11':
            return 'November';
            break;
        case '12':
            return 'December';
            break;
        default:
            return $number;
            break;
    }
}

//ad hoc function create to remove the file_id (ref the database) at the beginning of each payslip file
function rmId($file){
    $fileName='';
    $subFile=explode('_',$file);
    if (count($subFile)==2){
        return $subFile[1];
    }
    foreach ($subFile as $key=>$value){
        if($key==0){
            continue;
        }else{
            $fileName.=$value.'_';
        }
    }
    return rtrim($fileName,'_');
}

//ad hoc function. Create the path to the payslip file for download
function payslipPath ($generalPath, $filePath){
    $path='';
    $pathBits=explode('/',$generalPath);
    $finalPath=array_slice($pathBits,-3,3);
    foreach ($finalPath as $item) {
        $path.=$item.'/';
    }
    $path=rtrim($path,'/');
    return $path.'/'.$filePath;
}


function php_file_tree($directory,$extensions = array()) {
    // Generates a valid XHTML list of all directories, sub-directories, and files in $directory
    // Remove trailing slash
    $code='';
    if( substr($directory, -1) == "/" ) $directory = substr($directory, 0, strlen($directory) - 1);
    $code .= php_file_tree_dir($directory, $extensions);
    return $code;
}

function php_file_tree_dir($directory, $extensions = array(), $first_call = true) {
    // Recursive function called by php_file_tree() to list directories/files
    $php_file_tree='';
    // Get and sort directories/files
    if( function_exists("scandir") ) $file = scandir($directory);
    natcasesort($file);
    // Make directories first
    $files = $dirs = array();
    foreach($file as $this_file) {
        if( is_dir("$directory/$this_file" ) ) $dirs[] = $this_file; else $files[] = $this_file;
    }
    $file = array_merge($dirs, $files);

    // Filter unwanted extensions //We don't need to filter any extension, I will leave this function in case of further developement
    if( !empty($extensions) ) {
        foreach( array_keys($file) as $key ) {
            if( !is_dir("$directory/$file[$key]") ) {
                $ext = substr($file[$key], strrpos($file[$key], ".") + 1);
                if( !in_array($ext, $extensions) ) unset($file[$key]);
            }
        }
    }

    if( count($file) > 2 ) { // Use 2 instead of 0 to account for . and .. "directories"
        $php_file_tree = "<ul";
        if( $first_call ) { $php_file_tree .= " class=\"php-file-tree\""; $first_call = false; }
        $php_file_tree .= ">";
        foreach( $file as $this_file ) {
            if( $this_file != "." && $this_file != ".." ) {
                if( is_dir("$directory/$this_file") ) {

                    // Directory
                    $php_file_tree .= "<li class=\"pft-directory\"><a href=\"#\">" . htmlspecialchars(month($this_file)) . "</a>";
                    $php_file_tree .= php_file_tree_dir("$directory/$this_file",$extensions, false);
                    $php_file_tree .= "</li>";
                } else {
                    // File
                    // Get extension (prepend 'ext-' to prevent invalid classes from extensions that begin with numbers)
                    $ext = "ext-" . substr($this_file, strrpos($this_file, ".") + 1);
                    $filePath=payslipPath($directory,$this_file);
                    $php_file_tree .= "<li class=\"pft-file " . strtolower($ext) . "\"><a href=\"./file_uploaded/payslip/$filePath\" download>" . htmlspecialchars(rmId($this_file)) . "</a></li>";
				}
            }
        }
        $php_file_tree .= "</ul>";
    }
    return $php_file_tree;

}
/*======================== end php file tree =========================*/

function addDay($date){
    $newDate=new DateTime($date);
    $newDate= $newDate->modify('+1 day');
    return $newDate->format('Y-m-d');
}

function removeDay($date){
    $newDate=new DateTime($date);
    $newDate= $newDate->modify('-1 day');
    return $newDate->format('Y-m-d');
}