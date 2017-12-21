<?php

// Set a document root URL. May be useful depending how URLs are served.
$FILE_ROOT = '/wellstreet/public/';

// Set the media URL (where the media files will be...css, storedImages, js etc)
$MEDIA_URL = 'media/';


//path of file
$self = htmlentities($_SERVER['PHP_SELF']);


//general setting
date_default_timezone_set('Europe/London');
$config['lang']='en';


// database settings
$config['db_user'] = '';
$config['db_pass'] = '';
$config['db_host'] = '';
$config['db_name'] = '';