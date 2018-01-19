<?php
session_start();
require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/config.php';
require_once __DIR__.'/dbConnect.php';
require_once __DIR__.'/../app/Wellstreet/functions/functions.php';
$loader = new Twig_Loader_Filesystem(__DIR__ . '/../public_html/templates');
$twig = new Twig_Environment($loader, array(
//    'cache' => '',//todo set a cache folder in production to optimize
    'debug'=>'true'//todo set to false in production
));

