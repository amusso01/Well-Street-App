<?php


//all the setted paths are relative to the public_html folder

// Set a document root URL.
$FILE_ROOT = '/wellstreet/public_html/';  //set to the web site path when deploy

// Set the media URL (where the media files will be...css, storedImages, js etc)
$MEDIA_URL = 'media/';


//Set the template path
$TEMPLATE_PATH='templates/';


//path of file
$self = htmlentities($_SERVER['PHP_SELF']);



//general setting
date_default_timezone_set('Europe/London');



// database settings
$config['db_user'] = '';
$config['db_pass'] = '';
$config['db_host'] = '';
$config['db_name'] = '';


